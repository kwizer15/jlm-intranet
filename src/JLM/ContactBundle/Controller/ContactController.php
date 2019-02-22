<?php

namespace JLM\ContactBundle\Controller;

use JLM\ContactBundle\Form\Type\AssociationType;
use JLM\ContactBundle\Form\Type\CompanyType;
use JLM\ContactBundle\Form\Type\PersonType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends Controller
{
    /**
     * Edit or add a contact
     *
     * @param int|string $id The entity identifier or typeof new entity
     *
     * @return Response
     */
    public function editAction($id): Response
    {
        $formTypeMap = [
            'person' => PersonType::class,
            'company' => CompanyType::class,
            'association' => AssociationType::class
        ];
        $manager = $this->container->get('jlm_contact.contact_manager');
        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        if (array_key_exists($id, $formTypeMap)) {
            $formType = $id;
            $formName = 'new';
            $entity = null;
        } else {
            $entity = $manager->getEntity($id);
            $formName = 'edit';
            $formType = $entity->getType();
        }
        $form = $manager->createForm($formName, ['type' => $formType, 'entity' => $entity]);
        $process = $manager->getHandler($form, $entity)->process();

        if ($manager->getRequest()->isXmlHttpRequest()) {
            return $process
                ? $manager->renderJson(['ok' => true])
                : $manager->renderResponse('JLMContactBundle:Contact:modal_new.html.twig', ['form' => $form->createView()]);
        }

        return $process
            ? $manager->redirect('jlm_contact_contact_show', ['id' => $form->getData()->getId()])
            : $manager->renderResponse('JLMContactBundle:Contact:new.html.twig', ['form' => $form->createView()]);
    }

    public function listAction()
    {
        $manager = $this->container->get('jlm_contact.contact_manager');
        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        $request = $manager->getRequest();
        $ajax = $manager->getRequest()->isXmlHttpRequest();
        $repo = $manager->getRepository();

        return $ajax || $request->get('format') == 'json'
            ? $manager->renderJson(
                ['contacts' => $repo->getArray($request->get('q', ''), $request->get('page_limit', 10))]
            )
            : $manager->renderResponse(
                'JLMContactBundle:Contact:list.html.twig',
                $manager->pagination('getCountAll', 'getAll', 'jlm_contact_contact', [])
            );
    }

    public function showAction($id)
    {
        $manager = $this->container->get('jlm_contact.contact_manager');
        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        $entity = $manager->getEntity($id);

        return $manager->getRequest()->isXmlHttpRequest()
            ? $manager->renderJson($manager->getRepository()->getByIdToArray($id))
            : $manager->renderResponse(
                'JLMContactBundle:Contact:show_' . $entity->getType() . '.html.twig',
                ['entity' => $entity]
            );
    }

    public function unactiveAction($id)
    {
        $manager = $this->container->get('jlm_contact.contact_manager');
        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        $entity = $manager->getEntity($id);
        $entity->setActive(false);

        $em = $manager->getObjectManager();
        $em->persist($entity);
        $em->flush();

        $manager->getSession()->setFlash('notice', 'Contact ' . $entity->getName() . ' désactivé');

        return $manager->redirectReferer();
    }
}

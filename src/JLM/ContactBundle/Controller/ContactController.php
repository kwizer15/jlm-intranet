<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ContactBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Person controller.
 */
class ContactController extends Controller
{
    /**
     * Edit or add a contact
     *
     * @param int|string $id The entity identifier or typeof new entity
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse|\Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction($id)
    {
        $manager = $this->container->get('jlm_contact.contact_manager');
        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        if (in_array($id, ['person', 'company', 'association'])) {
            $type = $id;
            $id = null;
            $formName = 'new';
            $entity = null;
        } else {
            $entity = $manager->getEntity($id);
            $formName = 'edit';
            $type = $entity->getType();
        }
        $form = $manager->createForm($formName, ['type' => $type, 'entity' => $entity]);
        $process = $manager->getHandler($form, $entity)->process();

        return $manager->getRequest()->isXmlHttpRequest()
            ? ($process
                ? $manager->renderJson(['ok' => true])
                : $manager->renderResponse(
                    'JLMContactBundle:Contact:modal_new.html.twig',
                    ['form' => $form->createView()]
                ))
            : ($process ? $manager->redirect('jlm_contact_contact_show', ['id' => $form->getData()->getId()])
                : $manager->renderResponse('JLMContactBundle:Contact:new.html.twig', ['form' => $form->createView()]));
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

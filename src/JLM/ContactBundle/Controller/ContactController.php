<?php

namespace JLM\ContactBundle\Controller;

use JLM\ContactBundle\Entity\Association;
use JLM\ContactBundle\Entity\Company;
use JLM\ContactBundle\Entity\Contact;
use JLM\ContactBundle\Entity\Person;
use JLM\ContactBundle\Form\Type\AssociationType;
use JLM\ContactBundle\Form\Type\CompanyType;
use JLM\ContactBundle\Form\Type\PersonType;
use JLM\ContactBundle\Repository\ContactRepository;
use JLM\CoreBundle\Form\Handler\DoctrineHandler;
use JLM\CoreBundle\Service\Pagination;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends Controller
{
    /**
     * @param Request $request
     * @param string $type
     *
     * @return Response
     */
    public function addAction(Request $request, string $type): Response
    {
        $formFactory = $this->container->get('form.factory');
        $router = $this->container->get('router');
        $templating = $this->container->get('templating');
        $doctrine = $this->container->get('doctrine.orm.entity_manager');

        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $formTypeMap = [
            'person' => PersonType::class,
            'company' => CompanyType::class,
            'association' => AssociationType::class
        ];

        $form = $formFactory->create($formTypeMap[$type], null, [
            'method' => 'POST',
            'action' => $router->generate('jlm_contact_contact_create', ['type' => $type]),
            'label' => 'Créer',
        ]);

        $handler = new DoctrineHandler($form, $request, $doctrine);
        $process = $handler->process();
        $ajax = $request->isXmlHttpRequest();

        if (!$process) {
            $view = $ajax ? 'JLMContactBundle:Contact:modal_new.html.twig' : 'JLMContactBundle:Contact:new.html.twig';

            return $templating->renderResponse($view, ['form' => $form->createView()]);
        }

        return $ajax
            ? new JsonResponse(['ok' => true])
            : new RedirectResponse($router->generate('jlm_contact_contact_show', ['id' => $form->getData()->getId()]))
        ;
    }

    /**
     * @param Request $request
     * @param int $id
     *
     * @return Response
     */
    public function editAction(Request $request, $id): Response
    {
        $formFactory = $this->container->get('form.factory');
        $doctrine = $this->container->get('doctrine.orm.entity_manager');
        /** @var ContactRepository $repository */
        $repository = $doctrine->getRepository(Contact::class);
        $router = $this->container->get('router');
        $templating = $this->container->get('templating');

        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $entity = $repository->get($id);

        $formTypeMap = [
            Person::class => PersonType::class,
            Company::class => CompanyType::class,
            Association::class => AssociationType::class
        ];

        $form = $formFactory->create($formTypeMap[\get_class($entity)], $entity, [
            'method' => 'POST',
            'action' => $router->generate('jlm_contact_contact_update', ['id' => $entity->getId()]),
            'label' => 'Modifier',
        ]);

        $handler = new DoctrineHandler($form, $request, $doctrine, $entity);
        $process = $handler->process();
        $ajax = $request->isXmlHttpRequest();

        if (!$process) {
            $view = $ajax ? 'JLMContactBundle:Contact:modal_new.html.twig' : 'JLMContactBundle:Contact:new.html.twig';

            return $templating->renderResponse($view, ['form' => $form->createView()]);
        }

        return $ajax
            ? new JsonResponse(['ok' => true])
            : new RedirectResponse($router->generate('jlm_contact_contact_show', ['id' => $form->getData()->getId()]))
        ;
    }

    public function listAction(Request $request)
    {
        $templating = $this->container->get('templating');
        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        $ajax = $request->isXmlHttpRequest();
        /** @var ContactRepository $repository */
        $repository = $this->get('doctrine')->getRepository(Contact::class);

        if ($ajax || $request->get('format') === 'json') {
            return new JsonResponse(
                ['contacts' => $repository->getArray($request->get('q', ''), $request->get('page_limit', 10))]
            );
        }

        $paginator = new Pagination($request, $repository);
        $pagination = $paginator->paginate('getCountAll', 'getAll', 'jlm_contact_contact');

        return $templating->renderResponse('JLMContactBundle:Contact:list.html.twig', $pagination);
    }

    public function showAction(Request $request, $id)
    {
        $templating = $this->container->get('templating');
        /** @var ContactRepository $repository */
        $repository = $this->get('doctrine')->getRepository(Contact::class);
        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        $entity = $repository->get($id);

        return $request->isXmlHttpRequest()
            ? new JsonResponse($repository->getByIdToArray($id))
            : $templating->renderResponse(
                'JLMContactBundle:Contact:show_' . $entity->getType() . '.html.twig',
                ['entity' => $entity]
            );
    }

    public function unactiveAction(Request $request, $id): RedirectResponse
    {
        $objectManager = $this->get('doctrine');
        /** @var ContactRepository $repository */
        $repository = $objectManager->getRepository(Contact::class);
        $session = $this->container->get('session');

        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        $entity = $repository->get($id);
        $entity->setActive(false);

        $objectManager->persist($entity);
        $objectManager->flush();

        $session->getFlashBag()->add('notice', 'Contact ' . $entity->getName() . ' désactivé');

        return new RedirectResponse($request->headers->get('referer'));
    }
}

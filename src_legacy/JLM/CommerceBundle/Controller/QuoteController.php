<?php

namespace JLM\CommerceBundle\Controller;

use JLM\CommerceBundle\Entity\Quote;
use JLM\CommerceBundle\Form\Type\QuoteType;
use JLM\CoreBundle\Event\FormPopulatingEvent;
use JLM\CoreBundle\Repository\SearchRepositoryInterface;
use JLM\CoreBundle\Service\Pagination;
use JLM\ModelBundle\Entity\Mail;
use JLM\ModelBundle\Form\Type\MailType;
use JLM\CommerceBundle\JLMCommerceEvents;
use JLM\CommerceBundle\Event\QuoteEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class QuoteController extends Controller
{
    /**
     * Lists all Quote entities.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction(Request $request): Response
    {
        $templating = $this->container->get('templating');
        $repository = $this->container->get('doctrine')->getRepository(Quote::class);

        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        $states = [
            'all' => 'All',
            'in_seizure' => 'InSeizure',
            'waiting' => 'Waiting',
            'sended' => 'Sended',
            'given' => 'Given',
            'canceled' => 'Canceled',
        ];
        $state = $request->get('state');
        $state = (!array_key_exists($state, $states)) ? 'all' : $state;
        $views = [
            'index' => 'Liste',
            'follow' => 'Suivi',
        ];
        $view = $request->get('view');
        $view = (!array_key_exists($view, $views)) ? 'index' : $view;

        $method = $states[$state];

        $paginator = new Pagination($request, $repository);
        $pagination = $paginator->paginate('getCount' . $method, 'get' . $method, 'quote', ['state' => $state, 'view' => $view]);

        return $templating->renderResponse(
            '@JLMCommerce/quote/' . $view . '.html.twig',
            $pagination
        );
    }

    /**
     * Finds and displays a Quote entity.
     */
    public function showAction($id)
    {
        $templating = $this->container->get('templating');
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $repository = $this->get('doctrine')->getRepository(Quote::class);

        $entity = $repository->find($id);

        return $templating->renderResponse(
            '@JLMCommerce/quote/show.html.twig',
            ['entity' => $entity]
        );
    }

    /**
     * Nouveau devis
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function newAction(Request $request)
    {
        $entityManager = $this->container->get('doctrine.orm.entity_manager');
        $vatRepository = $entityManager->getRepository('JLMCommerceBundle:VAT');
        $router = $this->container->get('router');
        $templating = $this->container->get('templating');
        $formFactory = $this->container->get('form.factory');
        $eventDispatcher = $this->container->get('event_dispatcher');
        $tokenStorage = $this->container->get('security.token_storage');

        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $form = $formFactory->create(QuoteType::class, null, [
            'method' => 'POST',
            'action'  => $router->generate('quote_create'),
        ]);
        $form->add('submit', SubmitType::class, ['label' => 'Modifier']);

        $eventDispatcher->dispatch(JLMCommerceEvents::QUOTE_FORM_POPULATE, new FormPopulatingEvent($form, $request));

        $vat = $vatRepository->find(1)->getRate();
        $params = [
            'creation'       => new \DateTime(),
            'vat'            => $vat,
            'vatTransmitter' => $vat,
            'followerCp'     => $tokenStorage->getToken()->getUser()->getContact()->getName(),
        ];
        foreach ($params as $key => $value) {
            $param = $form->get($key)->getData();
            if (empty($param)) {
                $form->get($key)->setData($value);
            }
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entity = $form->getData();
            $entityManager->persist($entity);
            $entityManager->flush();
            $eventDispatcher->dispatch(JLMCommerceEvents::QUOTE_AFTER_PERSIST, new QuoteEvent($entity, $request));

            return new RedirectResponse($router->generate('quote_show', ['id' => $entity->getId()]));
        }

        return $templating->renderResponse(
            '@JLMCommerce/quote/new.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * Displays a form to edit an existing Quote entity.
     *
     * @param Request $request
     * @param $id
     *
     * @return Response
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function editAction(Request $request, $id): Response
    {
        $entityManager = $this->container->get('doctrine.orm.entity_manager');
        $repository = $entityManager->getRepository(Quote::class);
        $router = $this->container->get('router');
        $templating = $this->container->get('templating');
        $formFactory = $this->container->get('form.factory');

        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        $entity = $repository->find($id);
        $this->assertState($entity, [0]);
        $form = $formFactory->create(QuoteType::class, $entity, [
            'method' => 'POST',
            'action'  => $router->generate('quote_update', ['id' => $entity->getId()]),
        ]);
        $form->add('submit', SubmitType::class, ['label' => 'Modifier']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($entity);
            $entityManager->flush();

            return new RedirectResponse($router->generate('quote_show', ['id' => $form->getData()->getId()]));
        }

        return $templating->renderResponse(
            '@JLMCommerce/quote/edit.html.twig',
            [
                'entity' => $entity,
                'edit_form' => $form->createView(),
            ]
        );
    }

    /**
     * Resultats de la barre de recherche.
     *
     * @param Request $request
     *
     * @return
     */
    public function searchAction(Request $request)
    {
        $templating = $this->container->get('templating');
        $entityManager = $this->container->get('doctrine.orm.entity_manager');
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $template = '@JLMCommerce/quote/search.html.twig';
        $formData = $request->get('jlm_core_search');

        if (\is_array($formData) && array_key_exists('query', $formData)) {
            $repository = $entityManager->getRepository(Quote::class);
            if ($repository instanceof SearchRepositoryInterface) {
                return $templating->renderResponse(
                    $template,
                    [
                        'results' => $repository->search($formData['query']),
                        'query' => $formData['query'],
                    ]
                );
            }
        }

        return $templating->renderResponse($template, ['results' => [], 'query' => '']);
    }

    /**
     * Imprimer toute les variantes
     */
    public function printAction($id)
    {
        $manager = $this->container->get('jlm_commerce.quote_manager');
        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        $entity = $manager->getEntity($id);
        $filename = $entity->getNumber() . '.pdf';

        return $manager->renderPdf(
            $filename,
            '@JLMCommerce/quote/quote.pdf.php',
            ['entities' => [$entity->getVariants()]]
        );
    }

    /**
     * Imprimer la chemise
     */
    public function jacketAction($id)
    {
        $manager = $this->container->get('jlm_commerce.quote_manager');
        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        $entity = $manager->getEntity($id);
        $filename = $entity->getNumber() . '-jacket.pdf';

        return $manager->renderPdf($filename, '@JLMCommerce/quote/jacket.pdf.php', ['entity' => $entity]);
    }

    /**
     * Mail
     */
    public function mailAction($id)
    {
        $templating = $this->container->get('templating');
        $manager = $this->container->get('jlm_commerce.quote_manager');
        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        $entity = $manager->getEntity($id);
        $this->assertState($entity, [1, 2, 3, 4, 5]);
        $mail = new Mail();
        $mail->setSubject('Devis n°' . $entity->getNumber());
        $mail->setFrom('commerce@jlm-entreprise.fr');
        $mail->setBody($templating->renderView('@JLMCommerce/quote/email.txt.twig', ['entity' => $entity]));
        $mail->setSignature(
            $templating->renderView(
                '@JLMCommerce/quote_variant/emailsignature.txt.twig',
                ['name' => $entity->getFollowerCp()]
            )
        );
        if ($entity->getContact()) {
            if ($entity->getContact()->getPerson()) {
                if ($entity->getContact()->getPerson()->getEmail()) {
                    $mail->setTo($entity->getContact()->getPerson()->getEmail());
                }
            }
        }
        $form = $manager->getFormFactory()->create(MailType::class, $mail);

        return $manager->renderResponse(
            '@JLMCommerce/quote/mail.html.twig',
            [
                'entity' => $entity,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * Send by mail a QuoteVariant entity.
     *
     * @param Request $request
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function sendmailAction(Request $request, $id)
    {
        $manager = $this->container->get('jlm_commerce.quote_manager');
        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        $entity = $manager->getEntity($id);
        $this->assertState($entity, [1, 2, 3, 4, 5]);
        // Message
        $mail = new Mail();
        $form = $manager->getFormFactory()->create(MailType::class, $mail);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $mail->setBcc('commerce@jlm-entreprise.fr');

            $message = $mail->getSwift();
            $message->setReadReceiptTo('commerce@jlm-entreprise.fr');
            //          $eventComment = 'Destinataire : '.$mail->getTo();
            //          if ($mail->getCc())
            //          {
            //              $eventComment .= chr(10).'Copie : '.$mail->getCc();
            //          }
            //          $eventComment .= chr(10).'Pièces jointes :';
            foreach ($entity->getVariants() as $variant) {
                if ($variant->getState() > 0) {
                    $message->attach(
                        \Swift_Attachment::newInstance(
                            $manager->renderResponse(
                                '@JLMCommerce/quote/quote.pdf.php',
                                ['entities' => [$variant]]
                            ),
                            $variant->getNumber() . '.pdf',
                            'application/pdf'
                        )
                    );
                    //                  $eventComment .= chr(10).'- Devis n°'.$variant->getNumber();
                    $variant->setState(3);
                }
            }
            if ($entity->getVat() == $entity->getVatTransmitter()) {
                $message->attach(
                    \Swift_Attachment::fromPath(
                        $this->container->get('kernel')->getRootDir(
                        ) . '/../web/bundles/jlmcommerce/pdf/attestation.pdf'
                    )
                );
                //              $eventComment .= chr(10).'- Attestation TVA à 10%';
            }

            //$entity->addEvent(Quote::EVENT_SEND, $eventComment);
            $manager->getMailer()->send($message);
            $em = $manager->getObjectManager();
            $em->persist($entity);
            $em->flush();
        }

        return $manager->redirect('quote_show', ['id' => $entity->getId()]);
    }

    private function assertState($quote, $states = [])
    {
        $router = $this->container->get('router');
        if (!\in_array($quote->getState(), $states, true)) {
            return new RedirectResponse($router->generate('quote_show', ['id' => $quote->getId()]));
        }
    }
}

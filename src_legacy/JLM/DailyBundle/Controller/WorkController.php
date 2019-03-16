<?php

namespace JLM\DailyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\DailyBundle\Entity\Work;
use JLM\DailyBundle\Form\Type\WorkType;
use JLM\DailyBundle\Form\Type\WorkEditType;
use JLM\DailyBundle\Form\Type\WorkCloseType;
use JLM\ModelBundle\Entity\Door;
use JLM\CommerceBundle\Entity\QuoteVariant;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use JLM\CoreBundle\Factory\MailFactory;
use JLM\CoreBundle\Form\Type\MailType;
use JLM\CoreBundle\Builder\MailSwiftMailBuilder;
use JLM\ModelBundle\JLMModelEvents;
use JLM\ModelBundle\Event\DoorEvent;
use JLM\DailyBundle\Builder\Email\WorkPlannedMailBuilder;
use JLM\DailyBundle\Builder\Email\WorkOnSiteMailBuilder;
use JLM\DailyBundle\Builder\Email\WorkEndMailBuilder;

/**
 * Work controller.
 *
 */
class WorkController extends AbstractInterventionController
{
    /**
     * List the works
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request)
    {
        $manager = $this->container->get('jlm_daily.work_manager');
        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        $repo = $manager->getRepository();

        return $request->isXmlHttpRequest()
            ? $manager->renderJson(
                [
                    'entities' => $repo->getArray(
                        $request->get('q', ''),
                        $request->get('page_limit', 10)
                    ),
                ]
            )
            : $manager->renderResponse(
                '@JLMDaily/work/list.html.twig',
                $manager->pagination($request, 'getCountOpened', 'getOpened', 'work_list', [])
            );
    }

    /**
     * Finds and displays a Work entity.
     *
     * @Template()
     */
    public function showAction(Work $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        return $this->show($entity);
    }

    /**
     * Displays a form to create a new Work entity.
     *
     * @Template("@JLMDaily/work/new.html.twig")
     */
    public function newdoorAction(Door $door)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $entity = new Work();
        $entity->setDoor($door);
        $entity->setPlace($door . '');
        $form = $this->createForm(WorkType::class, $entity);

        return [
            'entity' => $entity,
            'form' => $form->createView(),
        ];
    }

    /**
     * Displays a form to create a new Work entity.
     *
     * @Template()
     */
    public function newAction()
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $entity = new Work();
        $form = $this->createForm(WorkType::class, $entity);

        return [
            'entity' => $entity,
            'form' => $form->createView(),
        ];
    }

    /**
     * Displays a form to create a new Work entity.
     *
     * @Template("@JLMDaily/work/new.html.twig")
     */
    public function newquoteAction(QuoteVariant $quote)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $entity = new Work();
        $entity->setQuote($quote);
        $door = $quote->getQuote()->getDoor();
        $entity->setDoor($door);
        $entity->setPlace($quote->getQuote()->getDoorCp());
        $entity->setReason($quote->getIntro());
        $contact = $quote->getQuote()->getContact();
        if ($contact === null) {
            $entity->setContactName($quote->getQuote()->getContactCp());
        } else {
            $entity->setContactName($contact->getPerson()->getName() . ' (' . $contact->getRole() . ')');
            $mobilePhone = $contact->getPerson()->getMobilePhone();
            $fixedPhone = $contact->getPerson()->getFixedPhone();
            $email = $contact->getPerson()->getEmail();
            $phones = '';
            if ($mobilePhone != null) {
                $phones .= $mobilePhone;
            }
            if ($fixedPhone != null) {
                if ($phones != '') {
                    $phones .= chr(10);
                }
                $phones .= $fixedPhone;
            }
            if ($email != null) {
                $entity->setContactEmail($email);
            }
            $entity->setContactPhones($phones);
        }
        $form = $this->createForm(WorkType::class, $entity);

        return [
            'entity' => $entity,
            'form' => $form->createView(),
        ];
    }

    /**
     * Creates a new Work entity.
     *
     * @Template("@JLMDaily/work/new.html.twig")
     */
    public function createAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $entity = new Work();

        $form = $this->createForm(WorkType::class, $entity);
        $entity->setCreation(new \DateTime());
        $entity->setPriority(4);
        $form->handleRequest($request);
        $entity->setContract($entity->getDoor()->getActualContract());
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();


            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('work_show', ['id' => $entity->getId()]));
        }

        return [
            'entity' => $entity,
            'form' => $form->createView(),
        ];
    }

    /**
     * Displays a form to edit an existing Work entity.
     *
     * @Template()
     */
    public function editAction(Work $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $editForm = $this->createForm(WorkEditType::class, $entity);

        return [
            'entity' => $entity,
            'form' => $editForm->createView(),
        ];
    }

    /**
     * Edits an existing Work entity.
     *
     * @Template("@JLMDaily/work/edit.html.twig")
     */
    public function updateAction(Request $request, Work $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $em = $this->getDoctrine()->getManager();

        $editForm = $this->createForm(WorkEditType::class, $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('work_show', ['id' => $entity->getId()]));
        }

        return [
            'entity' => $entity,
            'form' => $editForm->createView(),
        ];
    }

    /**
     * Close an existing Work entity.
     *
     * @Template()
     */
    public function closeAction(Work $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $form = $this->createForm(WorkCloseType::class, $entity);

        return [
            'entity' => $entity,
            'form' => $form->createView(),
        ];
    }

    /**
     * Close an existing Work entity.
     *
     * @Template()
     */
    public function closeupdateAction(Request $request, Work $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $form = $this->createForm(WorkCloseType::class, $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if ($entity->getObjective()->getId() == 1) {  // Mise en service
                $stop = $entity->getDoor()->getLastStop();
                if ($stop !== null) {
                    $stop->setEnd(new \DateTime());
                    $em->persist($stop);
                }
                $em->persist($entity->getDoor());
            }
            $entity->setClose(new \DateTime());
            $entity->setMustBeBilled($entity->getQuote() !== null);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('work_show', ['id' => $entity->getId()]));
        }

        return [
            'entity' => $entity,
            'form' => $form->createView(),
        ];
    }

    /**
     * Finds and displays a InterventionPlanned entity.
     *
     * @Template()
     */
    public function emailAction(Request $request, Work $entity, $step)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $steps = [
            'planned' => WorkPlannedMailBuilder::class,
            'onsite' => WorkOnSiteMailBuilder::class,
            'end' => WorkEndMailBuilder::class,
        ];
        $class = (array_key_exists($step, $steps)) ? $steps[$step] : null;
        if (null === $class) {
            throw new NotFoundHttpException('Page inexistante');
        }
        $mail = MailFactory::create(new $class($entity));
        $editForm = $this->createForm(MailType::class, $mail);
        $editForm->handleRequest($request);
        if ($editForm->isValid()) {
            $this->get('mailer')->send(MailFactory::create(new MailSwiftMailBuilder($editForm->getData())));
            $this->get('event_dispatcher')->dispatch(
                JLMModelEvents::DOOR_SENDMAIL,
                new DoorEvent($entity->getDoor(), $request)
            )
            ;

            return $this->redirect($this->generateUrl('work_show', ['id' => $entity->getId()]));
        }

        return [
            'entity' => $entity,
            'form' => $editForm->createView(),
            'step' => $step,
        ];
    }
}

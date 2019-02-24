<?php

namespace JLM\DailyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\DailyBundle\Entity\Fixing;
use JLM\DailyBundle\Form\Type\FixingType;
use JLM\DailyBundle\Form\Type\FixingEditType;
use JLM\DailyBundle\Form\Type\FixingCloseType;
use JLM\ModelBundle\Entity\Door;
use JLM\ModelBundle\Entity\DoorStop;
use Symfony\Component\HttpFoundation\JsonResponse;
use JLM\CoreBundle\Form\Type\MailType;
use JLM\CoreBundle\Factory\MailFactory;
use JLM\CoreBundle\Builder\MailSwiftMailBuilder;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use JLM\ModelBundle\JLMModelEvents;
use JLM\ModelBundle\Event\DoorEvent;
use JLM\DailyBundle\Builder\Email\FixingDistributedMailBuilder;
use JLM\DailyBundle\Builder\Email\FixingOnSiteMailBuilder;
use JLM\DailyBundle\Builder\Email\FixingEndMailBuilder;
use JLM\DailyBundle\Builder\Email\FixingReportMailBuilder;

/**
 * Fixing controller.
 */
class FixingController extends AbstractInterventionController
{
    /**
     * Finds and displays a InterventionPlanned entity.
     *
     * @Template()
     */
    public function listAction()
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('JLMDailyBundle:Fixing')->getPrioritary();
        return ['entities' => $entities];
    }

    /**
     * Finds and displays a InterventionPlanned entity.
     *
     * @Template()
     */
    public function emailAction(Request $request, Fixing $entity, $step)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $steps = [
            'taken' => \JLM\DailyBundle\Builder\Email\FixingTakenMailBuilder::class,
            'distributed' => FixingDistributedMailBuilder::class,
            'onsite' => FixingOnSiteMailBuilder::class,
            'end' => FixingEndMailBuilder::class,
            'report' => FixingReportMailBuilder::class,
        ];
        $class = $steps[$step] ?? null;
        if (null === $class) {
            throw new NotFoundHttpException('Page inexistante');
        }
        $mail = MailFactory::create(new $class($entity));
        $editForm = $this->createForm(MailType::class, $mail);
        $editForm->handleRequest($request);
        if ($editForm->isValid()) {
            $this->get('mailer')->send(MailFactory::create(new MailSwiftMailBuilder($editForm->getData())));
            $this
                ->get('event_dispatcher')
                ->dispatch(JLMModelEvents::DOOR_SENDMAIL, new DoorEvent($entity->getDoor(), $request))
            ;

            return $this->redirect($this->generateUrl('fixing_show', ['id' => $entity->getId()]));
        }

        return [
            'entity' => $entity,
            'form' => $editForm->createView(),
            'step' => $step,
        ];
    }

    /**
     * Finds and displays a InterventionPlanned entity.
     *
     * @Template()
     */
    public function showAction(Fixing $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        return $this->show($entity);
    }

    /**
     * Displays a form to create a new InterventionPlanned entity.
     *
     * @Template()
     */
    public function newAction(Door $door)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        /*
      * Voir aussi
      *   DoorController:stoppedAction
       *   DefaultController:searchAction
     * TODO: A factoriser
       */
        $entity = new Fixing();
        $entity->setDoor($door);
        $entity->setAskDate(new \DateTime());
        $form = $this->get('form.factory')->createNamed('fixingNew' . $door->getId(), FixingType::class, $entity);
        return [
            'door' => $door,
            'entity' => $entity,
            'form' => $form->createView(),
        ];
    }

    /**
     * Creates a new InterventionPlanned entity.
     *
     * @Template()
     */
    public function createAction(Request $request, Door $door)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $entity = new Fixing();
        $entity->setCreation(new \DateTime());
        $entity->setDoor($door);
        $entity->setContract($door->getActualContract());
        $entity->setPlace($door . '');
        $entity->setPriority(2);
        $form = $this->get('form.factory')->createNamed('fixingNew' . $door->getId(), FixingType::class, $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            if ($request->isXmlHttpRequest()) {
                return new JsonResponse(['id' => $entity->getId()]);
            }
            return $this->redirect($this->generateUrl('fixing_show', ['id' => $entity->getId()]));
        }

        return [
            'door' => $door,
            'entity' => $entity,
            'form' => $form->createView(),
        ];
    }

    /**
     * Displays a form to edit an existing Fixing entity.
     *
     * @Template()
     */
    public function editAction(Fixing $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $editForm = $this->createForm(FixingEditType::class, $entity);

        return [
            'entity' => $entity,
            'form' => $editForm->createView(),
        ];
    }

    /**
     * Edits an existing Fixing entity.
     *
     * @Template("JLMDailyBundle:Fixing:edit.html.twig")
     */
    public function updateAction(Request $request, Fixing $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $editForm = $this->createForm(FixingEditType::class, $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('fixing_show', ['id' => $entity->getId()]));
        }

        return [
            'entity' => $entity,
            'form' => $editForm->createView(),
        ];
    }

    /**
     * Close an existing Fixing entity.
     *
     * @Template()
     */
    public function closeAction(Fixing $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $form = $this->createForm(FixingCloseType::class, $entity);

        return [
            'entity' => $entity,
            'form' => $form->createView(),
        ];
    }

    /**
     * Close an existing Fixing entity.
     *
     * @Template()
     */
    public function closeupdateAction(Request $request, Fixing $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $form = $this->createForm(FixingCloseType::class, $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            // Mise à l'arrêt
            if ($entity->getDone()->getId() == 3) {
                $stop = $entity->getDoor()->getLastStop();
                if ($stop === null) {
                    $stop = new DoorStop();
                    $stop->setBegin(new \DateTime());
                    $stop->setState('Non traitée');
                }
                $stop->setReason($entity->getReport());
                $entity->getDoor()->addStop($stop);
                $em->persist($stop);
            }

            $entity->setClose(new \DateTime());
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('fixing_show', ['id' => $entity->getId()]));
        }

        return [
            'entity' => $entity,
            'form' => $form->createView(),
        ];
    }

    /**
     * Imprime le rapport d'intervention
     */
    public function printdayAction(Fixing $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $response = new Response();
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'inline; filename=report-' . $entity->getId() . '.pdf');
        $response->setContent(
            $this->render(
                'JLMDailyBundle:Fixing:printreport.pdf.php',
                ['entity' => $entity]
            )
        );

        return $response;
    }
}

<?php

namespace JLM\DailyBundle\Controller;

use JLM\CoreBundle\Service\Pagination;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\DailyBundle\Entity\Maintenance;
use JLM\DailyBundle\Entity\Ride;
use JLM\DailyBundle\Entity\ShiftTechnician;
use JLM\DailyBundle\Form\Type\AddTechnicianType;
use JLM\DailyBundle\Form\Type\MaintenanceCloseType;
use JLM\ModelBundle\Entity\Door;
use JLM\CoreBundle\Factory\MailFactory;
use JLM\ModelBundle\JLMModelEvents;
use JLM\ModelBundle\Event\DoorEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use JLM\CoreBundle\Form\Type\MailType;
use JLM\CoreBundle\Builder\MailSwiftMailBuilder;
use JLM\DailyBundle\Builder\Email\MaintenancePlannedMailBuilder;
use JLM\DailyBundle\Builder\Email\MaintenanceOnSiteMailBuilder;
use JLM\DailyBundle\Builder\Email\MaintenanceEndMailBuilder;
use JLM\DailyBundle\Builder\Email\MaintenanceReportMailBuilder;

/**
 * Maintenance controller.
 */
class MaintenanceController extends AbstractInterventionController
{
    /**
     * Finds and displays a InterventionPlanned entity.
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        $repository = $this->container->get('doctrine')->getRepository(Maintenance::class);

        if ($request->isXmlHttpRequest()) {
            return new JsonResponse([
                'entities' => $repository->getArray(
                    $request->get('q', ''),
                    $request->get('page_limit', 10)
                ),
            ]);
        }

        $paginator = new Pagination($this->getRequest(), $repository);
        $pagination = $paginator->paginate('getCountOpened', 'getOpened', 'maintenance_list', []);

        $templating = $this->container->get('templating');

        return $templating->renderResponse('JLMDailyBundle:Maintenance:list.html.twig', $pagination);
    }

    /**
     * Finds and displays a Maintenance entity.
     *
     * @Template()
     */
    public function showAction(Maintenance $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        return $this->show($entity);
    }

    /**
     * Close an existing Fixing entity.
     *
     * @Template()
     */
    public function closeAction(Maintenance $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $form = $this->createForm(MaintenanceCloseType::class, $entity);

        return [
            'entity' => $entity,
            'form' => $form->createView(),
        ];
    }

    /**
     * Close an existing Maintenance entity.
     *
     * @Template()
     */
    public function closeupdateAction(Request $request, Maintenance $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(MaintenanceCloseType::class, $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $entity->setClose(new \DateTime());
            $entity->setMustBeBilled(false);
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('maintenance_show', ['id' => $entity->getId()]));
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
     * @param Request     $request
     * @param Maintenance $entity
     * @param             $step
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function emailAction(Request $request, Maintenance $entity, $step)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $steps = [
            'planned' => MaintenancePlannedMailBuilder::class,
            'onsite' => MaintenanceOnSiteMailBuilder::class,
            'end' => MaintenanceEndMailBuilder::class,
            'report' => MaintenanceReportMailBuilder::class,
        ];
        $class = array_key_exists($step, $steps) ? $steps[$step] : null;
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

            return $this->redirect($this->generateUrl('maintenance_show', ['id' => $entity->getId()]));
        }
        return [
            'entity' => $entity,
            'form' => $editForm->createView(),
            'step' => $step,
        ];
    }

    /**
     * Creation des entretiens a faire
     *
     * @Template()
     */
    public function scanAction()
    {
        $date = new \DateTime();
        $date->sub(new \DateInterval('P6M'));
        $em = $this->getDoctrine()->getManager();
        $doors = $em->getRepository('JLMModelBundle:Door')->findAll();
        $count = 0;
        $removed = 0;
        foreach ($doors as $door) {
            $maint = $door->getNextMaintenance();
            $contract = $door->getActualContract();
            if ($contract !== null) {
                if ($door->getLastMaintenance() < $date
                    && $maint === null
                    && $door->getCountMaintenance() < 2
                ) {
                    $main = new Maintenance();
                    $main->setCreation(new \DateTime());
                    $main->setPlace($door . '');
                    $main->setReason('Visite d\'entretien');
                    $main->setContract($door->getActualContract());
                    $main->setDoor($door);
                    $main->setPriority(5);
                    $main->setPublished(true);
                    //$main->setMustBeBilled(false);
                    $em->persist($main);
                    $count++;
                } elseif ($door->getLastMaintenance() > $limi && $maint !== null) {
                    $limi = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-01-01 00:00:00');
                    $em->remove($maint);
                    $removed++;
                }
            } elseif ($contract === null && $maint !== null) {
                // On retire les entretiens plus sous contrat
                $shifts = $maint->getShiftTechnicians();
                if (sizeof($shifts) > 0) {
                    $maint->setClosed();
                    $maint->setReport('Cloturé pour rupture de contrat');
                } else {
                    $em->remove($maint);
                }
                $removed++;
            }
        }
        $em->flush();

        return [
            'count' => $count,
            'removed' => $removed,
        ];
    }

    /**
     * Cherche les entretiens les plus proche d'une adresse
     *
     * @Template()
     */
    public function neighborAction(Door $door)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $em = $this->getDoctrine()->getManager();

        // Choper les entretiens à faire
        $repo = $em->getRepository('JLMDailyBundle:Maintenance');
        $maints = $repo->getOpened();
        $repo = $em->getRepository('JLMDailyBundle:Ride');
        $baseUrl = 'http://maps.googleapis.com/maps/api/distancematrix/json?sensor=false&language=fr-FR&origins='
            . $door->getCoordinates()
            . '&destinations=';
        foreach ($maints as $maint) {
            $dest = $maint->getDoor();
            if (!$repo->hasRide($door, $dest)) {
                $url = $baseUrl . $dest->getCoordinates();
                $string = file_get_contents($url);
                $json = json_decode($string);
                if ($json->status == 'OK'
                    && isset($json->rows[0]->elements[0]->duration->value)
                    && isset($json->rows[0]->elements[0]->duration->value)
                ) {
                    $ride = new Ride();
                    $ride->setDeparture($door);
                    $ride->setDestination($dest);
                    $ride->setDuration($json->rows[0]->elements[0]->duration->value);
                    $ride->setDistance($json->rows[0]->elements[0]->distance->value);
                    $em->persist($ride);
                }
            }
        }
        $em->flush();
        $entities = $repo->getMaintenanceNeighbor($door, 30);
        $forms = [];
        foreach ($entities as $entity) {
            $shift = new ShiftTechnician();
            $shift->setBegin(new \DateTime());
            $forms[] = $this->get('form.factory')->createNamed(
                'shiftTechNew' . $entity->getDestination()->getNextMaintenance()->getId(),
                new AddTechnicianType(),
                $shift
            )->createView()
            ;
        }

        return [
            'door' => $door,
            'entities' => $entities,
            'forms_addTech' => $forms,
        ];
    }
}

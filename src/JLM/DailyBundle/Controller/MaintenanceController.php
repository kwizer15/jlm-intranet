<?php
namespace JLM\DailyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\DailyBundle\Entity\Maintenance;
use JLM\DailyBundle\Entity\Ride;
use JLM\DailyBundle\Entity\ShiftTechnician;
use JLM\DailyBundle\Form\Type\AddTechnicianType;
use JLM\DailyBundle\Form\Type\MaintenanceCloseType;
use JLM\DailyBundle\Form\Type\ExternalBillType;
use JLM\DailyBundle\Form\Type\InterventionCancelType;
use JLM\DailyBundle\Form\Type\ShiftingEditType;
use JLM\ModelBundle\Entity\Door;
use JLM\CoreBundle\Factory\MailFactory;
use JLM\ModelBundle\JLMModelEvents;
use JLM\ModelBundle\Event\DoorEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use JLM\CoreBundle\Form\Type\MailType;
use JLM\CoreBundle\Builder\MailSwiftMailBuilder;


/**
 * Maintenance controller.
 */
class MaintenanceController extends AbstractInterventionController
{
	/**
	 * Finds and displays a InterventionPlanned entity.
	 */
	public function listAction()
	{
		$manager = $this->container->get('jlm_daily.maintenance_manager');
		$manager->secure('ROLE_OFFICE');
		$request = $manager->getRequest();
		$repo = $manager->getRepository();

		return $manager->isAjax() ? $manager->renderJson(array('entities' => $repo->getArray($request->get('q',''), $request->get('page_limit',10))))
		                  : $manager->renderResponse('JLMDailyBundle:Maintenance:list.html.twig', $manager->pagination('getCountOpened', 'getOpened', 'maintenance_list', array()));
	}

	/**
	 * Finds and displays a Maintenance entity.
	 *
	 * @Template()
	 * @Secure(roles="ROLE_OFFICE")
	 */
	public function showAction(Maintenance $entity)
	{
		return $this->show($entity);
	}

	/**
	 * Close an existing Fixing entity.
	 *
	 * @Template()
	 * @Secure(roles="ROLE_OFFICE")
	 */
	public function closeAction(Maintenance $entity)
	{
		$form = $this->createForm(new MaintenanceCloseType(), $entity);

		return array(
				'entity'      => $entity,
				'form'   => $form->createView(),
		);
	}

	/**
	 * Close an existing Maintenance entity.
	 *
	 * @Template()
	 * @Secure(roles="ROLE_OFFICE")
	 */
	public function closeupdateAction(Request $request, Maintenance $entity)
	{
		$em = $this->getDoctrine()->getManager();

		$form = $this->createForm(new MaintenanceCloseType(), $entity);
		$form->handleRequest($request);

		if ($form->isValid())
		{
			$entity->setClose(new \DateTime);
			$entity->setMustBeBilled(false);
			$em->persist($entity);
			$em->flush();
			return $this->redirect($this->generateUrl('maintenance_show', array('id' => $entity->getId())));
		}

		return array(
				'entity'      => $entity,
				'form'   => $form->createView(),
		);
	}

	/**
	 * Finds and displays a InterventionPlanned entity.
	 *
	 * @Template()
	 * @Secure(roles="ROLE_OFFICE")
	 */
	public function emailAction(Maintenance $entity, $step)
	{
		$request = $this->getRequest();
		$steps = array(
				'planned' => 'JLM\DailyBundle\Builder\Email\MaintenancePlannedMailBuilder',
				'onsite' => 'JLM\DailyBundle\Builder\Email\MaintenanceOnSiteMailBuilder',
				'end' => 'JLM\DailyBundle\Builder\Email\MaintenanceEndMailBuilder',
				'report' => 'JLM\DailyBundle\Builder\Email\MaintenanceReportMailBuilder',
		);
		$class = (array_key_exists($step, $steps)) ? $steps[$step] : null;
		if (null === $class)
		{
			throw new NotFoundHttpException('Page inexistante');
		}
		$mail = MailFactory::create(new $class($entity));
		$editForm = $this->createForm(new MailType(), $mail);
		$editForm->handleRequest($request);
		if ($editForm->isValid())
		{
			$this->get('mailer')->send(MailFactory::create(new MailSwiftMailBuilder($editForm->getData())));
			$this->get('event_dispatcher')->dispatch(JLMModelEvents::DOOR_SENDMAIL, new DoorEvent($entity->getDoor(), $request));

			return $this->redirect($this->generateUrl('maintenance_show', array('id' => $entity->getId())));
		}
		return array(
				'entity' => $entity,
				'form' => $editForm->createView(),
				'step' => $step,
		);
	}

	/**
	 * Creation des entretiens a faire
	 *
	 * @Template()
	 */
	public function scanAction()
	{
		$date = new \DateTime;
		$date->sub(new \DateInterval('P6M'));
		$em = $this->getDoctrine()->getManager();
		$doors = $em->getRepository('JLMModelBundle:Door')->findAll();
		$count = 0;
		$removed = 0;
		foreach ($doors as $door)
		{
			$maint = $door->getNextMaintenance();
			$contract = $door->getActualContract();
			if ($contract !== null)
			{
				if ($door->getLastMaintenance() < $date
						&& $maint === null
						&& $door->getCountMaintenance() < 2)
				{
					$main = new Maintenance;
					$main->setCreation(new \DateTime);
					$main->setPlace($door.'');
					$main->setReason('Visite d\'entretien');
					$main->setContract($door->getActualContract());
					$main->setDoor($door);
					$main->setPriority(5);
					$main->setPublished(true);
					//$main->setMustBeBilled(false);
					$em->persist($main);
					$count++;
				}
				$limi = new \DateTime::createFromFormat('Y-m-d H:i:s','2017-01-01 00:00:00')
				elseif ($door->getLastMaintenance() > $limi && $maint !== null) {
					$em->remove($maint);
					$removed++;
				}
			}
			// On retire les entretiens plus sous contrat
			elseif ($contract === null && $maint !== null)
			{
				$shifts = $maint->getShiftTechnicians();
				if (sizeof($shifts) > 0)
				{
					$maint->setClosed();
					$maint->setReport('Cloturé pour rupture de contrat');
				}
				else
					$em->remove($maint);
				$removed++;
			}
		}
		$em->flush();

		return array('count' => $count,'removed' => $removed);
	}

	/**
	 * Cherche les entretiens les plus proche d'une adresse
	 *
	 * @Template()
	 * @Secure(roles="ROLE_OFFICE")
	 */
	public function neighborAction(Door $door)
	{
		$em = $this->getDoctrine()->getManager();

		// Choper les entretiens à faire
		$repo = $em->getRepository('JLMDailyBundle:Maintenance');
		$maints = $repo->getOpened();
		$repo = $em->getRepository('JLMDailyBundle:Ride');
		$baseUrl = 'http://maps.googleapis.com/maps/api/distancematrix/json?sensor=false&language=fr-FR&origins='.$door->getCoordinates().'&destinations=';
		foreach ($maints as $maint)
		{
			$dest = $maint->getDoor();
			if (!$repo->hasRide($door,$dest))
			{
				$url = $baseUrl.$dest->getCoordinates();
				$string = file_get_contents($url);
				$json = json_decode($string);
				if ($json->status == 'OK' && isset($json->rows[0]->elements[0]->duration->value) && isset($json->rows[0]->elements[0]->duration->value))
				{
					$ride = new Ride;
					$ride->setDeparture($door);
					$ride->setDestination($dest);
					$ride->setDuration($json->rows[0]->elements[0]->duration->value);
					$ride->setDistance($json->rows[0]->elements[0]->distance->value);
					$em->persist($ride);
				}
			}
		}
		$em->flush();
		$entities = $repo->getMaintenanceNeighbor($door,30);
		$forms = array();
		foreach ($entities as $entity)
		{
			$shift = new ShiftTechnician();
			$shift->setBegin(new \DateTime);
			$forms[] = $this->get('form.factory')->createNamed('shiftTechNew'.$entity->getDestination()->getNextMaintenance()->getId(),new AddTechnicianType(), $shift)->createView();
		}

		return array(
				'door'=>$door,
				'entities' => $entities,
				'forms_addTech' => $forms,
		);
	}
}

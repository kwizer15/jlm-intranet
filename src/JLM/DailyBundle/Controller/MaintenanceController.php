<?php
namespace JLM\DailyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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


/**
 * Maintenance controller.
 *
 * @Route("/maintenance")
 */
class MaintenanceController extends AbstractInterventionController
{
	/**
	 * Finds and displays a InterventionPlanned entity.
	 *
	 * @Route("/list", name="maintenance_list")
	 * @Route("/list/{page}", name="maintenance_list_page")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function listAction($page = 1)
	{
		// @todo Trier par ville, date...
		return $this->pagination('JLMDailyBundle:Maintenance','Opened',$page,10,'maintenance_list_page');
	}
	
	/**
	 * Finds and displays a Maintenance entity.
	 *
	 * @Route("/{id}/show", name="maintenance_show")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function showAction(Maintenance $entity)
	{
		return $this->show($entity);
	}
	
	/**
	 * Close an existing Fixing entity.
	 *
	 * @Route("/{id}/close", name="maintenance_close")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
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
	 * @Route("/{id}/closeupdate", name="maintenance_closeupdate")
	 * @Method("POST")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function closeupdateAction(Request $request, Maintenance $entity)
	{
		$em = $this->getDoctrine()->getManager();
			
		$form = $this->createForm(new MaintenanceCloseType(), $entity);
		$form->handleRequest($request);
	
		if ($form->isValid())
		{
			$entity->setClose(new \DateTime);
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
	 * Creation des entretiens a faire
	 *
	 * @Route("/scan", name="maintenance_scan")
	 * @Template()
	 */
	public function scanAction()
	{
		$date = new \DateTime;
		$date->sub(new \DateInterval('P4M'));
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
					$main->setMustBeBilled(false);
					$em->persist($main);
					$count++;
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
	 * @Route("/neighbor/{id}", name="maintenance_neighbor")
	 * @Template()
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
		$entities = $repo->getMaintenanceNeighbor($door,15);
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

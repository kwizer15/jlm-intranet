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
use JLM\ModelBundle\Entity\Door;

/**
 * Maintenance controller.
 *
 * @Route("/maintenance")
 */
class MaintenanceController extends Controller
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
		$limit = 15;
		$em = $this->getDoctrine()->getEntityManager();
		$nb = $em->getRepository('JLMDailyBundle:Maintenance')->getCountOpened();
		$nbPages = ceil($nb/$limit);
		$nbPages = ($nbPages < 1) ? 1 : $nbPages;
		$offset = ($page-1) * $limit;
		if ($page < 1 || $page > $nbPages)
		{
			throw $this->createNotFoundException('Page inexistante (page '.$page.'/'.$nbPages.')');
		}
		

		$em = $this->getDoctrine()->getManager();
		$entities = $em->getRepository('JLMDailyBundle:Maintenance')->getPrioritary($limit,$offset);
		return array(
				'entities'      => $entities,
				'page'     => $page,
				'nbPages'  => $nbPages,
		);
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
		$st = new ShiftTechnician();
		$st->setBegin(new \DateTime);
		$form   = $this->createForm(new AddTechnicianType(), $st);
		$form_externalbill = $this->createForm(new ExternalBillType(), $entity);
		$form_cancel = $this->createForm(new InterventionCancelType(), $entity);
		return array(
				'entity' => $entity,
				'form_newtech'   => $form->createView(),
				'form_externalbill' => $form_externalbill->createView(),
				'form_cancel' => $form_cancel->createView(),
		);
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
		$form->bind($request);
	
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
		$date->sub(new \DateInterval('P5M'));
		$em = $this->getDoctrine()->getEntityManager();
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
	 * Purge entretiens RIVP
	 *
	 * @Route("/purgerivp", name="maintenance_purgerivp")
	 * @Template()
	 */
	public function purgerivpAction()
	{
		$em = $this->getDoctrine()->getEntityManager();
		$repotrustee = $em->getRepository('JLMModelBundle:Trustee');
		$repomain = $em->getRepository('JLMDailyBundle:Maintenance');
		$mains = $repomain->createQueryBuilder('a')
			->select('a,b,c')
			->leftJoin('a.door','b')
			->leftJoin('b.site','c')
			->leftJoin('c.trustee','d')
			->where('d.id = ?1')
			->orWhere('d.id = ?2')
			->setParameter(1, 1)
			->setParameter(2, 2)
			->getQuery()
			->getResult()
		;
		$count = 0;
		foreach ($mains as $main)
		{
			if (!$main->hasTechnician())
			{
				$em->remove($main);
				$count++;
			}
		}
		$em->flush();
		return array('count' => $count);
	}
	
	/**
	 * Creation des entretiens a faire
	 *
	 * @Route("/generate/{id}", name="maintenance_generate")
	 * @Secure(roles="ROLE_USER")
	 */
	public function generateAction(Door $door)
	{
		$em = $this->getDoctrine()->getEntityManager();
		$other = $em->getRepository('JLMDailyBundle:Maintenance')->findOneByDoor($door);
		if ($other === null)
		{
			$main = new Maintenance;
			$main->setCreation(new \DateTime);
			$main->setPlace($door.'');
			$main->setReason('Visite d\'entretien');
			$main->setContract($door->getActualContract());
			$main->setDoor($door);
			$main->setPriority(5);
			
		
			$em->persist($main);
			$em->flush();
			
			$id = $main->getId();
		}
		else
			$id = $other->getId();
		return $this->redirect($this->generateUrl('maintenance_show', array('id' => $id)));
	}
	
	/**
	 * Cherche les entretiens les plus proche d'une adresse
	 *
	 * @Route("/neighbor/{id}", name="maintenance_neighbor")
	 * @Template()
	 */
	public function neighborAction(Door $door)
	{
		$em = $this->getDoctrine()->getEntityManager();
		$repo = $em->getRepository('JLMDailyBundle:Ride');
		$countrides = $repo->getCountRides($door);	
		// portes offset nb, limit 50 order id
		$doors = $em->getRepository('JLMModelBundle:Door')
					->createQueryBuilder('a')
					->select('a')
					->orderBy('a.id')
					->setMaxResults(400)
					->setFirstResult($countrides)
					->getQuery()
					->getResult()
		;
		// @todo a mettre dans le repo + optim
		
		// si y en a matrix
		if (sizeof($doors))
		{
			$baseUrl = 'http://maps.googleapis.com/maps/api/distancematrix/json?sensor=false&language=fr-FR&origins='.$door->getCoordinates().'&destinations=';
			foreach ($doors as $dest)
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
			$em->flush();
		}
		// charge la page
				
		$entities = $repo->getMaintenanceNeighbor($door,15);
		return array('door'=>$door,'entities' => $entities);
	}
}

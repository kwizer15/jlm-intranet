<?php
namespace JLM\DailyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\DailyBundle\Entity\Intervention;
use JLM\DailyBundle\Entity\Work;
use JLM\DailyBundle\Entity\Shifting;
use JLM\ModelBundle\Form\Type\DatepickerType;
use JLM\ModelBundle\Entity\Door;
use JLM\OfficeBundle\Entity\Task;
use JLM\OfficeBundle\Entity\TaskType;

/**
 * Fixing controller.
 *
 * @Route("/intervention")
 */
class InterventionController extends Controller
{
	/**
	 * Finds and displays a Intervention entity.
	 *
	 * @Route("/", name="intervention")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function indexAction()
	{
		$em = $this->getDoctrine()->getManager();
		$entities = $em->getRepository('JLMDailyBundle:Intervention')
					   ->getPrioritary();
		return array(
				'entities'      => $entities,
		);
	}

	
	
	/**
	 * Close an existing Fixing entity.
	 *
	 * @Route("/{id}/generatetask/{type}", name="intervention_generatetask")
	 * @Secure(roles="ROLE_USER")
	 */
	public function generatetaskAction(Intervention $entity, $type)
	{
		$em = $this->getDoctrine()->getManager();
		$tasktype = $em->getRepository('JLMOfficeBundle:TaskType')->find($type);
		if ($tasktype === null)
			return $this->redirect($this->generateUrl('intervention_redirect',array('id'=>$entity->getId(),'act'=>'show')));
		
		$task = new Task;
		if ($entity->getDoor() !== null)
			$task->setDoor($entity->getDoor());
		$task->setPlace($entity->getPlace());
		$task->setUrlSource($this->generateUrl('intervention_redirect', array('id' => $entity->getId(),'act'=>'show')));
		$task->setType($tasktype);
		
		switch ($tasktype->getId())
		{
			// Facturer
			case 1 :				
				$task->setTodo($entity->getReport());
				if ($entity instanceof Work)
				{
					if ($entity->getQuote() !== null)
						$task->setUrlAction($this->generateUrl('bill_new_quotevariant',array('id'=>$entity->getQuote()->getId())));
					elseif ($entity->getDoor() !== null)
						$task->setUrlAction($this->generateUrl('bill_new_door',array('id'=>$entity->getDoor()->getId())));	
				}
				elseif ($entity->getDoor() !== null)
					$task->setUrlAction($this->generateUrl('bill_new_door',array('id'=>$entity->getDoor()->getId())));
				
				else
					$task->setUrlAction($this->generateUrl('bill_new'));
				$entity->setOfficeAction($task);
				break;
	
			// Faire devis
			case 2 :
				$task->setTodo($entity->getRest());
				$task->setUrlAction($this->generateUrl('quote_new_door',array('id'=>$entity->getDoor()->getId())));
				$entity->setOtherAction($task);
				break;
					
				// Commander matériel
			case 3 :
				$task->setTodo($entity->getRest());
				$task->setUrlAction($this->generateUrl('order_new_door',array('id'=>$entity->getDoor()->getId())));
				$entity->setOtherAction($task);
				break;
	
				// Contacter le client
			case 4 :
				$task->setTodo($entity->getReason());
				$entity->setOtherAction($task);
				break;
					
				// Ne rien faire
			case 5 :
				$task->setTodo($entity->getReport());
				$task->setClose(new \DateTime);
				$entity->setOfficeAction($task);
				break;
		}

		$em->persist($task);
		$em->persist($entity);
		$em->flush();
		
		return $this->redirect($this->generateUrl('intervention_redirect',array('id'=>$entity->getId(),'act'=>'show')));
	}
	
	/**
	 * Liste des interventions par date(s)
	 *
	 * @Route("/today", name="intervention_today")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function todayAction()
	{
		$now = new \DateTime;
		$begin = \DateTime::createFromFormat('YmdHis',$now->format('Ymd').'000000');
		$end = \DateTime::createFromFormat('YmdHis',$now->format('Ymd').'235959');
		$em = $this->getDoctrine()->getManager();
		$repo = $em->getRepository('JLMDailyBundle:Intervention');
		$intervs = $repo->getToday();
		$equipment = $em->getRepository('JLMDailyBundle:Equipment')->getToday();
		return array(
				'inprogress' => $intervs['inprogress'],
				'fixing' => $intervs['fixing'],
				'equipment' => $equipment,
				'notclosed' => $intervs['notclosed'],
				'closed' => $intervs['closed'],
		);
		
		// ORDRE DES INTERVS
		// - Toutes ayant au moins un intervenant aujourd'hui
		// - Les dépannages sans intervenant
		// - Les travaux non cloturés
		// - Les travaux sans intervenant
		// - Les entretiens sans intervenant
		
	}
	
	/**
	 * Liste des interventions par date(s)
	 *
	 * @Route("/list", name="intervention_list")
	 * @Route("/list/{date1}", name="intervention_listdate1")
	 * @Route("/list/{date1}/{date2}", name="intervention_listdate2")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function reportAction($date1 = null,$date2 = null)
	{
		$now = new \DateTime;
		$today = \DateTime::createFromFormat('YmdHis',$now->format('Ymd').'000000');
		$d1 = ($date1 === null) ? $today : \DateTime::createFromFormat('YmdHis',$date1.'000000');
		$d2 = ($date2 === null) ? \DateTime::createFromFormat('YmdHis',$d1->format('Ymd').'235959') : \DateTime::createFromFormat('YmdHis',$date2.'235959');
		$em = $this->getDoctrine()->getManager();
		$repo = $em->getRepository('JLMDailyBundle:Intervention');
		
		$intervs = $repo->getWithDate($d1,$d2);
		$equipment = $em->getRepository('JLMDailyBundle:Equipment')->getWithDate($d1,$d2);
		$now->sub(new \DateInterval('P4D'));
		$days = array(
			\DateTime::createFromFormat('YmdHis',$now->add(new \DateInterval('P1D'))->format('Ymd').'000000'),
			\DateTime::createFromFormat('YmdHis',$now->add(new \DateInterval('P1D'))->format('Ymd').'000000'),
			\DateTime::createFromFormat('YmdHis',$now->add(new \DateInterval('P1D'))->format('Ymd').'000000'),
			\DateTime::createFromFormat('YmdHis',$now->add(new \DateInterval('P1D'))->format('Ymd').'000000'),
			\DateTime::createFromFormat('YmdHis',$now->add(new \DateInterval('P1D'))->format('Ymd').'000000'),
		);
		$standby = $em->getRepository('JLMDailyBundle:Standby')
			->createQueryBuilder('s')
			->where('s.begin <= ?1 AND s.end >= ?1')
			->setParameter(1,$date1)
			->setMaxResults(1)
			->getQuery()
			->getResult()
		;
		if (empty($standby))
			$standby = null;
		else
			$standby = $standby[0]->getTechnician();
		return array(
				'standby' => $standby,
				'd1' => $d1,
				'd2' => ($date2 === null) ? null : $d2,
				'entities' => array_merge($equipment,$intervs),
				'days' => $days,
		);
	}
	
	/**
	 * Liste des interventions par date(s)
	 *
	 * @Route("/listpost", name="intervention_list_post")
	 * @Method("post")
	 * @Secure(roles="ROLE_USER")
	 */
	public function reportdateAction(Request $request)
	{
		$date = \DateTime::createFromFormat('d/m/Y',$request->get('datepicker'));

		return $this->redirect($this->generateUrl('intervention_listdate1',array('date1'=>$date->format('Ymd'))));
	}
	
	
	/**
	 * Supprimer une intervention
	 *
	 * @Route("/delete/{id}", name="intervention_delete")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function deleteAction(Shifting $entity)
	{
		$em = $this->getDoctrine()->getManager();
		foreach ($entity->getShiftTechnicians() as $tech)
			$em->remove($tech);
		if ($entity instanceof Intervention)
		{
			if (null !== $entity->getOfficeAction())
				$em->remove($entity->getOfficeAction());
			if (null !== $entity->getOtherAction())
				$em->remove($entity->getOtherAction());
		}	
			
		$em->remove($entity);
		$em->flush();
	
		return $this->redirect($this->generateUrl('intervention_today'));
	}
	
	/**
	 * Finds and displays a Intervention entity.
	 *
	 * @Route("/{id}/{act}", name="intervention_redirect", requirements={"id"="[0-9]+"})
	 * @Secure(roles="ROLE_USER")
	 */
	public function redirectAction(Intervention $entity, $act)
	{
		if (in_array($act,array('show','edit','close')))
			return $this->redirect($this->generateUrl($entity->getType() . '_' . $act,array('id'=>$entity->getId())));
		throw $this->createNotFoundException('Page inexistante');
	}
	
	/**
	 * Imprime les intervs de la prochaine journée
	 *
	 * @Route("/printday/{date1}", name="intervention_printday")
	 * @Secure(roles="ROLE_USER")
	 */
	public function printdayAction($date1)
	{
		$now = new \DateTime;
		$today = \DateTime::createFromFormat('YmdHis',$now->format('Ymd').'000000');
		$d1 = \DateTime::createFromFormat('YmdHis',$date1.'000000');
		$d2 =  \DateTime::createFromFormat('YmdHis',$d1->format('Ymd').'235959');
		$em = $this->getDoctrine()->getManager();
		$repo = $em->getRepository('JLMDailyBundle:Intervention');
		
		$intervs = $repo->getWithDate($d1,$d2);
		$equipment = $em->getRepository('JLMDailyBundle:Equipment')->getWithDate($d1,$d2);
		$standby = $em->getRepository('JLMDailyBundle:Standby')
			->createQueryBuilder('s')
			->where('s.begin <= ?1 AND s.end >= ?1')
			->setParameter(1,$date1)
			->setMaxResults(1)
			->getQuery()
			->getResult()
		;
		if (empty($standby))
			$standby = null;
		else
			$standby = $standby[0]->getTechnician();
		$response = new Response();
		$response->headers->set('Content-Type', 'application/pdf');
		$response->headers->set('Content-Disposition', 'inline; filename='.$d1->format('Y-m-d').'.pdf');
		$response->setContent($this->render('JLMDailyBundle:Intervention:printday.pdf.php',
				array('date' => $d1,
						'entities' => array_merge($equipment,$intervs),
						'standby' => $standby,
				)));
		
		return $response;
	}
	
	/**
	 * Imprime les intervs de la prochaine journée
	 *
	 * @Route("/printtomorrow", name="intervention_printtomorrow")
	 * @Secure(roles="ROLE_USER")
	 */
	public function printtomorrowAction()
	{
		$now = new \DateTime;
		$em = $this->getDoctrine()->getManager();
		
		do {
			$tomorrow = \DateTime::createFromFormat('YmdHis',$now->add(new \DateInterval('P1D'))->format('Ymd').'000000');
			
			$results = $em->getRepository('JLMDailyBundle:Standby')
				->createQueryBuilder('s')
				->select('COUNT(s)')
				->where('s.begin <= ?1')
				->andWhere('s.end >= ?1')
				->setParameter(1,$tomorrow->format('Y-m-d'))
				->getQuery()
				->getSingleScalarResult();
		} while ($results);
		
		$intervs = $em->getRepository('JLMDailyBundle:Intervention')->getWithDate($tomorrow,$tomorrow);
		$equipment = $em->getRepository('JLMDailyBundle:Equipment')->getWithDate($tomorrow,$tomorrow);
		$fixing = $em->getRepository('JLMDailyBundle:Fixing')->createQueryBuilder('i')
			->leftJoin('i.shiftTechnicians','t')
			->where('t is null')
			->andWhere('i.close is null')
			->orderBy('i.creation','asc')
			->getQuery()
			->getResult();
			;
		
		$response = new Response();
		$response->headers->set('Content-Type', 'application/pdf');
		$response->headers->set('Content-Disposition', 'inline; filename='.$tomorrow->format('Y-m-d').'.pdf');
		$response->setContent($this->render('JLMDailyBundle:Intervention:printtomorrow.pdf.php',
				array('date' => $tomorrow,
					'entities' => array_merge($equipment,$intervs,$fixing),
		)));
		
		return $response;
	}
	
	/**
	 * Imprime les intervs d'une intallation
	 *
	 * @Route("/printdoor/{id}", name="intervention_printdoor")
	 * @Secure(roles="ROLE_USER")
	 */
	public function printdoorAction($id)
	{
		$em = $this->getDoctrine()->getManager();
		$intervs = $em->getRepository('JLMDailyBundle:Intervention')
			->createQueryBuilder('a.id')
			->select('a')
			->leftJoin('a.door','d')
			->where('d.id = ?1')
			->setParameter(1,$id)
			->getQuery()
			->getArrayResult();
		
		print_r($intervs); exit;
		$shifts = $em->getRepository('JLMDailyBundle:ShiftTechnician')
			->createQueryBuilder('a')
			->select('a')
			->leftJoin('a.shifting','b')
			->where('b.id in ?1')
			->setParameter(1,$intervs);
		
	}
}
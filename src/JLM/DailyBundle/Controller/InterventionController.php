<?php
namespace JLM\DailyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\DailyBundle\Entity\Intervention;
use JLM\DailyBundle\Entity\Work;
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
		return array(
				'd1' => $d1,
				'd2' => ($date2 === null) ? null : $d2,
				'entities' => $intervs,
				'equipment' => $equipment,
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
}
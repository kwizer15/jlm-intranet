<?php
namespace JLM\DailyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\DailyBundle\Entity\Intervention;
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
				$entity->setOfficeAction($task);
				$task->setTodo($entity->getReport());
				break;
	
			// Faire devis
			case 2 :
				$entity->setOtherAction($task);
				$task->setTodo($entity->getRest());
				$task->setUrlAction($this->generateUrl('quote_new_door',array('id'=>$entity->getDoor()->getId())));
				break;
					
				// Commander matériel
			case 3 :
				$entity->setOtherAction($task);
				$task->setTodo($entity->getRest());
				break;
	
				// Contacter le client
			case 4 :
				$entity->setOtherAction($task);
				$task->setTodo($entity->getReason());
				break;
					
				// Ne rien faire
			case 5 :
				$entity->setOfficeAction($task);
				$task->setTodo($entity->getReport());
				$task->setClose(new \DateTime);
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
		return array(
				'd1' => $d1,
				'd2' => ($date2 === null) ? null : $d2,
				'entities' => $intervs,
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
		$d = $request->request->get('datepicker');
		$date1 = \DateTime::createFromFormat('d/m/Y',$d);
		//print_r($d); exit;
		return $this->redirect($this->generateUrl('intervention_listdate1',array('date1'=>$date1->format('Ymd'))));
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
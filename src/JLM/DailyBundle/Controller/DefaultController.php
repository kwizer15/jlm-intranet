<?php

namespace JLM\DailyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\ModelBundle\Form\Type\DatepickerType;
use JLM\DailyBundle\Entity\Fixing;
use JLM\DailyBundle\Form\Type\FixingType;

class DefaultController extends Controller
{
	/**
	 * Search
	 * @Route("/search", name="daily_search")
	 * @Method("post")
     * @Secure(roles="ROLE_USER")
	 * @Template()
	 */
	public function searchAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$query = $request->request->get('query');
		if ($query > 0)
		{
			$door = $em->getRepository('JLMModelBundle:Door')->find($query);
			if ($door !== null)
				return $this->redirect($this->generateUrl('daily_door_show',array('id'=>$door->getId())));
		}
		$doors = $em->getRepository('JLMModelBundle:Door')->search($query);
		/*
		 * Voir aussi
		* 	DoorController:stoppedAction
		* 	FixingController:newAction
		* @todo A factoriser de là ...
		*/
		$fixingForms = array();
		foreach ($doors as $door)
		{
			$entity = new Fixing();
			$entity->setDoor($door);
			$fixingForms[] = $this->get('form.factory')->createNamed('fixingNew'.$door->getId(),new FixingType(), $entity)->createView();
		}
		/* à la */
		return array(
			'query'   => $query,
			'doors'   => $doors,
			'fixing_forms' => $fixingForms,
		);
	}
	
	/**
	 * Search
	 * @Route("/search", name="daily_search_get")
	 * @Method("get")
	 * @Secure(roles="ROLE_USER")
	 * @Template()
	 */
	public function searchgetAction(Request $request)
	{
		return $this->redirect($this->generateUrl('intervention_today'));
	}
	
	/**
	 * Sidebar
	 * @Route("/sidebar", name="daily_sidebar")
     * @Secure(roles="ROLE_USER")
	 * @Template()
	 */
	public function sidebarAction()
	{
		$em = $this->getDoctrine()->getManager();
		return array(
		    'today' => $em->getRepository('JLMDailyBundle:Intervention')->getCountToday(),
			'stopped' => $em->getRepository('JLMModelBundle:Door')->getCountStopped(),
			'fixing' => $em->getRepository('JLMDailyBundle:Fixing')->getCountOpened(),
			'work'   => $em->getRepository('JLMDailyBundle:Work')->getCountOpened(),
			'maintenance' => $em->getRepository('JLMDailyBundle:Maintenance')->getCountOpened(),
		);
	}
	
	/**
	 * Search by date form
	 * @Route("/datesearch", name="daily_datesearch")
	 * @Secure(roles="ROLE_USER")
	 * @Template()
	 */
	public function datesearchAction()
	{
		$entity = new \DateTime();
		$form   = $this->createForm(new DatepickerType(), $entity);
		return array(
				'form' => $form->createView(),
		);
	}
	/**
	 * @Route("/", name="daily")
	 * @Template()
	 */
	public function indexAction()
	{
		return $this->redirect($this->generateUrl('intervention_today'));
	}
}

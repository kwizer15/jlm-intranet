<?php

namespace JLM\DailyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\ModelBundle\Entity\Door;

/**
 * Fixing controller.
 *
 * @Route("/door")
 */
class DoorController extends Controller
{
	/**
	 * Finds and displays a Door entity.
	 *
	 * @Route("/{id}/show", name="daily_door_show")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function showAction(Door $door)
	{
		$em = $this->getDoctrine()->getManager();
		$interventions = $em->getRepository("JLMDailyBundle:Intervention")->findByDoor($door,array('creation'=>'DESC'));
		return array(
				'entity'      => $door,
				'interventions' => $interventions,
		);
	}
	
	/**
	 * Displays Doors stopped
	 *
	 * @Route("/stopped", name="daily_door_stopped")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function stoppedAction()
	{
		$em = $this->getDoctrine()->getManager();
		$doors = $em->getRepository("JLMModelBundle:Door")->getStopped();
		return array(
				'entities' => $doors,
		);
	}
}
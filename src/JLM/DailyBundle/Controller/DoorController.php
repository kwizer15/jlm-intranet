<?php

namespace JLM\DailyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\ModelBundle\Entity\Door;
use JLM\DailyBundle\Entity\Fixing;
use JLM\DailyBundle\Form\Type\FixingType;

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
		return array(
			'entity'      => $door,
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
		$doors = $em->getRepository('JLMModelBundle:Door')->getStopped();
		$fixingForms = array();
		foreach ($doors as $door)
		{
			$entity = new Fixing();
			$entity->setDoor($door);
			$fixingForms[] = $this->get('form.factory')->createNamed('fixingNew'.$door->getId(),new FixingType(), $entity)->createView();
		}
		return array(
				'entities' => $doors,
				'fixing_forms' => $fixingForms,
		);
	}
	
	/**
	 * Displays Doors stopped
	 *
	 * @Route("/printstopped", name="daily_door_printstopped")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function printstoppedAction()
	{
		$em = $this->getDoctrine()->getManager();
		$doors = $em->getRepository('JLMModelBundle:Door')->getStopped();
		$response = new Response();
		$response->headers->set('Content-Type', 'application/pdf');
		$response->headers->set('Content-Disposition', 'inline; filename=portes-arret.pdf');
		$response->setContent($this->render('JLMDailyBundle:Door:printstopped.pdf.php',
				array(	'entities' => $doors,
			)));
		return $response;
	}
	
	/**
	 * Stop door
	 *
	 * @Route("/{id}/stop", name="daily_door_stop")
	 * @Template("JLMDailyBundle:Door:show.html.twig")
	 * @Secure(roles="ROLE_USER")
	 */
	public function stopAction(Door $entity)
	{
		$em = $this->getDoctrine()->getManager();
		$entity->setStopped(true);
		$em->persist($entity);
		$em->flush();
		return array(
				'entity' => $entity,
		);
	}
	
	/**
	 * Unstop door
	 *
	 * @Route("/{id}/unstop", name="daily_door_unstop")
	 * @Template("JLMDailyBundle:Door:show.html.twig")
	 * @Secure(roles="ROLE_USER")
	 */
	public function unstopAction(Door $entity)
	{
		$em = $this->getDoctrine()->getManager();
		$entity->setStopped(false);
		$em->persist($entity);
		$em->flush();
		return array(
				'entity' => $entity,
		);
	}
}
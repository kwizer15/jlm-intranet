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
use JLM\ModelBundle\Entity\DoorStop;
use JLM\DailyBundle\Entity\Fixing;
use JLM\DailyBundle\Form\Type\FixingType;
use JLM\ModelBundle\Form\Type\DoorStopEditType;

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
		return array(
			'entity' => $door,
			'quotes' => $em->getRepository('JLMOfficeBundle:Quote')->getByDoor($door),
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
		$stopForms = array();
		
		foreach ($doors as $door)
			$stopForms[] = $this->get('form.factory')->createNamed('doorStopEdit'.$door->getLastStop()->getId(),new DoorStopEditType(), $door->getLastStop())->createView();
		
		return array(
				'entities' => $doors,
				'stopForms' => $stopForms,
		);
	}
	
	/**
	 * Displays Doors stopped
	 *
	 * @Route("/stop/update/{id}", name="daily_door_stopupdate")
	 * @Template("JLMDailyBundle:Door:stopped.html.twig")
	 * @Secure(roles="ROLE_USER")
	 */
	public function stopupdateAction(Request $request, DoorStop $entity)
	{
		$form = $this->get('form.factory')->createNamed('doorStopEdit'.$entity->getId(),new DoorStopEditType(), $entity);
		$form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->stoppedAction();
        }
		
		return $this->stoppedAction();
		
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
		$stop = new DoorStop;
		$stop->setBegin(new \DateTime);
		$stop->setReason('À définir');
		$stop->setState('Non traitée');
		$entity->addStop($stop);
		$em->persist($stop);
		$em->flush();
		return $this->showAction($entity);
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
		$stop = $entity->getLastStop();
		$stop->setEnd(new \DateTime);
		$em->persist($stop);
		$em->flush();
		return $this->showAction($entity);
	}
}
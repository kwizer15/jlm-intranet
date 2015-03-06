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
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function showAction(Door $door)
	{
		$em = $this->getDoctrine()->getManager();
		
		$codeForm = $this->_createCodeForm($door);
		
		return array(
			'entity' => $door,
			'quotes' => $em->getRepository('JLMCommerceBundle:Quote')->getByDoor($door),
		    'codeForm' => $codeForm->createView(),
		);
	}
	
	private function _createCodeForm(Door $door)
	{
		$form = $this->createForm(new \JLM\ModelBundle\Form\Type\DoorTagType(), $door,
		array('action'=>$this->generateUrl('model_door_update_code',array('id'=>$door->getId())),
		    'method'=>'POST'));
                    
		return $form;
	}
	
	/**
	 * Displays Doors stopped
	 *
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
        }
		return $this->stoppedAction();
	}
	
	/**
	 * Displays Doors stopped
	 *
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
	 * @Template("JLMDailyBundle:Door:show.html.twig")
	 * @Secure(roles="ROLE_USER")
	 */
	public function stopAction(Door $entity)
	{
		$em = $this->getDoctrine()->getManager();
		if ($entity->getLastStop() === null)
		{
			$stop = new DoorStop;
			$stop->setBegin(new \DateTime);
			$stop->setReason('À définir');
			$stop->setState('Non traitée');
			$entity->addStop($stop);
			$em->persist($stop);
			$em->flush();
		}
		return $this->showAction($entity);
	}
	
	/**
	 * Unstop door
	 *
	 * @Template("JLMDailyBundle:Door:show.html.twig")
	 * @Secure(roles="ROLE_USER")
	 */
	public function unstopAction(Door $entity)
	{
		$em = $this->getDoctrine()->getManager();
		$stop = $entity->getLastStop();
		if ($stop === null)
			return $this->showAction($entity);
		$stop->setEnd(new \DateTime);
		$em->persist($stop);
		$em->flush();
		return $this->showAction($entity);
	}
}
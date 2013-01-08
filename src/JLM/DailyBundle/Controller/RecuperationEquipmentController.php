<?php

namespace JLM\DailyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\DailyBundle\Entity\ShiftTechnician;

use JLM\DailyBundle\Form\Type\RecuperationEquipmentType;
use JLM\DailyBundle\Form\Type\RecuperationEquipmentEditType;


/**
 * Fixing controller.
 *
 * @Route("/equipment")
 */
class RecuperationEquipmentController extends Controller
{
	/**
	 * Displays a form to create a new InterventionPlanned entity.
	 *
	 * @Route("/new", name="recuperationequipment_new")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function newAction()
	{
		$entity = new ShiftTechnician();
		$form   = $this->createForm(new RecuperationEquipmentType(), $entity);

		return array(
				'entity' => $entity,
				'form'   => $form->createView(),
		);
	}

	/**
	 * Creates a new ShiftTechnician entity.
	 *
	 * @Route("/create", name="recuperationequipment_create")
	 * @Method("POST")
	 * @Template("JLMDailyBundle:RecuperationEquipment:new.html.twig")
	 * @Secure(roles="ROLE_USER")
	 */
	public function createAction(Request $request)
	{
		$entity  = new ShiftTechnician();
		$form = $this->createForm(new RecuperationEquipmentType(), $entity);
		$form->bind($request);

		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$entity->setCreation(new \DateTime);
			
			$em->persist($entity->getShifting()->setCreation(new \DateTime));
			$em->persist($entity);
			$em->flush();

			return $this->redirect($this->generateUrl('shifting_list',array('id'=>$entity->getTechnician()->getId())));
		}

		return array(
				'entity' => $entity,
				'form'   => $form->createView(),
		);
	}
	
	
}
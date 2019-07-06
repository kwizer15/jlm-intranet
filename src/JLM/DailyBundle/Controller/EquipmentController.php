<?php

namespace JLM\DailyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\DailyBundle\Entity\ShiftTechnician;
use JLM\DailyBundle\Entity\Equipment;
use JLM\DailyBundle\Form\Type\EquipmentType;
use JLM\DailyBundle\Form\Type\RecuperationEquipmentType;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * Fixing controller.
 */
class EquipmentController extends Controller
{
	/**
	 * Displays a form to create a new InterventionPlanned entity.
	 *
	 * @Template()
	 */
	public function newAction()
	{
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

		$entity = new ShiftTechnician();
		$entity->setBegin(new \DateTime);
		$shifting = new Equipment();
		$shifting->setPlace('Saint-Soupplets (Bureau)');
		$shifting->setReason('Récupération matériel');
		$entity->setShifting($shifting);
		$form   = $this->createForm(new RecuperationEquipmentType(), $entity);
		return array(
				'entity' => $entity,
				'form'   => $form->createView(),
		);
	}

	/**
	 * Creates a new ShiftTechnician entity.
	 *
	 * @Template()
	 */
	public function createAction(Request $request)
	{
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

		$entity  = new ShiftTechnician();
		$entity->setCreation(new \DateTime);
		$form = $this->createForm(new RecuperationEquipmentType(), $entity);
		$form->handleRequest($request);
		if ($form->isValid())
		{
			$em = $this->getDoctrine()->getManager();
			$em->persist($entity->getShifting()->setCreation(new \DateTime));
			$em->persist($entity);
			$em->flush();
			if ($this->getRequest()->isXmlHttpRequest())
			{
				return new JsonResponse(array());
			}
			
			return $this->redirect($request->headers->get('referer'));
		}
		return array(
				'entity' => $entity,
				'form'   => $form->createView(),
				'previous'=> $request->headers->get('referer'),
		);
	}
	
	/**
	 * Show
	 * @Template()
	 */
	public function showAction(Request $request, Equipment $entity)
	{
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

		return array(
				'previous'=> $request->headers->get('referer'),
				'entity' => $entity,
		);
	}
	
	/**
	 * Edit a form to edit an existing Equipment entity.
	 *
	 * @Template()
	 */
	public function editAction(Equipment $entity)
	{
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

		$editForm = $this->createForm(new EquipmentType(), $entity);
	
		return array(
				'entity'      => $entity,
				'form'   => $editForm->createView(),
		);
	}
	
	/**
	 * Edits an existing Equipment entity.
	 *
	 * @Template()
	 */
	public function updateAction(Request $request, Equipment $entity)
	{
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

		$em = $this->getDoctrine()->getManager();
	
		$editForm = $this->createForm(new EquipmentType(), $entity);
		$editForm->handleRequest($request);
	
		if ($editForm->isValid())
		{
			$em->persist($entity);
			$em->flush();
			return $this->redirect($request->headers->get('referer'));
		}
	
		return array(
				'entity'      => $entity,
				'form'   => $editForm->createView(),
				'previous'=> $request->headers->get('referer'),
		);
	}
}
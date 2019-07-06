<?php
namespace JLM\DailyBundle\Controller;

use JLM\DailyBundle\Entity\Intervention;
use JLM\DailyBundle\Form\Type\ExternalBillType;
use JLM\DailyBundle\Form\Type\InterventionCancelType;
use JLM\DefaultBundle\Controller\PaginableController;

/**
 * Fixing controller.
 */
abstract class AbstractInterventionController extends PaginableController
{
	/**
	 * 
	 * @param Intervention $entity
	 * @return array
	 */
	public function show(Intervention $entity)
	{
		$form_externalbill = $this->get('form.factory')->createNamed('externalBill'.$entity->getId(),new ExternalBillType(), $entity);
		$form_cancel = $this->createForm(new InterventionCancelType(), $entity);
		$em = $this->getDoctrine()->getManager();
		
		return array(
				'entity' => $entity,
				'form_externalbill' => $form_externalbill->createView(),
				'form_cancel' => $form_cancel->createView(),
				'quotes' => $em->getRepository('JLMCommerceBundle:Quote')->getByDoor($entity->getDoor()),
		);
	}
}
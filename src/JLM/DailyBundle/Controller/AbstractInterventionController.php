<?php
namespace JLM\DailyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\DailyBundle\Entity\Intervention;
use JLM\DailyBundle\Entity\ShiftTechnician;
use JLM\DailyBundle\Form\Type\AddTechnicianType;
use JLM\DailyBundle\Form\Type\ShiftingEditType;
use JLM\DailyBundle\Form\Type\ExternalBillType;
use JLM\DailyBundle\Form\Type\InterventionCancelType;
use JLM\ModelBundle\Entity\Door;
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
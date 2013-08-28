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
		$st = new ShiftTechnician();
		$st->setBegin(new \DateTime);
		$form   = $this->get('form.factory')->createNamed('shiftTechNew'.$entity->getId(),new AddTechnicianType(), $st);
		$form_externalbill = $this->createForm(new ExternalBillType(), $entity);
		$form_cancel = $this->createForm(new InterventionCancelType(), $entity);
		$shiftTechs = $entity->getShiftTechnicians();
		$formsEditTech = array();
		foreach ($shiftTechs as $shiftTech)
			$formsEditTech[] = $this->get('form.factory')->createNamed('shiftTechEdit'.$shiftTech->getId(),new ShiftingEditType(), $shiftTech)->createView();
		return array(
				'entity' => $entity,
				'form_newtech'   => $form->createView(),
				'form_externalbill' => $form_externalbill->createView(),
				'form_cancel' => $form_cancel->createView(),
				'forms_editTech' => $formsEditTech,
		);
	}
}
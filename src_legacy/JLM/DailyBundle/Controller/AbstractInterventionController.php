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
        $form_externalbill = $this
            ->get('form.factory')
            ->createNamed('externalBill'.$entity->getId(), ExternalBillType::class, $entity)
        ;
        $form_cancel = $this->createForm(InterventionCancelType::class, $entity);
        $em = $this->getDoctrine()->getManager();
        
        return [
                'entity'            => $entity,
                'form_externalbill' => $form_externalbill->createView(),
                'form_cancel'       => $form_cancel->createView(),
                'quotes'            => $em->getRepository('JLMCommerceBundle:Quote')->getByDoor($entity->getDoor()),
               ];
    }
}

<?php

namespace JLM\DailyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ShiftingEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        	->add('begin','datetime',array(
      				'label'=>'Début',
      			))
      		->add('end','time',array(
      				'label'=>'Fin',
      			))
      			->add('comment','textarea',array('label'=>'Commentaire','required'=>false,'attr'=>array('class'=>'input-xxlarge')))
        ;
        
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JLM\DailyBundle\Entity\ShiftTechnician'
        ));
    }

    public function getName()
    {
        return 'jlm_dailybundle_shiftingedittype';
    }
}

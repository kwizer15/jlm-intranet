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
      				'hours'=>array(8,9,10,11,12,13,14,15,16,17,18),
      				'minutes'=>array(0,5,10,15,20,25,30,35,40,45,50,55),
      			))
      		->add('end','time',array(
      				'label'=>'Fin',
      				'hours'=>array(8,9,10,11,12,13,14,15,16,17,18),
      				'minutes'=>array(0,5,10,15,20,25,30,35,40,45,50,55),
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

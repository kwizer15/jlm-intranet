<?php

namespace JLM\DailyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AddTechnicianType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
      		->add('technician',null,array('label'=>'Technicien'))
      		->add('begin','datepicker',array('label'=>'Date'))
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
        return 'jlm_dailybundle_addtechniciantype';
    }
}

<?php

namespace JLM\DailyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class StandbyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        	->add('technician',null,array('label'=>'Technicien'))
            ->add('begin','datepicker',array('label'=>'Début'))
            ->add('end','datepicker',array('label'=>'Fin'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JLM\DailyBundle\Entity\Standby'
        ));
    }

    public function getName()
    {
        return 'standbytype';
    }
}

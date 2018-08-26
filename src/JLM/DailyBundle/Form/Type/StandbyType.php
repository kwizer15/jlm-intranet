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
            ->add('technician', null, ['label'=>'Technicien'])
            ->add('begin', 'datepicker', ['label'=>'Début'])
            ->add('end', 'datepicker', ['label'=>'Fin'])
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'JLM\DailyBundle\Entity\Standby'
        ]);
    }

    public function getName()
    {
        return 'standbytype';
    }
}

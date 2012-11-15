<?php

namespace JLM\DailyBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InterventionPlannedType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('creation')
            ->add('contactName')
            ->add('contactPhones')
            ->add('contactEmail')
            ->add('reason')
            ->add('priority')
            ->add('door')
            ->add('actionType')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JLM\DailyBundle\Entity\InterventionPlanned'
        ));
    }

    public function getName()
    {
        return 'jlm_dailybundle_interventionplannedtype';
    }
}

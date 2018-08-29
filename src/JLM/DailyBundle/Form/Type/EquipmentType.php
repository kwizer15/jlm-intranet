<?php

namespace JLM\DailyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EquipmentType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('place', null, ['label' => 'Lieu'])
            ->add('reason', null, ['label' => 'Raison'])
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(['data_class' => 'JLM\DailyBundle\Entity\Equipment']);
    }

    public function getName()
    {
        return 'jlm_dailybundle_equipmenttype';
    }
}

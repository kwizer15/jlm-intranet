<?php

namespace JLM\DailyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RecuperationEquipmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('technician', null, ['label' => 'Technicien'])
            ->add('begin', 'datepicker', ['label' => 'Date'])
            ->add('shifting', new EquipmentType, ['label' => 'Récupération'])
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(['data_class' => 'JLM\DailyBundle\Entity\ShiftTechnician']);
    }

    public function getName()
    {
        return 'jlm_dailybundle_recuperationequipmenttype';
    }
}

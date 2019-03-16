<?php

namespace JLM\DailyBundle\Form\Type;

use JLM\DailyBundle\Entity\ShiftTechnician;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecuperationEquipmentEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'begin',
                DateTimeType::class,
                [
                    'label' => 'Début',
                    'hours' => [8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18,],
                    'minutes' => [0, 5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55,],
                ]
            )
            ->add(
                'end',
                TimeType::class,
                [
                    'label' => 'Fin',
                    'hours' => [8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18,],
                    'minutes' => [0, 5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55,],
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => ShiftTechnician::class]);
    }
}

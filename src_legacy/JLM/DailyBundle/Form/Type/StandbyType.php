<?php

namespace JLM\DailyBundle\Form\Type;

use JLM\DailyBundle\Entity\Standby;
use JLM\ModelBundle\Form\Type\DatepickerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StandbyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('technician', TextType::class, ['label' => 'Technicien'])
            ->add('begin', DatepickerType::class, ['label' => 'Début'])
            ->add('end', DatepickerType::class, ['label' => 'Fin'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Standby::class]);
    }
}

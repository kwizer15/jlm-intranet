<?php

namespace JLM\DailyBundle\Form\Type;

use JLM\DailyBundle\Entity\ShiftTechnician;
use JLM\ModelBundle\Form\Type\DatepickerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddTechnicianType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('technician', TextType::class, ['label' => 'Technicien'])
            ->add('begin', DatepickerType::class, ['label' => 'Date'])
            ->add(
                'comment',
                TextareaType::class,
                [
                 'label'    => 'Commentaire',
                 'required' => false,
                 'attr'     => ['class' => 'input-xlarge'],
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => ShiftTechnician::class]);
    }
}

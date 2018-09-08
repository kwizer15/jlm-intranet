<?php

namespace JLM\DailyBundle\Form\Type;

use JLM\CommerceBundle\Form\Type\QuoteVariantHiddenType;
use JLM\DailyBundle\Entity\Work;
use JLM\ModelBundle\Form\Type\DoorHiddenType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WorkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('door', DoorHiddenType::class)
            ->add('place', TextType::class, ['label' => 'Lieu', 'attr' => ['class' => 'input-xlarge']])
            ->add('quote', QuoteVariantHiddenType::class, ['required' => false])
            ->add(
                'reason',
                TextType::class,
                ['label' => 'Raison de l\'intervention', 'attr' => ['class' => 'input-xlarge']]
            )
            ->add('contactName', TextType::class, ['label' => 'Nom du contact', 'required' => false])
            ->add('contactPhones', TextType::class, ['label' => 'Téléphones', 'required' => false])
            ->add(
                'contactEmail',
                EmailType::class,
                [
                    'label' => 'e-mail',
                    'required' => false,
                    'attr' => ['class' => 'input-xlarge'],
                ]
            )
            ->add('category', TextType::class, ['label' => 'Type de travaux'])
            ->add('objective', TextType::class, ['label' => 'Objectif'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Work::class,
                'attr' => ['class' => 'interventionForm'],
            ]
        );
    }
}

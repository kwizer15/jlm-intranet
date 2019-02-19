<?php

namespace JLM\OfficeBundle\Form\Type;

use JLM\FeeBundle\Entity\FeesFollower;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FeesType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('frequence1', PercentType::class, ['required' => false, 'attr' => ['label' => 'Annuelle']])
            ->add('frequence2', PercentType::class, ['required' => false, 'attr' => ['label' => 'Semestrielle']])
            ->add('frequence4', PercentType::class, ['required' => false, 'attr' => ['label' => 'Trimestrielle']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => FeesFollower::class]);
    }
}

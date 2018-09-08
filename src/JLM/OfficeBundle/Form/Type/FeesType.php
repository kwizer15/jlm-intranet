<?php

namespace JLM\OfficeBundle\Form\Type;

use JLM\OfficeBundle\Entity\FeesFollower;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FeesType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('frequence1', PercentType::class, ['required' => false, 'attr' => ['label' => 'Annuelle']])
            ->add('frequence2', PercentType::class, ['required' => false, 'attr' => ['label' => 'Semestrielle']])
            ->add('frequence4', PercentType::class, ['required' => false, 'attr' => ['label' => 'Trimestrielle']])
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(['data_class' => FeesFollower::class]);
    }
}

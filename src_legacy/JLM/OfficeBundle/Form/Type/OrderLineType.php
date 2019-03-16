<?php

namespace JLM\OfficeBundle\Form\Type;

use JLM\OfficeBundle\Entity\OrderLine;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderLineType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('position', HiddenType::class)
        ->add('reference', TextType::class, ['required' => false, 'attr' => ['class' => 'input-small']])
        ->add('designation', TextType::class, ['attr' => ['class' => 'input-xxlarge']])
        ->add('quantity', TextType::class, ['attr' => ['class' => 'input-mini']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => OrderLine::class]);
    }
}

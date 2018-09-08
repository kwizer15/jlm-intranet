<?php

namespace JLM\OfficeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

abstract class AskDontTreatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'dontTreat',
                TextType::class,
                ['label' => 'Raison du non-traitement', 'attr' => ['class' => 'input-xlarge', 'rows' => 5]]
            );
    }
}

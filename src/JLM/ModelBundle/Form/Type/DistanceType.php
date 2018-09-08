<?php

namespace JLM\ModelBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DistanceType extends AbstractType
{
    public function getParent()
    {
        return TextType::class;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'invalid_message' => 'Distance invalide',
                'attr' => ['class' => 'input-mini'],
            ]
        );
    }
}

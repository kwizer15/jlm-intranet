<?php

namespace JLM\ModelBundle\Form\Type;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TypeaheadType extends AbstractType
{

    public function getDefaultOptions(array $options)
    {
        return ['widget' => TextType::class];
    }

    public function getParent()
    {
        return EntityType::class;
    }
}

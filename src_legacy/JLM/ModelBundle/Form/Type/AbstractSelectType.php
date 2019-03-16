<?php

namespace JLM\ModelBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\TextType;

abstract class AbstractSelectType extends AbstractHiddenType
{
    public function getParent()
    {
        return TextType::class;
    }
}

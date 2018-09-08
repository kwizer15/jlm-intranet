<?php

namespace JLM\ModelBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

abstract class AbstractSelectType extends AbstractHiddenType
{
    public function getParent()
    {
        return TextType::class;
    }
}

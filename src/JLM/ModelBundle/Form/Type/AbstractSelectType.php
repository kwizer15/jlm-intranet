<?php

namespace JLM\ModelBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

abstract class AbstractSelectType extends AbstractHiddenType
{
    public function getName()
    {
        return $this->getTypeName().'_select';
    }
    
    public function getParent()
    {
        return 'text';
    }
}

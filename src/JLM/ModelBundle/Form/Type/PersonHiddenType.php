<?php

namespace JLM\ModelBundle\Form\Type;

use JLM\ModelBundle\Form\Type\AbstractHiddenType;

class PersonHiddenType extends AbstractHiddenType
{

    protected function getTransformerClass()
    {
        return 'JLM\ContactBundle\Form\DataTransformer\PersonToIntTransformer';
    }
    
    protected function getTypeName()
    {
        return 'person';
    }
}

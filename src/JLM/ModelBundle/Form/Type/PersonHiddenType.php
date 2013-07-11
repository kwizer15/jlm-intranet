<?php

namespace JLM\ModelBundle\Form\Type;

use JLM\ModelBundle\Form\DataTransformer\PersonToIntTransformer;
use JLM\ModelBundle\Form\Type\AbstractHiddenType;

class PersonHiddenType extends AbstractHiddenType
{ 
    protected function getTransformerClass()
    {
    	return 'JLM\ModelBundle\Form\DataTransformer\PersonToIntTransformer';
    }
    
    protected function getTypeName()
    {
    	return 'person';
    }
}

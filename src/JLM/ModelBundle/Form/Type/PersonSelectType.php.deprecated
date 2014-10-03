<?php

namespace JLM\ModelBundle\Form\Type;

use JLM\ModelBundle\Form\DataTransformer\PersonToStringTransformer;
use JLM\ModelBundle\Form\Type\AbstractHiddenType;

class PersonSelectType extends AbstractSelectType
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

<?php

namespace JLM\ContactBundle\Form\Type;

use JLM\ContactBundle\Form\DataTransformer\PersonToStringTransformer;
use JLM\ContactBundle\Form\Type\AbstractHiddenType;

class PersonSelectType extends AbstractSelectType
{ 
    protected function getTransformerClass()
    {
    	return 'JLM\ContactBundle\Form\DataTransformer\PersonToIntTransformer';
    }
    
    protected function getTypeName()
    {
    	return 'jlm_contact_person';
    }
}

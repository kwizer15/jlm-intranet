<?php

namespace JLM\TransmitterBundle\Form\Type;

use JLM\TransmitterBundle\Form\DataTransformer\AskToIntTransformer;
use JLM\ModelBundle\Form\Type\AbstractHiddenType;

class AskHiddenType extends AbstractHiddenType
{ 
    protected function getTransformerClass()
    {
    	return 'JLM\TransmitterBundle\Form\DataTransformer\AskToIntTransformer';
    }
    
    protected function getTypeName()
    {
    	return 'transmitter_ask';
    }
}
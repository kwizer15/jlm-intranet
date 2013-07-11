<?php
namespace JLM\ModelBundle\Form\DataTransformer;

use JLM\ModelBundle\Form\DataTransformer\ObjectToIntTransformer;

class PersonToStringTransformer extends ObjectToIntTransformer
{
	protected function getClass()
	{
		return 'JLMModelBundle:Product';
	}
	
	protected function getErrorMessage()
	{
		return 'A person name "%s" does not exist!';
	}
}
<?php
namespace JLM\ModelBundle\Form\DataTransformer;

use JLM\ModelBundle\Form\DataTransformer\ObjectToIntTransformer;

class PersonToIntTransformer extends ObjectToIntTransformer
{
	public function getClass()
	{
		return 'JLMModelBundle:Product';
	}
	
	protected function getErrorMessage()
	{
		return 'A person with id "%s" does not exist!';
	}
}
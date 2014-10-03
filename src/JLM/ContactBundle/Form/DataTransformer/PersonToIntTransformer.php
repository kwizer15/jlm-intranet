<?php
namespace JLM\ContactBundle\Form\DataTransformer;

use JLM\ContactBundle\Form\DataTransformer\ObjectToIntTransformer;

class PersonToIntTransformer extends ObjectToIntTransformer
{
	public function _getClass()
	{
		return 'JLMContactBundle:Person';
	}
	
	protected function getErrorMessage()
	{
		return 'A person with id "%s" does not exist!';
	}
}
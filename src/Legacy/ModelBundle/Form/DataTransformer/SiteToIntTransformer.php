<?php
namespace JLM\ModelBundle\Form\DataTransformer;

use JLM\ModelBundle\Form\DataTransformer\ObjectToIntTransformer;

class SiteToIntTransformer extends ObjectToIntTransformer
{
	public function getClass()
	{
		return 'JLMModelBundle:Site';
	}
	
	protected function getErrorMessage()
	{
		return 'A site with id "%s" does not exist!';
	}
}
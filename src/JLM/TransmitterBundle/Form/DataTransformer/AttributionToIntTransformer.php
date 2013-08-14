<?php
namespace JLM\TransmitterBundle\Form\DataTransformer;

use JLM\ModelBundle\Form\DataTransformer\ObjectToIntTransformer;

class AttributionToIntTransformer extends ObjectToIntTransformer
{
	public function getClass()
	{
		return 'JLMTransmitterBundle:Attribution';
	}
	
	protected function getErrorMessage()
	{
		return 'A transmitter attribution with id "%s" does not exist!';
	}
}
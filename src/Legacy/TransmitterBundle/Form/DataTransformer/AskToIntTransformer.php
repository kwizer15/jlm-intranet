<?php
namespace JLM\TransmitterBundle\Form\DataTransformer;

use JLM\ModelBundle\Form\DataTransformer\ObjectToIntTransformer;

class AskToIntTransformer extends ObjectToIntTransformer
{
	public function getClass()
	{
		return 'JLMTransmitterBundle:Ask';
	}
	
	protected function getErrorMessage()
	{
		return 'A transmitter ask with id "%s" does not exist!';
	}
}
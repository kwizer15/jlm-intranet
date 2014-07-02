<?php
namespace JLM\ModelBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use JLM\ModelBundle\Entity\City;

class CityToIntTransformer extends ObjectToIntTransformer
{
	public function getClass()
	{
		return 'JLMModelBundle:City';
	}
	
	protected function getErrorMessage()
	{
		return 'A city with id "%s" does not exist!';
	}
}
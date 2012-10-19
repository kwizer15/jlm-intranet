<?php
namespace JLM\ModelBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use JLM\ModelBundle\Entity\City;

class CityToStringTransformer implements DataTransformerInterface
{
	/**
	 * @var ObjectManager
	 */
	private $om;
	
	/**
	 * @param ObjectManager $om
	 */
	public function __construct(ObjectManager $om)
	{
		$this->om = $om;
	}
	
	/**
	 * Transforms an object (city) to a string (name).
	 *
	 * @param  City|null $city
	 * @return string
	 */
	public function transform($city)
	{
		if (null === $city) {
			return "";
		}
	
		return $city->getName().' ('.$city->getZip().')';
	}
	
	/**
	 * Transforms a string (number) to an object (issue).
	 *
	 * @param  string $number
	 * @return City|null
	 * @throws TransformationFailedException if object (city) is not found.
	 */
	public function reverseTransform($string)
	{
		if (!$string) {
			return null;
		}
	
		preg_match('#^(.+) \((.*)\)$#',$string,$matches);
		
		$city = $this->om
			->getRepository('JLMModelBundle:City')
			->findOneBy(array('name' => $matches[1],'zip' => $matches[2]))
		;
	
		if (null === $city) {
			throw new TransformationFailedException(sprintf(
					'An issue with name "%s" does not exist!',
					$matches[1]
			));
		}
	
		return $city;
	}
}
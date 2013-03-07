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
	
		return $city->getZip().' - '.$city->getName();
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
	
		if (preg_match('#^([0-9AB]{5}( CEDEX[ 0-9]{0,3})?) - (.+)$#',$string,$matches))
		{	
		
			$city = $this->om
				->getRepository('JLMModelBundle:City')
				->findOneBy(array('zip' => trim($matches[1]),'name' => trim($matches[3])))
			;
		//	print_r($matches);
		//	echo '|'.$matches[1].'|'.$matches[3].'|'; exit;
		}
		else
			throw new TransformationFailedException(sprintf(
					'Aucune correspondance'));
		
		if (null === $city) {
			throw new TransformationFailedException(sprintf(
					'An issue with name "%s" does not exist!',
					$matches[1].' - '.$matches[3]
			));
		}
		return $city;
	}
}
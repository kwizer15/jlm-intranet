<?php
namespace JLM\OfficeBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;

class QuoteToIntTransformer implements DataTransformerInterface
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
	 * Transforms an object (quote) to an integer (id).
	 *
	 * @param  Quote|null $entity
	 * @return int
	 */
	public function transform($entity)
	{
		if (null === $entity) {
			return "";
		}
		return $entity->getId();
	}
	
	/**
	 * Transforms an integer (number) to an object (quote).
	 *
	 * @param  int $number
	 * @return Quote|null
	 * @throws TransformationFailedException if object (quote) is not found.
	 */
	public function reverseTransform($id)
	{
		if (!$id) {
			return null;
		}
	
		
			$entity = $this->om
				->getRepository('JLMCommerceBundle:Quote')
				->find($id)
			;
		if (null === $entity) {
			throw new TransformationFailedException(sprintf(
					'A quote with id "%s" does not exist!',
					$id
			));
		}
	
		return $entity;
	}
}
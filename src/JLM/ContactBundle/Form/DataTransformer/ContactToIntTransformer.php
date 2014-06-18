<?php
namespace JLM\ContactBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;

class ContactToIntTransformer implements DataTransformerInterface
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
	 * @param  ContactInterface|null $entity
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
	 * Transforms an integer (id) to an object (contact).
	 *
	 * @param  int $id
	 * @return ContactInterface|null
	 * @throws TransformationFailedException if object (contact) is not found.
	 */
	public function reverseTransform($id)
	{
		if (!$id) {
			return null;
		}
	
		
			$entity = $this->om
				->getRepository('JLMContactBundle:ContactInterface')
				->find($id)
			;
		if (null === $entity) {
			throw new TransformationFailedException(sprintf(
					'Contact with id "%s" does not exist!',
					$id
			));
		}
	
		return $entity;
	}
}
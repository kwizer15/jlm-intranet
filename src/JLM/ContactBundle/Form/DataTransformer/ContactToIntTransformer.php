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
	 * {@inheritdoc}
	 */
	public function transform($entity)
	{
		if (null === $entity) {
			return '';
		}
		return $entity->getId();
	}

	/**
	 * {@inheritdoc}
	 */
	public function reverseTransform($id)
	{
		if (!$id)
			return null;
	
		
		$entity = $this->om
				->getRepository('JLMContactBundle:Contact')
				->find($id)
			;
		if (null === $entity) {
			throw new TransformationFailedException(sprintf(
					'A contact with id "%s" does not exist!',
					$id
			));
		}
	
		return $entity;
	}
}
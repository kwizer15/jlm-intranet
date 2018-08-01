<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ProductBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class ProductToIntTransformer implements DataTransformerInterface
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
	 * Transforms an object (product) to a int (id).
	 *
	 * @param  Product|null $entity
	 * @return string
	 */
	public function transform($entity)
	{
		if (null === $entity)
		{
			return "";
		}
		
		return $entity->getId();
	}
	
	/**
	 * Transforms a int (id) to an object (product).
	 *
	 * @param  string $id
	 * @return Trustee|null
	 * @throws TransformationFailedException if object (trustee) is not found.
	 */
	public function reverseTransform($id)
	{
		if (!$id)
		{
			return null;
		}
	
		$entity = $this->om->getRepository('JLMProductBundle:Product')->find($id);
		if (null === $entity)
		{
			throw new TransformationFailedException(sprintf('A product with id "%s" does not exist!', $id));
		}
	
		return $entity;
	}
}
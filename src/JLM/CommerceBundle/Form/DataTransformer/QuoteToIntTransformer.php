<?php

/*
 * This file is part of the JLMCommerceBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CommerceBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
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
	 * {@inheritdoc}
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
	 * {@inheritdoc}
	 */
	public function reverseTransform($id)
	{
		if (!$id)
		{
			return null;
		}
	
		$entity = $this->om->getRepository('JLMCommerceBundle:Quote')->find($id);
		if (null === $entity)
		{
			throw new TransformationFailedException(sprintf(
					'A quote with id "%s" does not exist!',
					$id
			));
		}
	
		return $entity;
	}
}
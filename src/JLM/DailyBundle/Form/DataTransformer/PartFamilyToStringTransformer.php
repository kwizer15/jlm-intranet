<?php

/*
 * This file is part of the JLMDailyBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\DailyBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use JLM\DailyBundle\Entity\PartFamily;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class PartFamilyToStringTransformer implements DataTransformerInterface
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
	 * Transforms an object (product) to a string (name).
	 *
	 * @param  PartFamily|null $entity
	 * @return string
	 */
	public function transform($entity)
	{
		if (null === $entity)
		{
			return "";
		}
		
		return $entity->getName();
	}
	
	/**
	 * Transforms a string (name) to an object (product).
	 *
	 * @param  string $name
	 * @return PartFamily|null
	 * @throws TransformationFailedException if object (trustee) is not found.
	 */
	public function reverseTransform($name)
	{
		if (!$name)
		{
			return null;
		}
	
		$entity = $this->om->getRepository('JLMDailyBundle:PartFamily')->findOneBy(array('name'=>$name));
		if (null === $entity)
		{
			$entity = new PartFamily();
			$entity->setName($name);
			$this->om->persist($entity);
		}

		return $entity;
	}
}
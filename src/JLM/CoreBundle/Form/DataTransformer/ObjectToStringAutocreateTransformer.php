<?php

/*
 * This file is part of the JLMCoreBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CoreBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class ObjectToStringAutocreateTransformer implements DataTransformerInterface
{
	/**
	 * @var ObjectManager
	 */
	private $om;

	/**
	 * @var string
	 */
	private $entityClass;
	
	/**
	 * @var string
	 */
	private $parameterName;

	/**
	 * @param ObjectManager $om
	 */
	public function __construct(ObjectManager $om, $entityClass, $parameterName = 'name')
	{
		$this->om = $om;
		$this->entityClass = $entityClass;
		$this->parameterName = $parameterName;
	}
	
	/**
	 * Transforms an object (product) to a string (name).
	 *
	 * @param  PartFamily|null $entity
	 * @return string
	 */
	public function transform($entity)
	{
		$class = $this->entityClass;
		if ($entity instanceof $class)
		{
			$getter = $this->_getUniqueGetFunction();
			
			if (method_exists($entity, $getter))
			{
				return $entity->$getter();
			}
		}
		
		return "";
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
	
		$param = $this->parameterName;
		$class = $this->entityClass;
		$entity = $this->om->getRepository($class)->findOneBy(array($param => $name));
		if (null === $entity)
		{
			
			$entity = new $class();
			$setter = $this->_getUniqueSetFunction();
			$entity->$setter($name);
			$entity = $this->_initEntity($entity);
			$this->om->persist($entity);
		}

		return $entity;
	}
	
	/**
	 * Get getter method name
	 * @return string
	 */
	private function _getUniqueGetFunction()
	{
		return 'get'.ucwords($this->parameterName);
	}
	
	/**
	 * Get setter method name
	 * @return string
	 */
	private function _getUniqueSetFunction()
	{
		return 'set'.ucwords($this->parameterName);
	}
	
	protected function _initEntity($entity)
	{
		return $entity;
	}
}
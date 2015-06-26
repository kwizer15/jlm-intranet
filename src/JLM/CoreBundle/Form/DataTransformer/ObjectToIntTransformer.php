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
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
abstract class ObjectToIntTransformer implements DataTransformerInterface
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
		return (null === $entity) ? '' : $entity->getId();
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
		$entity = $this->om
		  ->getRepository($this->_getClass())
		  ->find($id)
		;
		if (null === $entity)
		{
			throw new TransformationFailedException(sprintf($this->_getErrorMessage(), $id));
		}
	
		return $entity;
	}
	
	/**
	 * Return class name
	 * 
	 * @return string
	 */
	abstract protected function _getClass();
	
	/**
	 * Get error message
	 * 
	 * @return string
	 */
	protected function _getErrorMessage()
	{
		return 'A '.$this->_getClass().' object with id "%s" does not exist!';
	}
}
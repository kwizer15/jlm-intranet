<?php

/*
 * This file is part of the JLMCommerceBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CommerceBundle\Entity;

use JLM\CommerceBundle\Model\BoostMethodInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class BoostMethod implements BoostMethodInterface
{
	/**
	 * The id
	 * @var int
	 */
	private $id;
	
	/**
	 * The method name
	 * @var string
	 */
	private $name;
	
	/**
	 * Get the id
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}
	
	/**
	 * Set the method name
	 * @param string $name
	 * @return self
	 */
	public function setName($name)
	{
		$this->name = $name;
		
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getName()
	{
		return $this->name;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function __toString()
	{
		return $this->name;
	}
}
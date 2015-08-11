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

use JLM\CommerceBundle\Model\CommercialPartLineInterface;
use JLM\ProductBundle\Model\ProductInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
abstract class CommercialPartLine implements CommercialPartLineInterface 
{
	/**
	 * Position de la ligne dans le devis
	 * @var position
	 */
	private $position = 0;
	
	/**
	 * @var string $designation
	 */
	private $designation;
	
	/**
	 * Set position
	 *
	 * @param int $position
	 * @return self
	 */
	public function setPosition($position)
	{
		$this->position = $position;
	
		return $this;
	}
	
	/**
	 * Get position
	 *
	 * @return int
	 */
	public function getPosition()
	{
		return $this->position;
	}
	
	/**
	 * Set designation
	 *
	 * @param string $designation
	 * @return self
	 */
	public function setDesignation($designation)
	{
		$this->designation = $designation;
	
		return $this;
	}
	
	/**
	 * Get designation
	 *
	 * @return string
	 */
	public function getDesignation()
	{
		return $this->designation;
	}
}
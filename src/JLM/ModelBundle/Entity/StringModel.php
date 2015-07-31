<?php

/*
 * This file is part of the JLMModelBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ModelBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
abstract class StringModel
{
	/**
	 * @var string
	 * 
	 * @Assert\NotNull
	 * @Assert\Type(type="string")
	 * @Assert\NotBlank
	 */
	private $name = '';
	
	/**
	 * Set text
	 *
	 * @param string $text
	 */
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}

	/**
	 * Get text
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * To String
	 */
	public function __toString()
	{
		return $this->getName();
	}
}
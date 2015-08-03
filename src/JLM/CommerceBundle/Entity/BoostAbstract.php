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

use JLM\CommerceBundle\Model\BoostInterface;
use JLM\CommerceBundle\Model\BoostMethodInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
abstract class BoostAbstract implements BoostInterface
{
	/**
	 * @var \DateTime
	 */
	private $date;
	
	/**
	 * @var string
	 */
	private $comment;
	
	/**
	 * Set the boost date
	 * @param \DateTime $date
	 * @return self
	 */
	public function setDate(\DateTime $date)
	{
		$this->date = $date;
		
		return $this;
	}
	
	/**
	 * Get the boost date
	 * @return DateTime
	 */
	public function getDate()
	{
		return $this->date;
	}
	
	/**
	 * Set the comment
	 * @param string $comment
	 * @return self
	 */
	public function setComment($comment)
	{
		$this->comment = $comment;
		
		return $this;
	}
	
	/**
	 * Get the comment
	 * @return string
	 */
	public function getComment()
	{
		return $this->comment;
	}
	
	/**
	 * Set the boost method
	 * @param BoostMethodInterface $method
	 * @return self
	 */
	public function setMethod(BoostMethodInterface $method)
	{
		$this->method = $method;
		
		return $this;
	}
	
	/**
	 * Get the boost method
	 * @return BoostMethodInterface
	 */
	public function setMethod()
	{
		return $this->method;
	}
}
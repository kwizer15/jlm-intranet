<?php

/*
 * This file is part of the JLMFrontBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\FrontBundle\Entity;

use JLM\FrontBundle\Model\ContactInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class AskQuote implements ContactInterface
{
	/**
	 * @var string
	 */
	private $firstName;
	
	/**
	 * @var string
	 */
	private $lastName;
	
	/**
	 * @var string
	 */
	private $phone;
	
	/**
	 * @var string
	 */
	private $email;
	
	/**
	 * 
	 * @var string
	 */
	private $quoteNumber;
	
	/**
	 * Set the first name
	 * @param string $firstName
	 * @return self
	 */
	public function setFirstName($firstName)
	{
		$this->firstName = $firstName;
	
		return $this;
	}
	
	/**
	 * Get the first name
	 *
	 * @return string
	 */
	public function getFirstName()
	{
		return $this->firstName;
	}
	
	/**
	 * Set the last name
	 * @param string $lastName
	 * @return self
	 */
	public function setLastName($lastName)
	{
		$this->lastName = $lastName;
	
		return $this;
	}
	
	/**
	 * Get the lest name
	 *
	 * @return string
	 */
	public function getLastName()
	{
		return $this->lastName;
	}
	
	/**
	 * Set the phone
	 * @param string $phone
	 * @return self
	 */
	public function setPhone($phone)
	{
		$this->phone = $phone;
	
		return $this;
	}
	
	/**
	 * Get the phone
	 *
	 * @return string
	 */
	public function getPhone()
	{
		return $this->phone;
	}
	
	/**
	 * Set the email
	 * @param string $email
	 * @return self
	 */
	public function setEmail($email)
	{
		$this->email = $email;
	
		return $this;
	}
	
	/**
	 * Get the email
	 *
	 * @return string
	 */
	public function getEmail()
	{
		return $this->email;
	}
	
	/**
	 * Get the quote number
	 * 
	 * @return string
	 */
	public function getQuoteNumber()
	{
		return $this->quoteNumber;
	}
	
	/**
	 * Set the quote number
	 * 
	 * @param $quoteNumber string
	 * @return self
	 */
	public function setQuoteNumber($quoteNumber)
	{
		$this->quoteNumber = $quoteNumber;
		
		return $this;
	}
}
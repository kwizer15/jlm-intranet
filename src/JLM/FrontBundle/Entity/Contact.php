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
class Contact implements ContactInterface
{
	/**
	 * @var string
	 */
	private $subject;

	/**
	 * @var string
	 */
	private $content;

	/**
	 * @var string
	 */
	private $company;

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
	private $address;
	
	/**
	 * @var string
	 */
	private $zip;
	
	/**
	 * @var string
	 */
	private $city;
	
	/**
	 * @var string
	 */
	private $country;
	
	/**
	 * @var string
	 */
	private $phone;
	
	/**
	 * @var string
	 */
	private $email;
	
	/**
	 * Set the subject
	 * @param string $subject
	 * @return self
	 */
	public function setSubject($subject)
	{
		$this->subject = $subject;
		
		return $this;
	}
	
	/**
	 * Get the subject
	 *
	 * @return string
	 */
	public function getSubject()
	{
		return $this->subject;
	}
	
	/**
	 * Set the content
	 * @param string $content
	 * @return self
	 */
	public function setContent($content)
	{
		$this->content = $content;
	
		return $this;
	}
	
	/**
	 * Get the content
	 *
	 * @return string
	 */
	public function getContent()
	{
		return $this->content;
	}
	
	/**
	 * Set the company
	 * @param string $company
	 * @return self
	 */
	public function setCompany($company)
	{
		$this->company = $company;
		
		return $this;
	}
	
	/**
	 * Get the company
	 *
	 * @return string
	 */
	public function getCompany()
	{
		return $this->company;
	}
	
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
	 * Set the address
	 * @param string $address
	 * @return self
	 */
	public function setAddress($address)
	{
		$this->address = $address;
		
		return $this;
	}
	
	/**
	 * Get the address
	 *
	 * @return string
	 */
	public function getAddress()
	{
		return $this->address;
	}
	
	/**
	 * Set the zip
	 * @param string $zip
	 * @return self
	 */
	public function setZip($zip)
	{
		$this->zip = $zip;
		
		return $this;
	}
	
	/**
	 * Get the zip
	 *
	 * @return string
	 */
	public function getZip()
	{
		return $this->zip;
	}
	
	/**
	 * Set the city
	 * @param string $city
	 * @return self
	 */
	public function setCity($city)
	{
		$this->city = $city;
		
		return $this;
	}
	
	/**
	 * Get the city
	 *
	 * @return string
	 */
	public function getCity()
	{
		return $this->city;
	}
	
	/**
	 * Set the country
	 * @param string $country
	 * @return self
	 */
	public function setCountry($country)
	{
		$this->country = $country;
		
		return $this;
	}
	
	/**
	 * Get the country
	 *
	 * @return string
	 */
	public function getCountry()
	{
		return $this->country;
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
}
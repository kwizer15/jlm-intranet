<?php
namespace JLM\ContactBundle\Entity;

interface EmailInterface
{
	/**
	 * Constructor
	 * @param email
	 */
	public function __construct($address = null);
	
	/**
	 * To String
	 * @return string
	 */
	public function __toString();
}
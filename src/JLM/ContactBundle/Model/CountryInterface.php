<?php

namespace JLM\ContactBundle\Model;

/**
 * Interface pour Country
 * @author kwizer
 */
interface CountryInterface
{
	/**
	 * Set code
	 * @param string $code
	 * @return self
	 */
	public function setCode($code);
	
	/**
	 * Get code
	 * @return string
	 */
	public function getCode();
	
	/**
	 * Set name
	 * @param string $name
	 * @return self
	 */
	public function setName($name);
	
	/**
	 * Get name
	 * @return string
	 */
	public function getName();
	
	/**
	 * To string
	 * @return string
	 */
	public function __toString();
}
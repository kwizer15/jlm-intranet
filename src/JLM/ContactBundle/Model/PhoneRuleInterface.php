<?php
namespace JLM\ContactBundle\Model;

interface PhoneRuleInterface
{
	/**
	 * Constructor
	 */
	public function __construct($format, $code, $localCode = null, CountryInterface $country = null);
	
	/**
	 * Get code
	 *
	 * @return string
	 */
	public function getCode();
	
	/**
	 * Get localCode
	 *
	 * @return integer
	 */
	public function getLocalCode();
	
	/**
	 * Get format
	 *
	 * @return string
	 */
	public function getFormat();
	
	/**
	 * Get country
	 *
	 * @return Country
	 */
	public function getCountry();
	
	/**
	 * Is Valid
	 *
	 * @return boolean
	 */
	public function isValid($number);
	
}
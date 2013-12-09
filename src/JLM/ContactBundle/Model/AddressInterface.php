<?php
namespace JLM\ContactBundle\Model;

interface AddressInterface
{
	/**
	 * Get Street
	 * 
	 * @return string
	 */
	public function getStreet();
	
	/**
	 * Get City
	 * 
	 * @return string
	 */
	public function getCity();
	
	/**
	 * Get Zip
	 * 
	 * @return string
	 */
	public function getZip();
	
	/**
	 * Get Country
	 
	 * @return string
	 */
	public function getCountry();
	
	/**
	 * To String
	 * 
	 * @return string
	 */
	public function __toString();
}
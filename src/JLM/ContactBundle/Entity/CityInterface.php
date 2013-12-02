<?php
namespace JLM\ContactBundle\Entity;

/**
 * Interface pour City
 * @author kwizer
 */
interface CityInterface
{
	/**
	 * Contructor
	 * @param string $name
	 * @param string $zip
	 * @param CountryInterface $country
	 */
	public function __construct($name, $zip, CountryInterface $country);
	
	/**
	 * Set name
	 * @param string $name
	 * @return self
	 */
	public function setName($name);
	
	/**
	 * get name
	 * @return string
	 */
	public function getName();
	
	/**
	 * set zip
	 * @param string $zip
	 * @return self
	 */
	public function setZip($zip);
	
	/**
	 * get zip
	 * @return string
	 */
	public function getZip();
	
	/**
	 * set Country
	 * @param CountryInterface $country
	 * @return self
	 */
	public function setCountry(CountryInterface $country = null);
	
	/**
	 * get Country
	 * @return CountryInterface
	 */
	public function getCountry();
	
	/**
	 * To string
	 * @return string
	 */
	public function __toString();
	
}
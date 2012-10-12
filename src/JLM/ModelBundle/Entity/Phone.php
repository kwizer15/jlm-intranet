<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JLM\ModelBundle\Entity\Phone
 *
 * @ORM\Table(name="phones")
 * @ORM\Entity
 */
class Phone
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

	/**
	 * Fax
	 * @var bool $fax
	 * 
	 * @ORM\Column(name="fax", type="boolean")
	 */
    private $fax;
    
    /**
     * Prefix
     * @var Country $country
     * 
     * @ORM\ManyToOne(targetEntity="Country")
     * @ORM\JoinColumn(name="country_code", referencedColumnName="code")
     */
    private $country;
    
    /**
     * @var string $number
     *
     * @ORM\Column(name="number", type="string", length=20)
     */
    private $number;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set number
     *
     * @param string $number
     */
    public function setNumber($number)
    {
        $this->number = str_replace(array(' ',',','.','-','/'),'',$number);
    }

    /**
     * Get number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }
    
    /**
     * To String
     */
    public function __toString()
    {
    	return $this->getNumber();
    }

    /**
     * Set fax
     *
     * @param boolean $fax
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
    }

    /**
     * Get fax
     *
     * @return boolean 
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set country
     *
     * @param JLM\ModelBundle\Entity\Country $country
     */
    public function setCountry(\JLM\ModelBundle\Entity\Country $country)
    {
        $this->country = $country;
    }

    /**
     * Get country
     *
     * @return JLM\ModelBundle\Entity\Country 
     */
    public function getCountry()
    {
        return $this->country;
    }
}
<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JLM\ModelBundle\Entity\Address
 *
 * @ORM\Table(name="addresses")
 * @ORM\Entity
 */
class Address
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
     * @var string $street
     *
     * @ORM\Column(name="street", type="string", length=255)
     */
    private $street;

    /**
     * @var string $box
     *
     * @ORM\Column(name="box", type="smallint", nullable=true)
     */
    private $box;
    
    /**
     * @var string $zip
     *
     * @ORM\ManyToOne(targetEntity="Zip")
     */
    private $zip;

    /**
     * @var string $city
     *
     * @ORM\ManyToOne(targetEntity="City")
     */
    private $city;
   
    /**
     * @var string $supplement
     *
     * @ORM\Column(name="supplement", type="string", length=255, nullable=true)
     */
    private $supplement;

    
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
     * Set street
     *
     * @param string $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * Get street
     *
     * @return string 
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set box
     *
     * @param string $box
     */
    public function setBox($box)
    {
    	$this->box = $box;
    }
    
    /**
     * Get box
     *
     * @return string
     */
    public function getBox()
    {
    	return $this->box;
    }
    
    /**
     * Set zip
     *
     * @param string $zip
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
    }

    /**
     * Get zip
     *
     * @return string 
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Set city
     *
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set supplement
     *
     * @param string $supplement
     */
    public function setSupplement($supplement)
    {
    	$this->supplement = $supplement;
    }
    
    /**
     * Get supplement
     *
     * @return string
     */
    public function getSupplement()
    {
    	return $this->supplement;
    }
    
    /**
     * Set Country
     *
     * @param Country $country
     */
    public function setCountry(Country $country)
    {
    	$this->country = $country;
    }
    
    /**
     * Get Country
     * 
     * @return Country
     */
    public function getCountry()
    {
    	return $this->country;
    }

}
<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * JLM\ModelBundle\Entity\City
 *
 * @ORM\Table(name="cities")
 * @ORM\Entity(repositoryClass="JLM\ModelBundle\Entity\CityRepository", readOnly=true)
 */
class City
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
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string $zips
     * 
     * @ORM\Column(name="zip",type="string",length=20)
     */
    private $zip;
    
    /**
     * @var Country $country
     * 
     * @ORM\ManyToOne(targetEntity="Country")
     * @ORM\JoinColumn(name="country_code", referencedColumnName="code")
     */
    private $country;
    
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
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * To String
     */
    public function __toString()
    {
    	return $this->getName().' ('.$this->getZip().')';
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
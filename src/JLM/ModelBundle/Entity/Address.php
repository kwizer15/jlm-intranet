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
     * Adresse de facturation
     * @var bool $billing;
     * 
     * @ORM\Column(name="billing", type="boolean")
     */
    private $billing;
    
    /**
     * @var string $street
     *
     * @ORM\Column(name="street", type="text")
     */
    private $street;
    
    /**
     * @var string $city
     *
     * @ORM\ManyToOne(targetEntity="City")
     */
    private $city;
    
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
     * Set billing
     *
     * @param boolean $billing
     */
    public function setBilling($billing)
    {
        $this->billing = $billing;
    }

    /**
     * Get billing
     *
     * @return boolean 
     */
    public function getBilling()
    {
        return $this->billing;
    }
}
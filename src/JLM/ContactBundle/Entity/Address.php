<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ContactBundle\Entity;

use JLM\ContactBundle\Model\AddressInterface;
use JLM\ContactBundle\Model\CityInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class Address implements AddressInterface
{
    /**
     * @var integer $id
     */
    protected $id;
    
    /**
     * @var string $street
     */
    protected $street = '';
    
    /**
     * @var string $city
     */
    protected $city;
    
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
     * @return self
     */
    public function setStreet($street)
    {
        $this->street = (string)$street;
        
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set city
     *
     * @param CityInterface $city
     * @return self
     */
    public function setCity(CityInterface $city = null)
    {
        $this->city = $city;
        
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCity()
    {
        return $this->city;
    }
    
    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
    	return ($this->getStreet() == '') ? (string)$this->getCity() : $this->getStreet().chr(10).$this->getCity();
    }
    
    /**
     * To String
     * 
     * @deprecated
     * @return string
     */
    public function toString()
    {
    	return $this->getStreet().chr(10).$this->getCity()->toString();
    }
}
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

use JLM\ContactBundle\Model\ContactPhoneInterface;
use JLM\ContactBundle\Model\ContactInterface;
use JLM\ContactBundle\Model\PhoneInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class ContactPhone implements ContactPhoneInterface
{
    /**
     * @var int
     */
    private $id;
    
    /**
     * @var string
     */
    private $label;
    
    /**
     * @var PhoneInterface
     */
    private $phone;

    /**
     * Get id
     * @return number
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Set label
     * @param string $label
     * @return self
     */
    public function setLabel($label)
    {
        $this->label = $label;
        
        return $this;
    }
    
    /**
     * Get label
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }
    
    /**
     * Get phone
     * @return PhoneInterface
     */
    public function getPhone()
    {
    	return $this->phone;
    }
    
    /**
     * Set phone
     * @param PhoneInterface $phone
     * @return self
     */
    public function setPhone(PhoneInterface $phone)
    {
    	$this->phone = $phone;
    	
    	return $this;
    }
    
    /**
     * Set number
     * @param string $number
     * @return self
     */
    public function setPhoneNumber($number)
    {
        return $this->phone->setNumber($number);
    }
    
    /**
     * Get number
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phone->getNumber();
    }
    
    /**
     * Get number
     * @return string
     */
    public function getNumber()
    {
    	return $this->phone->getNumber();
    }
    
    /**
     * To string
     * @return string
     */
    public function __toString()
    {
        return $this->getLabel() . ' : ' . $this->phone->getNumber();
    }
} 
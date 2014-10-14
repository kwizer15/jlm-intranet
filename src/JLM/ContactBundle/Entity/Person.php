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

use JLM\ContactBundle\Model\PersonInterface;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class Person extends Contact implements PersonInterface
{
	/**
     * @var integer $id
     * @deprecated
     */
    protected $id;
    
	/**
	 * M. Mme Mlle
	 * @var string $title
	 */
	protected $title;
	
    /**
     * @var string $firstName
     */
    protected $firstName;

    /**
     * @var string $lastName
     */
    protected $lastName;
    
    /**
     * @var string $fixedPhone
     */
    protected $fixedPhone;
    
    /**
     * @var string $mobilePhone
     */
    protected $mobilePhone;
    
    /**
     * @var $role
     */
    protected $role;
    
    /**
     * Set firstName
     *
     * @param string $firstName
     * @return self
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return self
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLastName()
    {
        return $this->lastName;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
    	return trim($this->title.' '.trim($this->lastName.' '.$this->firstName));
    }

    /**
     * Get id
     * @deprecated
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;
        
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Format phones
     * 
     * @return self
     */
    public function formatPhones()
    {
    	$this->fixedPhone = str_replace('+33','0',$this->fixedPhone);
    	$this->fixedPhone = str_replace(array('-','/','.',','),'',$this->fixedPhone);
    	$this->mobilePhone = str_replace('+33','0',$this->mobilePhone);
    	$this->mobilePhone = str_replace(array('-','/','.',','),'',$this->mobilePhone);
    	$fax = $this->getFax();
    	$fax = str_replace('+33','0',$fax);
    	$fax = str_replace(array('-','/','.',','),'',$fax);
    	$this->setFax($fax);
    	
    	return $this;
    }
    
    /**
     * Set fixedPhone
     *
     * @param string $fixedPhone
     * @return self
     */
    public function setFixedPhone($fixedPhone)
    {
        $this->fixedPhone = $fixedPhone;
        
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getFixedPhone()
    {
        return $this->fixedPhone;
    }

    /**
     * Set mobilePhone
     *
     * @param string $mobilePhone
     * @return self
     */
    public function setMobilePhone($mobilePhone)
    {
        $this->mobilePhone = $mobilePhone;
        
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMobilePhone()
    {
        return $this->mobilePhone;
    }

    /**
     * Set role
     *
     * @param string $role
     * @return self
     */
    public function setRole($role)
    {
    	$this->role = $role;
    
    	return $this;
    }
    
    /**
     * Get role
     *
     * @return string
     * @deprecated
     */
    public function getRole()
    {
    	return $this->role;
    }
}
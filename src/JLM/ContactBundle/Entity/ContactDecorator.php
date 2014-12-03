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

use JLM\ContactBundle\Model\ContactInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
abstract class ContactDecorator implements ContactInterface
{
    /**
     * Identifier
     * @var int $id
     */
    private $id;
    
    /**
     * @var ContactInterface $person
     */
    protected $contact;
    
    public function __construct(ContactInterface $contact = null)
    {
    	if ($contact !== null)
    	{
    		$this->setContact($contact);
    	}
    }
    
    /**
     * Get id
     * @return int
     */
    public function getId()
    {
    	return $this->id;
    }
    
    /**
     * Get contact
     */
    public function getContact()
    {
        return $this->contact;
    }
    
    /**
     * Get contact
     */
    public function setContact(ContactInterface $contact)
    {
    	$this->contact = $contact;
    	
    	return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getAddress()
    {
    	return $this->decoratedGetMethod('getAddress', null);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getEmail()
    {
    	return $this->decoratedGetMethod('getEmail', '');
    }
    
    /**
     * {@inheritdoc}
     */
    public function getFax()
    {
        return $this->decoratedGetMethod('getFax', '');
    }
    
    /**
     * {@inheritdoc}
     */
    public function getPhones()
    {
    	return $this->decoratedGetMethod('getPhones', new ArrayCollection());
    }
    
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
    	return $this->decoratedGetMethod('getName', '');
    }
    
    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->decoratedGetMethod('__toString', '');
    }
    
    /**
     * 
     * @param string $method
     * @param mixed $default
     * @return mixed
     */
    private function decoratedGetMethod($method, $default)
    {
    	if ($this->getContact() === null)
    	{
    		return $default;
    	}
    	
    	return $this->getContact()->$method();
    }
}
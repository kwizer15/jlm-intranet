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
        return $this->getContact()->getAddress();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getEmail()
    {
        return $this->getContact()->getEmail();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getFax()
    {
        return $this->getContact()->getFax();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getContact()->getName();
    }
    
    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getContact()->__toString();
    }
}
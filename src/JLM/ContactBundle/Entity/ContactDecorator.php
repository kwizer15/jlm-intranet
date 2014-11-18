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
     * @var ContactInterface $person
     */
    protected $contact;
    
    /**
     * Constructor
     * @param ContactInterface $contact
     */
    public function __construct(ContactInterface $contact)
    {
        $this->contact = $contact;
    }
    
    /**
     * Get contact
     */
    protected function _getContact()
    {
        return $this->contact;
    } 
    
    /**
     * {@inheritdoc}
     */
    public function getAddress()
    {
        return $this->_getContact()->getAddress();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getEmail()
    {
        return $this->_getContact()->getEmail();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getFax()
    {
        return $this->_getContact()->getFax();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->_getContact()->getName();
    }
    
    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->_getContact()->__toString();
    }
}
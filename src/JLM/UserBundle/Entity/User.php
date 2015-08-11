<?php

/*
 * This file is part of the JLMUserBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use JLM\ContactBundle\Model\ContactInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class User extends BaseUser implements ContactInterface
{
    /**
     * ORM\Id
     * ORM\Column(type="integer")
     * ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var ContactInterface
     */
    private $contact;

    /**
     * Set contact
     *
     * @param ContactInterface $contact
     * @return self
     */
    public function setContact(ContactInterface $contact = null)
    {
        $this->contact = $contact;
    
        return $this;
    }

    /**
     * Get contact
     *
     * @return ContactInterface
     */
    public function getContact()
    {
        return $this->contact;
    }
    
    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        if (null === $this->getContact())
        {
            return parent::__toString();
        }
        
        return $this->getContact()->__toString();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getFax()
    {
        return $this->contact->getFax();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getAddress()
    {
        return $this->contact->getAddress();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->contact->getName();
    }
}

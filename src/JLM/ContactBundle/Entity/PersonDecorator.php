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
abstract class PersonDecorator extends ContactDecorator implements PersonInterface
{
    /**
     * Constructor
     * @param PersonInterface $person
     */
    public function __construct(PersonInterface $person)
    {
        parent::__construct($person);
    }
    
    /**
     * Get person
     */
    protected function _getPerson()
    {
        return $this->_getContact();
    } 
    
    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return $this->_getPerson()->getTitle();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getFirstName()
    {
        return $this->_getPerson()->getFirstName();
    }

    /**
     * {@inheritdoc}
     */
    public function getLastName()
    {
        return $this->_getPerson()->getLastName();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getFixedPhone()
    {
        return $this->_getPerson()->getFixedPhone();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getMobilePhone()
    {
        return $this->_getPerson()->getMobilePhone();
    }
}
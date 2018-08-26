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

use JLM\ContactBundle\Model\PhoneInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class Phone implements PhoneInterface
{
    /**
     * @var int
     */
    private $id;
    
    /**
     * @var string
     */
    private $number;
    
    /**
     * Get id
     * @return number
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Set number
     * @param string $number
     * @return self
     */
    public function setNumber($number)
    {
        $this->number = $number;
    
        return $this;
    }
    
    /**
     * Get number
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }
    
    /**
     * To string
     * @return string
     */
    public function __toString()
    {
        return $this->getNumber();
    }
}

<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ContactBundle\Model;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
interface ContactInterface
{

    /**
     * Get fax
     *
     * @return string
     */
    public function getFax();
    
    /**
     * Get email
     *
     * @return string
     */
    public function getEmail();
    
    /**
     * Get address
     *
     * @return AddressInterface
     */
    public function getAddress();
    
    /**
     * Get first name
     *
     * @return string
     */
    public function getName();
    
    /**
     * To String
     *
     * @return string
    */
    public function __toString();
}

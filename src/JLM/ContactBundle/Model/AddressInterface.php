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
interface AddressInterface
{
    /**
     * Get street
     *
     * @return string
     */
    public function getStreet();
    
    /**
     * Get city
     *
     * @return CityInterface
     */
    public function getCity();
    
    /**
     * To String
     * 
     * @return string
     */
    public function __toString();
    
}
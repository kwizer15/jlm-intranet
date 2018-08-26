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
interface PersonInterface extends ContactInterface
{
    /**
     * Get title
     *
     * @return string
     */
    public function getTitle();
    
    /**
     * Get first name
     *
     * @return string
     */
    public function getFirstName();
    
    /**
     * Get last name
     *
     * @return string
     */
    public function getLastName();
    
    /**
     * Get fixedPhone
     *
     * @return string
     */
    public function getFixedPhone();
    
    /**
     * Get mobilePhone
     *
     * @return string
     */
    public function getMobilePhone();
}

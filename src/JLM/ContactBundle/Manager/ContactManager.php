<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ContactBundle\Manager;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class ContactManager
{
    /**
     * Constructor
     * Singleton pattern
     */
    protected function __construct()
    {
        
    }
    
    /**
     * Create a Contact class
     * @param string $class
     * @return ContactInterface
     */
    public static function create($class)
    {
        $class = '\JLM\ContactBundle\Entity\\' . $class;
        
        return new $class;
    }
}
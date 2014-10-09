<?php

/*
 * This file is part of the JLMCondominiumBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CondominiumBundle\Model;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
interface AdministratorInterface
{
    /**
     * Get the name
     * @return string
     */
    public function getName();
    
    /**
     * Get the attorney
     * @return AttorneyInterface
     */
    public function getAttorney();
    
    /**
     * Get the members
     * @return AdministratorMembre[]
     */
    public function getMembers();
}
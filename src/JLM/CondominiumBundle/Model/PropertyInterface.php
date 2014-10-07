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
interface PropertyInterface
{
    /**
     * Get the address
     * @return AddressInterface
     */
    public function getAddress();
    
    /**
     * Get the owner
     * @return OwnerInterface
     */
    public function getOwner();
    
    /**
     * Get the manager
     * @return ManagerInterface
     */
    public function getManager();
}
<?php

/*
 * This file is part of the JLMContractBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ContractBundle\Model;

use JLM\CondominiumBundle\Model\ManagerInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
interface ContractInterface
{
    /**
     * Get number
     *
     * @return string
     */
    public function getNumber();
    
    /**
     * Get door
     *
     * @return JLM\ModelBundle\Entity\Door
     */
    public function getDoor();
    
    /**
     * Get fee
     *
     * @return float
     */
    public function getFee();
    
    /**
     * Get manager
     *
     * @return ManagerInterface
     */
    public function getManager();
    
    /**
     * To String
     * @return string
     */
    public function __toString();
}

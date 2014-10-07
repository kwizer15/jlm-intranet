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
interface CondominiumInterface
{
    /**
     * Get the manager
     * @return ManagerInterface
     */
    public function getManager();
    
    /**
     * Get the name
     * @return string
     */
    public function getName();
    
    /**
     * Get the union council
     * @return UnionCouncil
     */
    public function getUnionCouncil();
    
    /**
     * Get the union council members
     * @return UnionCouncilMemberInterface[]
     */
    public function getUnionCouncilMembers();
    
    /**
     * Get the union council chairman
     * @return UnionCouncilMemberInterface
     */
    public function getUnionCouncilChairman();
    
    /**
     * Get the guards
     * @return Guard[]
     */
    public function getGuards();
}
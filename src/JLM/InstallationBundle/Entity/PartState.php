<?php

/*
 * This file is part of the instalation-bundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\InstallationBundle\Entity;

use JLM\InstallationBundle\Model\PartStateInterface;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class PartState implements PartStateInterface
{
    /**
     * 
     * @var string
     */
    private $name;
    
    /**
     * 
     * @param string $name
     */
    public function __construct($name)
    {
        $this->setName($name);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * 
     * @param unknown $name
     * @return \JLM\InstallationBundle\Entity\PartState
     */
    public function setName($name)
    {
        $this->name = $name;
        
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getName();
    }
}
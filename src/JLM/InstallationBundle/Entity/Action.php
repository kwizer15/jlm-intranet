<?php

/*
 * This file is part of the installation-bundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\InstallationBundle\Entity;

use JLM\InstallationBundle\Model\ActionInterface;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class Action implements ActionInterface
{
    /**
     * @var string
     */
    private $name;
    
    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->setName($name);
    }
    
    /**
     * @param string $name
     * @return \JLM\InstallationBundle\Entity\Action
     */
    public function setName($name)
    {
        $this->name = $name;
        
        return $this;
    }
    
    /**
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
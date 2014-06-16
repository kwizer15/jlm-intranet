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
    private $name;
    
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
    
    public function setName($name)
    {
        $this->name = $name;
        
        return $this;
    }
}
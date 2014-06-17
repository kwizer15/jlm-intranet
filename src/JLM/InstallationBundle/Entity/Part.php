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

use JLM\InstallationBundle\Model\PartInterface;
use JLM\InstallationBundle\Model\PartTypeInterface;
use JLM\InstallationBundle\Model\InstallationInterface;
use JLM\InstallationBundle\Model\PartStateInterface;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class Part implements PartInterface
{
    /**
     * Localisation
     * @var string
     */
    private $location;
    
    /**
     * Installation
     * @var InstallationInterface
     */
    private $installation;
    
    /**
     * Type de la pièce
     * @var PartTypeInterface
     */
    private $type;
    
    /**
     * 
     * @param string $name
     * @param PartCategoryInterface $category
     * @param array|Traversable $states
     */
    public function __construct(InstallationInterface $installation, PartTypeInterface $type, $location)
    {
        $this->setInstallation($installation);
        $this->setType($type);
        $this->setLocation($location);
    }
    
    /**
     * @param string $location
     * @return self
     */
    public function setLocation($location)
    {
        $this->location = $location;
    
        return $this;
    }
    
    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }
    
    /**
     * @param PartTypeInterface $type
     * @return self
     */
    public function setType(PartTypeInterface $type)
    {
        $this->type = $type;
    
        return $this;
    }
    
    /** 
     * @return PartTypeInterface
     */
    public function getType()
    {
        return $this->type;
    }
    
    /**
     * @param InstallationInterface $installation
     * @return self
     */
    public function setInstallation(InstallationInterface $installation)
    {
        $this->installation = $installation;
    
        return $this;
    }
    
    /**
     * @return InstallationInterface
     */
    public function getInstallation()
    {
        return $this->installation;
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return $this->getType()->getName().' ('.$this->getLocation().')';
    }
}
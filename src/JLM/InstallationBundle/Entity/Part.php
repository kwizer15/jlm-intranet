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
     * Type de la pièce
     * @var PartTypeInterface
     */
    private $type;
    
    /**
     * Pièce parente
     * @var PartInterface
     */
    private $parent = null;
    
    /**
     * 
     * @param string $name
     * @param PartCategoryInterface $category
     * @param array|Traversable $states
     */
    public function __construct(PartTypeInterface $type, PartInterface $parent = null, $location = null)
    {
        $this->setType($type);
        $this->setLocation($location);
        $this->setParent($parent);
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
     * @param PartInterface $parent
     * @return self
     */
    public function setParent(PartInterface $parent)
    {
        $this->parent = $parent;
    
        return $this;
    }
    
    /**
     * @return PartInterface
     */
    public function getParent()
    {
        return $this->parent;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getType()->getName().' ('.$this->getLocation().')';
    }
    
    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getName();
    }
}
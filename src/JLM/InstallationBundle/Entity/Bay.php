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

use JLM\InstallationBundle\Model\BayInterface;
use JLM\InstallationBundle\Model\PartInterface;
use JLM\CollectiveHousingBundle\Model\BuildingInterface;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class Bay implements BayInterface
{
    /**
     * @var PartInterface
     */
    private $part;
    
    /**
     * @var BuildingInterface
     */
    private $building;
    
    /**
     * 
     * @param BuildingInterface $building
     * @param PartInterface $part
     */
    public function __construct(BuildingInterface $building, PartInterface $part = null)
    {
        $this->setBuilding($building);
        $this->setPart($part);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getPart()
    {
        return $this->part;
    } 
    
    /**
     * {@inheritdoc}
     */
    public function getBuilding()
    {
        return $this->building;
    }
    
    /**
     * 
     * @param PartInterface $part
     * @return \JLM\InstallationBundle\Entity\Bay
     */
    public function setPart(PartInterface $part = null)
    {
        $this->part = $part;
        
        return $this;
    }
    
    /**
     * 
     * @param BuildingInterface $building
     * @return \JLM\InstallationBundle\Entity\Bay
     */
    public function setBuilding(BuildingInterface $building)
    {
        $this->building = $building;
        
        return $this;
    }
}
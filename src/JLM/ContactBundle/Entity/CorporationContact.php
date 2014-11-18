<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ContactBundle\Entity;

use JLM\ContactBundle\Model\CorporationContactInterface;
use JLM\ContactBundle\Model\CorporationInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class CorporationContact extends PersonDecorator implements CorporationContactInterface
{   
    /**
     * @var CorporationInterface
     */
    protected $corporation;
    
    /**
     * Position
     * @var string
     */
    protected $position;

    /**
     * Manager
     * @var CorporationContactInterface
     */
    protected $manager;
    
    /**
     * {@inheritdoc}
     */
    public function getCorporation()
    {
        return $this->corporation;
    }
    
    /**
     * Set corporation
     * @param CorporationInterface $corporation
     * @return CorporationContactInterface
     */
    public function setCorporation(CorporationInterface $corporation)
    {
        $this->corporation = $corporation;
        
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getPosition()
    {
        return $this->position;
    }
    
    /**
     * Set the position
     * @param string $position
     * @return CorporationContactInterface
     */
    public function setPosition($position)
    {
        $this->position = $position;
        
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getManager()
    {
        return $this->manager;
    }
    
    /**
     * Set the manager
     * @param CorporationContactInterface $manager
     * @return CorporationContact
     */
    public function setManager(CorporationContactInterface $manager = null)
    {
        $this->manager = $manager;
        
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function hasManager()
    {
        return $this->getManager() !== null;
    }
}
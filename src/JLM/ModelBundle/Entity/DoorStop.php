<?php

/*
 * This file is part of the JLMModelBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class DoorStop
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $begin;

    /**
     * @var \DateTime
     */
    private $end;

    /**
     * @var string
     */
    private $reason;
    
    /**
     * @var string
     */
    private $state;

    /**
     * @var Door
     */
    private $door;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set begin
     *
     * @param \DateTime $begin
     * @return DoorStop
     */
    public function setBegin(\DateTime $begin = null)
    {
        $this->begin = $begin;
        
        return $this;
    }

    /**
     * Get begin
     *
     * @return \DateTime
     */
    public function getBegin()
    {
        return $this->begin;
    }

    /**
     * Set end
     *
     * @param \DateTime $end
     * @return DoorStop
     */
    public function setEnd(\DateTime $end = null)
    {
        $this->end = $end;
        
        return $this;
    }

    /**
     * Get end
     *
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Set reason
     *
     * @param string $reason
     * @return DoorStop
     */
    public function setReason($reason)
    {
        $this->reason = $reason;
    
        return $this;
    }

    /**
     * Get reason
     *
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * Set door
     *
     * @param \JLM\ModelBundle\Entity\Door $door
     * @return DoorStop
     */
    public function setDoor(\JLM\ModelBundle\Entity\Door $door = null)
    {
        $this->door = $door;
    
        return $this;
    }

    /**
     * Get door
     *
     * @return \JLM\ModelBundle\Entity\Door
     */
    public function getDoor()
    {
        return $this->door;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return DoorStop
     */
    public function setState($state)
    {
        $this->state = $state;
    
        return $this;
    }

    /**
     * Get state
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }
}

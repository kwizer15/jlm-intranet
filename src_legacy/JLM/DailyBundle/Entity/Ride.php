<?php

/*
 * This file is part of the JLMDailyBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\DailyBundle\Entity;

use JLM\ModelBundle\Entity\Door;

/**
 * Ride
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class Ride
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var Door
     */
    private $departure;
    
    /**
     * @var Door
     */
    private $destination;
    
    /**
     * Distance en mètre
     * @var int
     */
    private $distance;

    /**
     * Durée de trajet en secondes
     * @var int
     */
    private $duration;


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
     * Set distance
     *
     * @param int $distance
     * @return self
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;
    
        return $this;
    }

    /**
     * Get distance
     *
     * @return int
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * Set duration
     *
     * @param int $duration
     * @return self
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    
        return $this;
    }

    /**
     * Get duration
     *
     * @return int
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set departure
     *
     * @param Door $departure
     * @return self
     */
    public function setDeparture(Door $departure = null)
    {
        $this->departure = $departure;
    
        return $this;
    }

    /**
     * Get departure
     *
     * @return Door
     */
    public function getDeparture()
    {
        return $this->departure;
    }

    /**
     * Set destination
     *
     * @param Door $destination
     * @return self
     */
    public function setDestination(Door $destination = null)
    {
        $this->destination = $destination;
    
        return $this;
    }

    /**
     * Get destination
     *
     * @return \JLM\ModelBundle\Entity\Door
     */
    public function getDestination()
    {
        return $this->destination;
    }
    
    /**
     * Get Distance en km
     *
     * @return string
     */
    public function getDistanceKm()
    {
        return number_format($this->distance/1000, 1, ',', ' ').' km';
    }
    
    /**
     * Get Durée en minutes
     *
     * @return string
     */
    public function getDurationM()
    {
        return number_format($this->duration/60, 0).'m';
    }
}

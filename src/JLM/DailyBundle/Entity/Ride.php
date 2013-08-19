<?php

namespace JLM\DailyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JLM\ModelBundle\Entity\Door;

/**
 * Ride
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JLM\DailyBundle\Entity\RideRepository")
 */
class Ride
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Door
     * 
     * @ORM\ManyToOne(targetEntity="JLM\ModelBundle\Entity\Door")
     */
    private $departure;
    
    /**
     * @var Door
     *
     * @ORM\ManyToOne(targetEntity="JLM\ModelBundle\Entity\Door")
     */
    private $destination;
    
    /**
     * Distance en mètre
     * @var int
     *
     * @ORM\Column(name="distance", type="integer")
     */
    private $distance;

    /**
     * Durée de trajet en secondes
     * @var int
     *
     * @ORM\Column(name="duration", type="integer")
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
     * @return Ride
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
     * @return Ride
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
     * @param \JLM\ModelBundle\Entity\Door $departure
     * @return Ride
     */
    public function setDeparture(\JLM\ModelBundle\Entity\Door $departure = null)
    {
        $this->departure = $departure;
    
        return $this;
    }

    /**
     * Get departure
     *
     * @return \JLM\ModelBundle\Entity\Door 
     */
    public function getDeparture()
    {
        return $this->departure;
    }

    /**
     * Set destination
     *
     * @param \JLM\ModelBundle\Entity\Door $destination
     * @return Ride
     */
    public function setDestination(\JLM\ModelBundle\Entity\Door $destination = null)
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
    	return number_format($this->distance/1000,1,',',' ').' km';
    }
    
    /**
     * Get Durée en minutes
     *
     * @return string
     */
    public function getDurationM()
    {
    	return number_format($this->duration/60,0).'m';
    }
}
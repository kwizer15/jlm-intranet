<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * JLM\ModelBundle\Entity\Zip
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Zip
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $number
     *
     * @ORM\Column(name="number", type="string", length=7)
     */
    private $number;

    /**
     * @var City[] $cities
     * 
     * @ORM\ManyToMany(targetEntity="City", mappedBy="zips")
     */
    private $cities;

    /**
     * Constructor
     */
    public function __construct()
    {
    	$this->cities = new ArrayCollection;
    }
    
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
     * Set number
     *
     * @param string $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * Get number
     *
     * @return string 
     */
    public function getNumber()
    {
        return $this->number;
    }
    
    /**
     * To String
     */
    public function __toString()
    {
    	return $this->number;
    }
}
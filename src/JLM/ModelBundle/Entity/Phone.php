<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JLM\ModelBundle\Entity\Phone
 *
 * @ORM\Table(name="phones")
 * @ORM\Entity
 */
class Phone
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
     * @var integer $number
     *
     * @ORM\Column(name="number", type="integer")
     */
    private $number;


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
     * @param integer $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * Get number
     *
     * @return integer 
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
    	return $this->country->getPhonePrefix().$this->number;
    }
}
<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JLM\ModelBundle\Entity\VAT
 *
 * @ORM\Table(name="vat")
 * @ORM\Entity(readOnly=true)
 */
class VAT
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
     * @var int $rate
     *
     * @ORM\Column(name="rate", type="decimal", scale=1)
     */
    private $rate;


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
     * Set name
     *
     * @param int $rate
     */
    public function setRate($rate)
    {
        $this->rate = $rate;
    }

    /**
     * Get rate
     *
     * @return int 
     */
    public function getRate()
    {
        return $this->rate;
    }
    
    /**
     * To String
     * 
     * @return string
     */
    public function __toString()
    {
    	return str_replace('.',',',number_format($this->rate,1)).' %';
    }
}
<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * JLM\ModelBundle\Entity\Contract
 *
 * @ORM\Table(name="contracts")
 * @ORM\Entity
 */
class Contract
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
     * @ORM\Column(name="number", type="string", length=32)
     */
    private $number;

    /**
     * @var ContractType $type
     * 
     * @ORM\ManyToOne(targetEntity="ContractType")
     */
    private $type;
    
    /**
     * @var Trustee $trustee
     * 
     * @ORM\ManyToOne(targetEntity="Trustee", inversedBy="contracts")
     */
    
    /**
     * @var Door $door
     * 
     * @ORM\ManyToOne(targetEntity="Door", inversedBy="contracts")
     */
    private $door;
    
    /**
     * @var datetime $begin
     *
     * @ORM\Column(name="begin", type="datetime")
     */
    private $begin;

    /**
     * @var datetime $endWarranty
     *
     * @ORM\Column(name="endWarranty", type="datetime")
     */
    private $endWarranty;

    /**
     * @var datetime $end
     *
     * @ORM\Column(name="end", type="datetime")
     */
    private $end;

    /**
     * @var decimal $turnover
     *
     * @ORM\Column(name="turnover", type="decimal")
     */
    private $turnover;
    
    /**
     * Constructor
     */
    public function __construct()
    {
    	$this->doors = new ArrayCollection;
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
     * Set begin
     *
     * @param datetime $begin
     */
    public function setBegin($begin)
    {
        $this->begin = $begin;
    }

    /**
     * Get begin
     *
     * @return datetime 
     */
    public function getBegin()
    {
        return $this->begin;
    }

    /**
     * Set endWarranty
     *
     * @param datetime $endWarranty
     */
    public function setEndWarranty($endWarranty)
    {
        $this->endWarranty = $endWarranty;
    }

    /**
     * Get endWarranty
     *
     * @return datetime 
     */
    public function getEndWarranty()
    {
        return $this->endWarranty;
    }

    /**
     * Set end
     *
     * @param datetime $end
     */
    public function setEnd($end)
    {
        $this->end = $end;
    }

    /**
     * Get end
     *
     * @return datetime 
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Set turnover
     *
     * @param decimal $turnover
     */
    public function setTurnover($turnover)
    {
        $this->turnover = $turnover;
    }

    /**
     * Get turnover
     *
     * @return decimal 
     */
    public function getTurnover()
    {
        return $this->turnover;
    }

    /**
     * Set type
     *
     * @param JLM\ModelBundle\Entity\ContractType $type
     */
    public function setType(\JLM\ModelBundle\Entity\ContractType $type)
    {
        $this->type = $type;
    }

    /**
     * Get type
     *
     * @return JLM\ModelBundle\Entity\ContractType 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Add doors
     *
     * @param JLM\ModelBundle\Entity\Door $doors
     */
    public function addDoor(\JLM\ModelBundle\Entity\Door $doors)
    {
        $this->doors[] = $doors;
    }

    /**
     * Get doors
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getDoors()
    {
        return $this->doors;
    }
}
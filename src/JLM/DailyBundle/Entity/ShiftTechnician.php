<?php

namespace JLM\DailyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JLM\DailyBundle\Entity\ShiftTechnician
 *
 * @ORM\Table(name="shift_technician")
 * @ORM\Entity()
 */
class ShiftTechnician
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
     * Date de transmission au technicien
     * @var \DateTime
     *
     * @ORM\Column(name="creation",type="datetime")
     */
    private $creation;
    
    /**
     * Date du début de l'intervention (prévue)
     * @var \DateTime
     * 
     * @ORM\Column(name="begin",type="datetime",nullable=true)
     */
    private $begin;
    
    /**
     * Date de fin de l'intervention (prévue)
     * @var \DateTime
     *
     * @ORM\Column(name="end",type="datetime",nullable=true)
     */
    private $end;
    
    /**
     * @var Shifting $shifting
     * 
     * @ORM\ManyToOne(targetEntity="Shifting", inversedBy="shiftTechnicians")
     */
    private $shifting;
    
    /**
     * @var Technician $technician
     * 
     * @ORM\ManyToOne(targetEntity="JLM\ModelBundle\Entity\Technician")
     */
    private $technician;

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
     * Set creation
     *
     * @param \DateTime $creation
     * @return InterventionScheduled
     */
    public function setCreation($creation)
    {
    	$this->creation = $creation;
    
    	return $this;
    }
    
    /**
     * Get creation
     *
     * @return \DateTime
     */
    public function getCreation()
    {
    	return $this->creation;
    }
    
    /**
     * Set begin
     *
     * @param \DateTime $scheduledBegin
     * @return InterventionScheduled
     */
    public function setBegin($begin)
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
     * @return InterventionScheduled
     */
    public function setEnd($end)
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
     * Set intervention
     *
     * @param JLM\DailyBundle\Entity\InterventionPlanned $intervention
     * @return InterventionScheduled
     */
    public function setShifting(\JLM\DailyBundle\Entity\Shifting $shifting = null)
    {
        $this->shifting = $shifting;
    
        return $this;
    }

    /**
     * Get shifting
     *
     * @return JLM\DailyBundle\Entity\Shifting 
     */
    public function getShifting()
    {
        return $this->shifting;
    }

    /**
     * Set technician
     *
     * @param JLM\ModelBundle\Entity\Technician $technician
     * @return InterventionScheduled
     */
    public function setTechnician(\JLM\ModelBundle\Entity\Technician $technician = null)
    {
        $this->technician = $technician;
    
        return $this;
    }

    /**
     * Get technician
     *
     * @return JLM\ModelBundle\Entity\Technician 
     */
    public function getTechnician()
    {
        return $this->technician;
    }
}
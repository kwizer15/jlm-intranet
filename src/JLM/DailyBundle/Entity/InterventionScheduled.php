<?php

namespace JLM\DailyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JLM\DailyBundle\Entity\ScheduledSurgery
 *
 * @ORM\Table(name="interventions_scheduled")
 * @ORM\Entity(repositoryClass="JLM\DailyBundle\Entity\InterventionScheduledRepository")
 */
class InterventionScheduled
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
     * Date du début de l'intervention (prévue)
     * @var \DateTime
     * 
     * @ORM\Column(name="scheduled_begin",type="datetime")
     */
    private $scheduledBegin;
    
    /**
     * Date de fin de l'intervention (prévue)
     * @var \DateTime
     *
     * @ORM\Column(name="scheduled_end",type="datetime")
     */
    private $scheduledEnd;
    
    /**
     * @var InterventionPlanned $intervention
     * 
     * @ORM\ManyToOne(targetEntity="InterventionPlanned")
     */
    private $intervention;
    
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
     * Set scheduledBegin
     *
     * @param \DateTime $scheduledBegin
     * @return InterventionScheduled
     */
    public function setScheduledBegin($scheduledBegin)
    {
        $this->scheduledBegin = $scheduledBegin;
    
        return $this;
    }

    /**
     * Get scheduledBegin
     *
     * @return \DateTime 
     */
    public function getScheduledBegin()
    {
        return $this->scheduledBegin;
    }

    /**
     * Set scheduledEnd
     *
     * @param \DateTime $scheduledEnd
     * @return InterventionScheduled
     */
    public function setScheduledEnd($scheduledEnd)
    {
        $this->scheduledEnd = $scheduledEnd;
    
        return $this;
    }

    /**
     * Get scheduledEnd
     *
     * @return \DateTime 
     */
    public function getScheduledEnd()
    {
        return $this->scheduledEnd;
    }

    /**
     * Set intervention
     *
     * @param JLM\DailyBundle\Entity\InterventionPlanned $intervention
     * @return InterventionScheduled
     */
    public function setIntervention(\JLM\DailyBundle\Entity\InterventionPlanned $intervention = null)
    {
        $this->intervention = $intervention;
    
        return $this;
    }

    /**
     * Get intervention
     *
     * @return JLM\DailyBundle\Entity\InterventionPlanned 
     */
    public function getIntervention()
    {
        return $this->intervention;
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
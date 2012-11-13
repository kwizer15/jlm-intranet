<?php

namespace JLM\DailyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JLM\DailyBundle\Entity\ScheduledSurgery
 *
 * @ORM\Table(name="intervention_scheduled")
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
     * @var \DateTime
     * 
     * @ORM\Column(name="scheduled_begin",type="datetime")
     */
    private $scheduledBegin;
    
    /**
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
     * @ORM\ManyToOne(targetEntity="Technician")
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
     * @return Event
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
     * Set reason
     *
     * @param string $reason
     * @return Event
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
}

<?php

namespace JLM\DailyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Plannification d'intervention
 * JLM\DailyBundle\Entity\InterventionPlanned
 *
 * @ORM\Table(name="intervention_planned")
 * @ORM\Entity
 */
class InterventionPlanned
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
     * @var \DateTime $creation
     *
     * @ORM\Column(name="creation", type="datetime")
     */
    private $creation;
    
    /**
     * Porte
     * @var JLM\ModelBundle\Entity\Door
     * @ORM\ManyToOne(targetEntity="JLM\ModelBundle\Entity\Door")
     */
    private $door;
    
    /**
     * @var string $contactName
     * @ORM\Column(name="contact_name", type="string")
     */
    private $contactName;
    
    /**
     * @var string $contactPhone
     * @ORM\Column(name="contact_phones", type="text")
     */
    private $contactPhones;
    
    /**
     * E-mail pour envoyer le rapport
     * @var string $contactEmail
     * @ORM\Column(name="contact_email", type="text")
     */
    private $contactEmail;
    
    /**
     * @var string $reason
     *
     * @ORM\Column(name="reason", type="text")
     */
    private $reason;
    
    /**
     * Type d'action (travaux, dépannage, entretien)
     * @var ActionType $actionType
     * 
     * @ORM\ManyToOne(targetEntity="ActionType")
     */
    private $actionType;
    
    /**
     * Priorité
     * @var int $priority
     * 1 - Très Urgent
     * 2 - Urgent
     * ....
     *
     * @ORM\Column(name="priority", type="smallint")
     */
    private $priority;
    

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
     * @return InterventionPlanned
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
     * Set contactName
     *
     * @param string $contactName
     * @return InterventionPlanned
     */
    public function setContactName($contactName)
    {
        $this->contactName = $contactName;
    
        return $this;
    }

    /**
     * Get contactName
     *
     * @return string 
     */
    public function getContactName()
    {
        return $this->contactName;
    }

    /**
     * Set contactPhones
     *
     * @param string $contactPhones
     * @return InterventionPlanned
     */
    public function setContactPhones($contactPhones)
    {
        $this->contactPhones = $contactPhones;
    
        return $this;
    }

    /**
     * Get contactPhones
     *
     * @return string 
     */
    public function getContactPhones()
    {
        return $this->contactPhones;
    }

    /**
     * Set contactEmail
     *
     * @param string $contactEmail
     * @return InterventionPlanned
     */
    public function setContactEmail($contactEmail)
    {
        $this->contactEmail = $contactEmail;
    
        return $this;
    }

    /**
     * Get contactEmail
     *
     * @return string 
     */
    public function getContactEmail()
    {
        return $this->contactEmail;
    }

    /**
     * Set reason
     *
     * @param string $reason
     * @return InterventionPlanned
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
     * Set priority
     *
     * @param integer $priority
     * @return InterventionPlanned
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    
        return $this;
    }

    /**
     * Get priority
     *
     * @return integer 
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Set door
     *
     * @param JLM\DailyBundle\Entity\Door $door
     * @return InterventionPlanned
     */
    public function setDoor(\JLM\DailyBundle\Entity\Door $door = null)
    {
        $this->door = $door;
    
        return $this;
    }

    /**
     * Get door
     *
     * @return JLM\DailyBundle\Entity\Door 
     */
    public function getDoor()
    {
        return $this->door;
    }

    /**
     * Set actionType
     *
     * @param JLM\DailyBundle\Entity\ActionType $actionType
     * @return InterventionPlanned
     */
    public function setActionType(\JLM\DailyBundle\Entity\ActionType $actionType = null)
    {
        $this->actionType = $actionType;
    
        return $this;
    }

    /**
     * Get actionType
     *
     * @return JLM\DailyBundle\Entity\ActionType 
     */
    public function getActionType()
    {
        return $this->actionType;
    }
}
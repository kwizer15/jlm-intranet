<?php

namespace JLM\DailyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Plannification d'intervention
 * JLM\DailyBundle\Entity\InterventionPlanned
 *
 * @ORM\Table(name="shifting_interventions")
 * @ORM\Entity(repositoryClass="JLM\DailyBundle\Entity\InterventionRepository")
 */
abstract class Intervention extends Shifting
{
    /**
     * Porte (lien)
     * @var JLM\ModelBundle\Entity\Door
     * @ORM\ManyToOne(targetEntity="JLM\ModelBundle\Entity\Door")
     */
    private $door;
    
    /**
     * @var string $contactName
     * @ORM\Column(name="contact_name", type="string", nullable=true)
     */
    private $contactName;
    
    /**
     * @var string $contactPhone
     * @ORM\Column(name="contact_phones", type="text", nullable=true)
     */
    private $contactPhones;
    
    /**
     * E-mail pour envoyer le rapport
     * @var string $contactEmail
     * @ORM\Column(name="contact_email", type="text", nullable=true)
     */
    private $contactEmail;
   
    /**
     * Report
     * @var string $report
     * @ORM\Column(name="report",type="text", nullable=true)
     */
    private $report;
    
    /**
     * Commentaires (interne à la société)
     * @var string $comments
     *
     * @ORM\Column(name="comments", type="text", nullable=true)
     */
    private $comments;
    
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
     * Closed
     * @var bool
     * 
     * @ORM\Column(name="close", type="datetime", nullable=true)
     */
    private $close;
    
    /**
     * Action Bureau (facturation)
     * @var JLM\OfficeBundle\Entity\Task
     *
     * @ORM\OneToOne(targetEntity="JLM\OfficeBundle\Entity\Task")
     */
    private $officeAction;
    
    /**
     * Action Bureau (autre)
     * @var JLM\OfficeBundle\Entity\Task
     *
     * @ORM\OneToOne(targetEntity="JLM\OfficeBundle\Entity\Task")
     */
    private $otherAction;
    
    /**
     * Reste a faire
     *
     * @ORM\Column(name="rest",type="text",nullable=true)
     */
    private $rest;
    
    /**
     * Type de contrat
     * @ORM\Column(name="contract",type="string",nullable=true)
     */
    private $contract;
    
    /**
     * Get contract
     * @return string
     */
    public function getContract()
    {
    	return $this->contract;
    }
    
    /**
     * Set contract
     * @param string $contract
     * @return Intervention
     */
    public function setContract($contract)
    {
    	$this->contract = $contract;
    	return $this;
    }
    
    /**
     * Get rest
     * @return string
     */
    public function getRest()
    {
    	return $this->rest;
    }
    
    /**
     * Set rest
     * @return string
     */
    public function setRest($rest)
    {
    	$this->rest = $rest;
    	return $this;
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
     * Set door
     *
     * @param JLM\DailyBundle\Entity\Door $door
     * @return InterventionPlanned
     */
    public function setDoor(\JLM\ModelBundle\Entity\Door $door = null)
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
     * Get contractType
     * 
     * @return bool
     */
    public function isCompleteContract()
    {
    	$contract = $this->getDoor()->getActualContract();
    	if ($contract === null)
    		return false;
    	return $contract->getComplete();
    }

    /**
     * Get report
     *
     * @return string
     */
    public function getReport()
    {
    	return $this->report;
    }
    
    /**
     * Set report
     *
     * @param string $report
     * @return Fixing
     */
    public function setReport($report)
    {
    	$this->report = $report;
    	return $this;
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
     * Set Closed
     * 
     * @param bool $closed
     * @return Intervention
     * @deprecated
     */
    public function setClosed($closed = true)
    {
    	$this->setClose(new \DateTime);
       	return $this;
    }
    
    /**
     * Get closed
     * 
     * @return bool
     * @deprecated
     */
    public function getClosed()
    {
    	if ($this->getClose() === null)
    		return false;
    	return true;
    }
    
    /**
     * Set Close
     *
     * @param DateTime $close
     * @return Intervention
     */
    public function setClose(\DateTime $close = null)
    {
    	if ($close === null)
    		$close = new \DateTime;
    	$this->close = $close;
    	return $this;
    }
    
    /**
     * Get close
     *
     * @return DateTime
     */
    public function getClose()
    {
    	return $this->close;
    }
    
    /**
     * Set comments
     *
     * @param string $comments
     * @return InterventionReport
     */
    public function setComments($comments)
    {
    	$this->comments = $comments;
    
    	return $this;
    }
    
    /**
     * Get comments
     *
     * @return string
     */
    public function getComments()
    {
    	return $this->comments;
    }
    
    /**
     * Get Office Action
     *
     * @return JLM\OfficeBundle\Entity\Task
     */
    public function getOfficeAction()
    {
    	return $this->officeAction;
    }
    
    /**
     * Set OfficeAction
     *
     * @param JLM\OfficeBundle\Entity\Task $officeAction
     * @return Fixing
     */
    public function setOfficeAction(\JLM\OfficeBundle\Entity\Task $task = null)
    {
    	$this->officeAction = $task;
    	return $this;
    }
    
    /**
     * Get Office Action
     *
     * @return JLM\OfficeBundle\Entity\Task
     */
    public function getOtherAction()
    {
    	return $this->otherAction;
    }
    
    /**
     * Set OfficeAction
     *
     * @param JLM\OfficeBundle\Entity\Task $otherAction
     * @return Fixing
     */
    public function setOtherAction(\JLM\OfficeBundle\Entity\Task $task = null)
    {
    	$this->otherAction = $task;
    	return $this;
    }
}
<?php

namespace JLM\DailyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JLM\DailyBundle\Entity\InterventionReport
 *
 * @ORM\Table(name="intervention_reports")
 * @ORM\Entity
 */
class InterventionReport
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
     * @var InterventionPlanned $intervention
     *
     * @ORM\ManyToOne(targetEntity="InterventionPlanned")
     */
    private $intervention;
    
    /**
     * @var Nature $nature
     *
     * @ORM\ManyToOne(targetEntity="Nature")
     */
    private $nature;
    
    /**
     * @var ActionDone $actionDone
     *
     * @ORM\ManyToOne(targetEntity="ActionDone")
     */
    private $actionDone;
    
    /**
     * @var string $report
     *
     * @ORM\Column(name="report", type="text")
     */
    private $report;

    /**
     * Bon d'intervention
     * @var int $orderNumber
     * 
     * @ORM\Column(name="order_number",type="integer")
     */
    private $orderNumber;
    
    /**
     * Commentaires (interne à la société)
     * @var string $comments
     *
     * @ORM\Column(name="comments", type="text")
     */
    private $comments;

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
     * @return InterventionReport
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
     * Set report
     *
     * @param string $report
     * @return InterventionReport
     */
    public function setReport($report)
    {
        $this->report = $report;
    
        return $this;
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
     * Set orderNumber
     *
     * @param integer $orderNumber
     * @return InterventionReport
     */
    public function setOrderNumber($orderNumber)
    {
        $this->orderNumber = $orderNumber;
    
        return $this;
    }

    /**
     * Get orderNumber
     *
     * @return integer 
     */
    public function getOrderNumber()
    {
        return $this->orderNumber;
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
     * Set intervention
     *
     * @param JLM\DailyBundle\Entity\InterventionPlanned $intervention
     * @return InterventionReport
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
     * Set nature
     *
     * @param JLM\DailyBundle\Entity\Nature $nature
     * @return InterventionReport
     */
    public function setNature(\JLM\DailyBundle\Entity\Nature $nature = null)
    {
        $this->nature = $nature;
    
        return $this;
    }

    /**
     * Get nature
     *
     * @return JLM\DailyBundle\Entity\Nature 
     */
    public function getNature()
    {
        return $this->nature;
    }

    /**
     * Set actionDone
     *
     * @param JLM\DailyBundle\Entity\ActionDone $actionDone
     * @return InterventionReport
     */
    public function setActionDone(\JLM\DailyBundle\Entity\ActionDone $actionDone = null)
    {
        $this->actionDone = $actionDone;
    
        return $this;
    }

    /**
     * Get actionDone
     *
     * @return JLM\DailyBundle\Entity\ActionDone 
     */
    public function getActionDone()
    {
        return $this->actionDone;
    }
}
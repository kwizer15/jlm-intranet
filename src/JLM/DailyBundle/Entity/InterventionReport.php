<?php

namespace JLM\DailyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JLM\DailyBundle\Entity\InterventionReport
 *
 * @ORM\Table()
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
     * @ORM\Column(name="order_number",type="int")
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
}

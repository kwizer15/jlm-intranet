<?php

namespace JLM\DailyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * JLM\DailyBundle\Entity\ShiftTechnician
 *
 * @ORM\Table(name="shift_technician")
 * @ORM\Entity(repositoryClass="JLM\DailyBundle\Entity\ShiftTechnicianRepository")
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
     * @Assert\DateTime
     * Assert\NotNull(message="Date de création n'existe pas")
     * @todo Corriger
     */
    private $creation;
    
    /**
     * Date du début de l'intervention (prévue)
     * @var \DateTime
     * 
     * @ORM\Column(name="begin",type="datetime")
     * @Assert\DateTime
     * @Assert\NotNull(message="Date de début n'existe pas")
     */
    private $begin;
    
    /**
     * Date de fin de l'intervention (prévue)
     * @var \DateTime
     *
     * @ORM\Column(name="end",type="datetime",nullable=true)
     * @Assert\DateTime
     */
    private $end;
    
    /**
     * @var Shifting $shifting
     * 
     * @ORM\ManyToOne(targetEntity="Shifting", inversedBy="shiftTechnicians")
     * @Assert\Valid
     * Assert\NotNull(message="Déplacement n'existe pas")
     * @todo Corriger
     */
    private $shifting;
    
    /**
     * @var Technician $technician
     * 
     * @ORM\ManyToOne(targetEntity="JLM\ModelBundle\Entity\Technician")
     * @Assert\Valid
     * @Assert\NotNull
     */
    private $technician;

    /**
     * Commentaire
     * 
     * @ORM\Column(name="comment",type="text",nullable=true)
     * @Assert\Type(type="string")
     */
    private $comment;
    
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
    public function setEnd($end = null)
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
     * Temps d'intervention
     * @return DateInterval Nombre de minutes
     */
    public function getTime()
    {
    	if ($this->end === null)
    		return null;
    	return $this->end->diff($this->begin);
    	
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
    
    /**
     * Get comment
     * 
     * @return string
     */
    public function getComment()
    {
    	return $this->comment;
    }
    
    /**
     * Set comment
     * 
     * @param string $comment
     * @return ShiftTechnician
     */
    public function setComment($comment)
    {
    	$this->comment = $comment;
    	return $this;
    }
}
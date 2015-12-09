<?php

/*
 * This file is part of the JLMDailyBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\DailyBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use JLM\ModelBundle\Entity\Technician;

/**
 * JLM\DailyBundle\Entity\ShiftTechnician
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class ShiftTechnician
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * Date de transmission au technicien
     * @var \DateTime
     * @Assert\DateTime
     * @Assert\NotNull(message="Date de création n'existe pas")
     */
    private $creation;
    
    /**
     * Date du début de l'intervention (prévue)
     * @var \DateTime
     * @Assert\DateTime
     * @Assert\NotNull(message="Date de début n'existe pas")
     */
    private $begin;
    
    /**
     * Date de fin de l'intervention (prévue)
     * @var \DateTime
     * @Assert\DateTime
     */
    private $end;
    
    /**
     * @var Shifting $shifting
     * @Assert\NotNull(message="Déplacement n'existe pas")
     */
    private $shifting;
    
    /**
     * @var Technician $technician
     * @Assert\Valid
     * @Assert\NotNull
     */
    private $technician;

    /**
     * Commentaire
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
     * @return self
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
     * @return self
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
     * @return self
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
    	return ($this->end === null) ? null : $this->end->diff($this->begin);
    	
    }

    /**
     * Set intervention
     *
     * @param Shifting $intervention
     * @return self
     */
    public function setShifting(Shifting $shifting = null)
    {
        $this->shifting = $shifting;
    
        return $this;
    }

    /**
     * Get shifting
     *
     * @return Shifting 
     */
    public function getShifting()
    {
        return $this->shifting;
    }

    /**
     * Set technician
     *
     * @param Technician $technician
     * @return self
     */
    public function setTechnician(Technician $technician = null)
    {
        $this->technician = $technician;
    
        return $this;
    }

    /**
     * Get technician
     *
     * @return Technician 
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
     * @return self
     */
    public function setComment($comment)
    {
    	$this->comment = $comment;
    	
    	return $this;
    }
    
    /**
     * Time validation
     * 
     * @return bool
     */
    public function isTimeValid()
    {
    	return $this->end === null || $this->end > $this->begin;
    }
}
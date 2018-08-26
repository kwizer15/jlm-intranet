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

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Déplacement
 * JLM\DailyBundle\Entity\Shifting
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
abstract class Shifting
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var \DateTime $creation
     * @Assert\DateTime
     * @Assert\NotNull(message="Pas de date de création du déplacement")
     */
    private $creation;
    
    /**
     * Lieu du déplacement
     * @var string
     * @Assert\Type(type="string")
     * @Assert\NotBlank(message="Pas de lieu pour le déplacement")
     */
    private $place;
    
    /**
     * @var string $reason
     * @Assert\Type(type="string")
     * @Assert\NotBlank(message="Pas de raison pour le déplacement")
     */
    private $reason;
    
    /**
     * @var ArrayCollection $shiftTechnicians
     */
    private $shiftTechnicians;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->shiftTechnicians = new ArrayCollection;
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
     * Set place
     *
     * @param string $place
     * @return Shifting
     */
    public function setPlace($place)
    {
        $this->place = $place;
    
        return $this;
    }

    /**
     * Get place
     *
     * @return string
     */
    public function getPlace()
    {
        return $this->place;
    }
    
    /**
     * Add shiftTechnicians
     *
     * @param JLM\DailyBundle\Entity\ShiftTechnician $shiftTechnicians
     * @return bool
     */
    public function addShiftTechnician(ShiftTechnician $shiftTechnicians)
    {
        return $this->shiftTechnicians->add($shiftTechnicians);
    }
    
    /**
     * Remove shiftTechnicians
     *
     * @param ShiftTechnician $shiftTechnicians
     * @return bool
     */
    public function removeShiftTechnician(ShiftTechnician $shiftTechnicians)
    {
        return $this->shiftTechnicians->removeElement($shiftTechnicians);
    }
    
    /**
     * Get shiftTechnicians
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getShiftTechnicians()
    {
        return $this->shiftTechnicians;
    }
    
    /**
     * Get getTotalTime
     *
     * @return string
     */
    public function getTotalTime()
    {
        $hours = 0;
        $minutes = 0;
        $shifts = $this->getShiftTechnicians();
        foreach ($shifts as $shift) {
            if ($shift->getTime()) {
                $hours += (int)$shift->getTime()->format('%h');
                $minutes += (int)$shift->getTime()->format('%i');
            }
        }
        $min = $minutes % 60;
        $minutes -= $min;
        $hours += $minutes / 60;
        
        return new \DateInterval('PT'.$hours.'H'.$min.'M');
    }
    
    /**
     * getFirstDate
     * @return \DateTime
     */
    public function getFirstDate()
    {
        $firstDate = null;
        $shifts = $this->getShiftTechnicians();
        foreach ($shifts as $shift) {
            $firstDate = ($firstDate === null || $firstDate > $shift->getBegin()) ? $shift->getBegin() : $firstDate;
        }
        
        return $firstDate;
    }
    
    /**
     * getLastDate
     * @return \DateTime
     */
    public function getLastDate()
    {
        $lastDate = null;
        $shifts = $this->getShiftTechnicians();
        foreach ($shifts as $shift) {
            $lastDate = ($lastDate === null || $lastDate < $shift->getBegin()) ? $shift->getBegin() : $lastDate;
        }
        
        return $lastDate;
    }
    
    /**
     * Est en cours
     */
    public function isInProgress()
    {
        return (sizeof($this->shiftTechnicians) > 0);
    }
     
    /**
     * Get type
     *
     * @return string
     */
    abstract public function getType();
}

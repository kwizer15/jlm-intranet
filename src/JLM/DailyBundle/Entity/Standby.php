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
 * Astreintes techniciens
 * JLM\DailyBundle\Entity\Stanby
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class Standby
{
	/**
	 * Id
	 * @var int $id
	 */
	private $id;
	
	/**
	 * @var \DateTime $begin
	 * @Assert\Date
	 * @Assert\NotNull
	 */
	private $begin;
	
	/**
	 * @var \DateTime $end
	 * @Assert\Date
	 * @Assert\NotNull
	 */
	private $end;
	
	/**
	 * @var Technician $technician
	 * @Assert\Valid
	 * @Assert\NotNull
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
     * Set begin
     *
     * @param \DateTime $begin
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
     * Set technician
     *
     * @param \JLM\ModelBundle\Entity\Technician $technician
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
     * @return \JLM\ModelBundle\Entity\Technician 
     */
    public function getTechnician()
    {
        return $this->technician;
    }
}
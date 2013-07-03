<?php
namespace JLM\DailyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Astreintes techniciens
 * JLM\DailyBundle\Entity\Stanby
 *
 * @ORM\Table(name="technician_standby")
 * @ORM\Entity
 */
class Standby
{
	/**
	 * Id
	 * @var int $id
	 * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;
	
	/**
	 * @var \DateTime $begin
	 *
	 * @ORM\Column(name="begin", type="date")
	 * @Assert\Date
	 * @Assert\NotNull
	 */
	private $begin;
	
	/**
	 * @var \DateTime $end
	 *
	 * @ORM\Column(name="end", type="date")
	 * @Assert\Date
	 * @Assert\NotNull
	 */
	private $end;
	
	/**
	 * @var Technician $technician
	 *
	 * @ORM\ManyToOne(targetEntity="JLM\ModelBundle\Entity\Technician")
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
     * @return Standby
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
     * @return Standby
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
     * @return Standby
     */
    public function setTechnician(\JLM\ModelBundle\Entity\Technician $technician = null)
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
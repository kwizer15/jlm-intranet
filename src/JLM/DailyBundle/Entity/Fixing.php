<?php
namespace JLM\DailyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Plannification d'une panne
 * JLM\DailyBundle\Entity\Fixing
 *
 * @ORM\Table(name="shifting_fixing")
 * @ORM\Entity(repositoryClass="JLM\DailyBundle\Entity\InterventionRepository")
 */
class Fixing extends Intervention
{
	
	
	/**
	 * Cause du dépannage
	 * @var FixingDue $due;
	 * @ORM\ManyToOne(targetEntity="FixingDue")
	 * @Assert\Valid
	 */
	private $due;
	
	/**
	 * Action
	 * @var FixingDone $done;
	 * @ORM\ManyToOne(targetEntity="FixingDone")
	 * @Assert\Valid
	 */
	private $done;
	
	/**
	 * Get Type
	 * @see Shifting
	 * @return string
	 */
	public function getType()
	{
		return 'fixing';
	}
	
	/**
	 * Get due
	 * 
	 * @return FixingDue
	 */
	public function getDue()
	{
		return $this->due;
	}
	
	/**
	 * Set due
	 * 
	 * @param FixingDue $due
	 * @return Fixing
	 */
	public function setDue(FixingDue $due = null)
	{
		$this->due = $due;
		return $this;
	}
	
	/**
	 * Get done
	 *
	 * @return FixingDone
	 */
	public function getDone()
	{
		return $this->done;
	}
	
	/**
	 * Set done
	 *
	 * @param FixingDone $done
	 * @return Fixing
	 */
	public function setDone(FixingDone $done = null)
	{
		$this->done = $done;
		return $this;
	}
}
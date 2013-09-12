<?php
namespace JLM\DailyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JLM\OfficeBundle\Entity\AskMethod;

/**
 * Plannification d'une panne
 * JLM\DailyBundle\Entity\Fixing
 *
 * @ORM\Table(name="shifting_fixing")
 * @ORM\Entity(repositoryClass="JLM\DailyBundle\Entity\FixingRepository")
 */
class Fixing extends Intervention
{
	/**
	 * Date de la demande
	 * @ORM\Column(name="ask_date", type="datetime", nullable=true)
	 * @Assert\DateTime
	 */
	private $askDate;
	
	/**
	 * Méthode de la demande
	 * @ORM\ManyToOne(targetEntity="JLM\OfficeBundle\Entity\AskMethod")
	 */
	private $askMethod;
	
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
	 * Get askDate
	 * 
	 * @return \DateTime
	 */
	public function getAskDate()
	{
		return $this->askDate;
	}
	
	/**
	 * Set askDate
	 * 
	 * @param \DateTime $date
	 * @return Fixing
	 */
	public function setAskDate(\DateTime $date = null)
	{
		$this->askDate = $date;
		return $this;
	}
	
	/**
	 * Get askMethod
	 *
	 * @return AskMethod
	 */
	public function getAskMethod()
	{
		return $this->askMethod;
	}
	
	/**
	 * Set askMethod
	 *
	 * @param AskMethod $method
	 * @return Fixng
	 */
	public function setAskMethod(AskMethod $method = null)
	{
		$this->askMethod = $method;
		return $this;
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
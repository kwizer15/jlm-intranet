<?php
namespace JLM\DailyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Plannification d'une panne
 * JLM\DailyBundle\Entity\Fixing
 *
 * @ORM\Table(name="shifting_fixing")
 * @ORM\Entity
 */
class Fixing extends Intervention
{
	
	
	/**
	 * Cause du dépannage
	 * @var FixingDue $due;
	 * @ORM\ManyToOne(targetEntity="FixingDue")
	 */
	private $due;
	
	/**
	 * Action
	 * @var FixingDone $done;
	 * @ORM\ManyToOne(targetEntity="FixingDone")
	 */
	private $done;
	
	/**
	 * Bon d'intervention
	 * @var int $orderNumber
	 *
	 * @ORM\Column(name="order_number",type="integer",nullable=true)
	 */
	private $orderNumber;
	
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
	 * Get Type
	 * @see Shifting
	 * @return string
	 */
	public function getType()
	{
		return 'Dépannage';
	}
}
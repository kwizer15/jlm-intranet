<?php
namespace JLM\StateBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JLM\OfficeBundle\Entity\Ask
 *
 * @ORM\Table(name="calendar")
 * @ORM\Entity
 */
class Calendar
{
	/**
	 * Date
	 * @var unknown
	 * @ORM\Id
	 * @ORM\Column(name="dt",type="datetime")
	 */
	private $dt;
	
	/**
	 * Get date
	 * @return \DateTime
	 */
	public function getDt()
	{
		return $this->dt;
	}
	
	/**
	 * Set date
	 * @param \DateTime $dt
	 * @return Calendar
	 */
	public function setDt(\DateTime $dt)
	{
		$this->dt = $dt;
		return $this;
	}
	
	/**
	 * Get Date
	 * @return \DateTime
	 */
	public function getDate()
	{
		return $this->getDt();
	}
	
	/**
	 * Set Date
	 * @param \DateTime $dt
	 * @return Calendar
	 */
	public function setDate(\DateTime $dt)
	{
		return $this->setDt($dt);
	}
}
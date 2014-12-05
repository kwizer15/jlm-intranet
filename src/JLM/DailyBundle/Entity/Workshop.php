<?php
namespace JLM\DailyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JLM\DailyBundle\Model\WorkInterface;

/**
 * Plannification d'intervention
 * JLM\DailyBundle\Entity\Equipment
 *
 * @ORM\Table(name="shifting_equipments")
 * @ORM\Entity(repositoryClass="JLM\DailyBundle\Entity\EquipmentRepository")
 */
class Workshop extends Shifting
{
	private $work;
	
	/**
	 * Get Type
	 * @see Shifting
	 * @return string
	 */
	public function getType()
	{
		return 'workshop';
	}
	
	public function getWork()
	{
		return $this->work;
	}
	
	public function setWork(WorkInterface $work)
	{
		$this->work = $work;
		
		return $this;
	}
}
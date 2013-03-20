<?php
namespace JLM\DailyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Plannification d'intervention
 * JLM\DailyBundle\Entity\Equipment
 *
 * @ORM\Table(name="shifting_equipments")
 * @ORM\Entity(repositoryClass="JLM\DailyBundle\Entity\EquipmentRepository")
 */
class Equipment extends Shifting
{
	/**
	 * Get Type
	 * @see Shifting
	 * @return string
	 */
	public function getType()
	{
		return 'equipment';
	}
}
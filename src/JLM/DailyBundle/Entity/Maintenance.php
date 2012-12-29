<?php
namespace JLM\DailyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Plannification d'un entretien
 * JLM\DailyBundle\Entity\Maintenance
 *
 * @ORM\Table(name="shifting_maintenance")
 * @ORM\Entity
 */
class Maintenance extends Intervention
{
	/**
	 * Get Type
	 * @see Shifting
	 * @return string
	 */
	public function getType()
	{
		return 'maintenance';
	}
}
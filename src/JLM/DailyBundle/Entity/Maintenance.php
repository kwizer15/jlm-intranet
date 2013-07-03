<?php
namespace JLM\DailyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Plannification d'un entretien
 * JLM\DailyBundle\Entity\Maintenance
 *
 * @ORM\Table(name="shifting_maintenance")
 * @ORM\Entity(repositoryClass="JLM\DailyBundle\Entity\MaintenanceRepository")
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
	
	/**
	 * Un entretien ne sera jamais facturé
	 * @Assert\False
	 *
	public function isBilled()
	{
		return $this->mustBeBilled;
	}
	*/
	
}
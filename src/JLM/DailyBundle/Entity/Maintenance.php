<?php
namespace JLM\DailyBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Plannification d'un entretien
 * JLM\DailyBundle\Entity\Maintenance
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
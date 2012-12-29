<?php
namespace JLM\DailyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Plannification d'un entretien
 * JLM\DailyBundle\Entity\Receiver
 *
 * @ORM\Table(name="shifting_receiver")
 * @ORM\Entity
 */
class Receiver extends Intervention
{
	/**
	 * Get Type
	 * @see Shifting
	 * @return string
	 */
	public function getType()
	{
		return 'receiver';
	}
}
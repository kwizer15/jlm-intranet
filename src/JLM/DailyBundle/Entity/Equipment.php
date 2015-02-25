<?php
namespace JLM\DailyBundle\Entity;

/**
 * Plannification d'intervention
 * JLM\DailyBundle\Entity\Equipment
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
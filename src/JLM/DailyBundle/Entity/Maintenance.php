<?php

/*
 * This file is part of the JLMDailyBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\DailyBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use JLM\DailyBundle\Model\MaintenanceInterface;

/**
 * Plannification d'un entretien
 * JLM\DailyBundle\Entity\Maintenance
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class Maintenance extends Intervention implements MaintenanceInterface
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
	
	public function getCustomerDesignation()
	{
		return 'Entretien';
		
	}
	
}
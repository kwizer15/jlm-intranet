<?php

/*
 * This file is part of the JLMFollowBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\FollowBundle\Entity;

use JLM\DailyBundle\Model\InterventionInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class StarterIntervention extends Starter
{
	/**
	 * @var InterventionInterface
	 */
	private $intervention;
	
	/**
	 * @param InterventionInterface $intervention
	 * @return self
	 */
	public function setIntervention(InterventionInterface $intervention)
	{
		$this->intervention = $intervention;
		
		return $this;
	}
	
	/**
	 * @return InterventionInterface
	 */
	public function getIntervention()
	{
		return $this->intervention;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getName()
	{
		return 'Intervention du '.$this->getStartDate()->format('d/m/Y');
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getBusiness()
	{
		return $this->getIntervention()->getDoor();
	}
	
	public function getAmount()
	{
		return 'Complet';
	}
}
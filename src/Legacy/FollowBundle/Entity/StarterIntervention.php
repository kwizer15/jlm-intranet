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
	
	public function __construct(InterventionInterface $intervention)
	{
		$this->setIntervention($intervention);
	}
	
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
	
	protected function _getWork()
	{
		return $this->getIntervention()->getWork();
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getName()
	{
		return 'Intervention du '.$this->getIntervention()->getLastDate()->format('d/m/Y');
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
	
	/**
	 * {@inheritdoc}
	 */
	public function getType()
	{
		return 'intervention';
	}
}
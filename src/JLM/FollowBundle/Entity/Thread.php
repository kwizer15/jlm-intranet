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

use JLM\FollowBundle\Model\ThreadInterface;
use JLM\CommerceBundle\Model\OrderInterface;
use JLM\DailyBundle\Model\WorkInterface;
use JLM\FollowBundle\Model\StarterInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class Thread implements ThreadInterface
{
	/**
	 * @var int
	 */
	private $id;
	
	/**
	 * @var StarterInterface
	 */
	private $starter;
	
	/**
	 * @var OrderInterface
	 */
	private $order;
	
	/**
	 * @var WorkerInterface
	 */
	private $work;
	
	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}
	
	/**
	 * @param StarterInterface $starter
	 * @return self
	 */
	public function setStarter(StarterInterface $starter)
	{
		$this->starter = $starter;
		
		return $this;
	}
	
	/**
	 * @return StarterInterface
	 */
	public function getStarter()
	{
		return $this->starter;
	}
	
	/**
	 * @param OrderInterface $order
	 * @return self
	 */
	public function setOrder(OrderInterface $order)
	{
		$this->order = $order;
		
		return $this;
	}
	
	/**
	 * @return OrderInterface
	 */
	public function getOrder()
	{
		return $this->order;
	}
	
	/**
	 * @param WorkInterface $work
	 * @return self
	 */
	public function setWork(WorkInterface $work)
	{
		$this->work = $work;
		
		return $this;
	}
	
	/**
	 * @return WorkInterface
	 */
	public function getWork()
	{
		return $this->work;
	}
}
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
use JLM\FollowBundle\Model\StarterInterface;
use JLM\CommerceBundle\Model\OrderInterface;
use JLM\DailyBundle\Model\WorkInterface;
use JLM\OfficeBundle\Entity\Order;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class Thread implements ThreadInterface
{
	const STATE_WAIT = 0;
	const STATE_READY = 1;
	const STATE_INPROGRESS = 2;
	const STATE_OK = 3;
	const STATE_CLOSED = 4;
	
	/**
	 * @var int
	 */
	private $id;
	
	/**
	 * @var \DateTime
	 */
	private $startDate;
	
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
	
	public function __construct(StarterInterface $starter)
	{
		$this->setStarter($starter);
	}
	
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
	 * @return OrderInterface
	 */
	public function getOrder()
	{
		return $this->getWork()->getOrder();
	}
	
	/**
	 * @return WorkInterface
	 */
	public function getWork()
	{
		return $this->getStarter()->getWork();
	}
	
	/**
	 * @param \DateTime $date
	 * @return self
	 */
	public function setStartDate(\DateTime $date = null)
	{
		$this->startDate = ($date === null) ? new \DateTime : $date;
		
		return $this;
	}
	
	/**
	 * @return \DateTime
	 */
	public function getStartDate()
	{
		return $this->startDate;
	}
	
	public function getAmount()
	{
		return $this->getStarter()->getAmount();
	}
	
	public function getState()
	{
		if ($this->getWork()->getBill() !== null || $this->getWork()->getExternalBill() !== null)
		{
			return self::STATE_CLOSED;
		}
		if ($this->getWork()->getClose() !== null)
		{
			return self::STATE_OK;
		}
		if ($this->getWork()->getFirstDate() !== null)
		{
			return self::STATE_INPROGRESS;
		}
		if (!$this->getOrder() instanceof Order || $this->getOrder()->getState() < 2)
		{
			return self::STATE_WAIT;
		}
		if ($this->getOrder()->getState() >= 2)
		{
			return self::STATE_READY;
		}
		
	}
}
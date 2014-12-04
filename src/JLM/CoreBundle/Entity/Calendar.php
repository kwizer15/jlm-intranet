<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CoreBundle\Entity;

use JLM\CoreBundle\Model\CalendarInterface;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class Calendar implements CalendarInterface
{
	/**
	 * @var \DateTime
	 */
	private $dt;
	
	/**
	 * 
	 * @return DateTime
	 */
	public function getDt()
	{
		return $this->getDate();
	}
	
	/**
	 * 
	 * @param \DateTime $date
	 * @return self
	 */
	public function setDt(\DateTime $date)
	{
		return $this->setDate($date);
	}
	
	/**
	 *
	 * @return DateTime
	 */
	public function getDate()
	{
		return $this->dt;
	}
	
	/**
	 *
	 * @param \DateTime $date
	 * @return self
	 */
	public function setDate(\DateTime $date)
	{
		$this->dt = $date;
		
		return $this;
	}
}
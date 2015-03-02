<?php

/*
 * This file is part of the JLMCommerceBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CommerceBundle\Entity;

use JLM\CommerceBundle\Model\EventInterface;
use Doctrine\Common\Collections\ArrayCollection;
use JLM\CommerceBundle\Model\EventFollowerInterface;

class EventFollower implements EventFollowerInterface
{	
	private $id;
	
	private $events;
	
	public function __construct()
	{
		$this->events = new ArrayCollection();
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getEvents()
	{
		return $this->events;
	}
	
	public function addEvent(EventInterface $event)
	{
		return $this->events->add($event);
	}
	
	public function removeEvent(EventInterface $event)
	{
		return $this->events->removeElement($event);
	}

}
<?php
namespace JLM\CommerceBundle\Entity;

abstract class EventFollower
{	
	private $events;
	
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
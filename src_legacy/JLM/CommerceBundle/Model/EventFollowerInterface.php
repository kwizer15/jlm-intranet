<?php
namespace JLM\CommerceBundle\Model;

interface EventFollowerInterface
{
   
    /**
     * @return array
     */
    public function getEvents();
    
    /**
     * @return bool
     */
    public function addEvent(EventInterface $event);
    
    /**
     * @return bool
     */
    public function removeEvent(EventInterface $event);
}

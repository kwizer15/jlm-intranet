<?php
namespace JLM\CoreBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class FormEntitySubscriber implements EventSubscriberInterface
{	
	private $om;
	
	public function __construct(ObjectManager $om)
	{
		$this->om = $om;
	}
	
	public static function getSubscribedEvents()
	{
		return array(
			FormEvents::POST_SUBMIT => 'onPostSubmit'
		);
	}
	
	public function onPostSubmit(FormEvent $event)
	{
		//var_dump($event->getData()); exit;
		$bill = $event->getData();
		$this->om->persist($bill);
		$this->om->flush();
	}
}
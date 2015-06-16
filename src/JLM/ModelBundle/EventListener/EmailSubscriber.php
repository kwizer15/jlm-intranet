<?php
namespace JLM\ModelBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use JLM\CommerceBundle\JLMCommerceEvents;
use JLM\CommerceBundle\Factory\BillFactory;
use Doctrine\Common\Persistence\ObjectManager;
use JLM\ModelBundle\Builder\DoorBillBuilder;
use JLM\CoreBundle\Event\FormPopulatingEvent;
use JLM\ModelBundle\JLMModelEvents;
use JLM\ModelBundle\Event\DoorEvent;

class EmailSubscriber implements EventSubscriberInterface
{	
	private $om;
	
	public function __construct(ObjectManager $om)
	{
		$this->om = $om;
	}
	
	public static function getSubscribedEvents()
	{
		return array(
			JLMModelEvents::DOOR_SENDMAIL => 'persistEmailsOnDoor',
		);
	}
	
	public function persistEmailsOnDoor(DoorEvent $event)
	{
		$door = $event->getDoor();
		$mail = $event->getParam('jlm_core_mail');
		$to = (isset($mail['to'])) ? $mail['to'] : array();
		$cc = (isset($mail['cc'])) ? $mail['cc'] : array();
		$door->setManagerEmails($to);
		$door->setAdministratorEmails($cc);
		$this->om->persist($door);
		$this->om->flush();
	}
}
<?php
namespace JLM\DailyBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use JLM\CommerceBundle\Event\BillEvent;
use JLM\CommerceBundle\JLMCommerceEvents;
use Doctrine\Common\Persistence\ObjectManager;

class BillSubscriber implements EventSubscriberInterface
{	
	private $om;
	private $form;
	
	public function __construct(ObjectManager $om)
	{
		$this->om = $om;
	}
	
	public static function getSubscribedEvents()
	{
		return array(
				JLMCommerceEvents::BILL_FORM_POPULATE => 'populateFromIntervention'
		);
	}
	
	public function populateFromIntervention(BillEvent $event)
	{
		$this->form = $event->getForm();
//		$this->populate('property', 'Ah ah ah ah');
	}

	private function populate($key, $value)
	{
		$this->form->get($key)->setData($value);
		
		return $this;
	}
}
<?php
namespace JLM\CommerceBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use JLM\CommerceBundle\JLMCommerceEvents;
use JLM\CommerceBundle\Factory\BillFactory;
use Doctrine\Common\Persistence\ObjectManager;
use JLM\CommerceBundle\Builder\VariantBillBuilder;
use JLM\CoreBundle\Event\FormPopulatingEvent;
use JLM\CoreBundle\Event\DoctrineEvent;
use JLM\CommerceBundle\Entity\Event;
use JLM\CommerceBundle\Event\QuoteEvent;
use JLM\CommerceBundle\Entity\Quote;

class EventSubscriber implements EventSubscriberInterface
{	
	public static function getSubscribedEvents()
	{
		return array(
			JLMCommerceEvents::QUOTE_PREPERSIST => 'createQuoteCreationEvent',
			JLMCommerceEvents::QUOTE_PREUPDATE => 'createQuoteModifiedEvent',
			JLMCommerceEvents::QUOTEVARIANT_PREPERSIST => 'createQuoteVariantCreationEvent',
		);
	}
	
	public function createQuoteCreationEvent(DoctrineEvent $event)
	{
		$event->getEntity()->addEvent(Quote::EVENT_CREATION, array());
	}
	
	public function createQuoteModifiedEvent(DoctrineEvent $event)
	{
		$event->getEntity()->addEvent(Quote::EVENT_MODIFIED, array());
	}
	
	public function createQuoteVariantCreationEvent(DoctrineEvent $event)
	{
		$event->getEntity()->getQuote()->addEvent(Quote::EVENT_CREATION, array('number'=>'Création variante n°'.$event->getEntity()->getNumber()));
	}
}
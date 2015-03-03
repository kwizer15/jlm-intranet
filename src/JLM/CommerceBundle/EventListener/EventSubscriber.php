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
use JLM\CommerceBundle\Event\QuoteVariantEvent;

class EventSubscriber implements EventSubscriberInterface
{	
	public static function getSubscribedEvents()
	{
		return array(
			JLMCommerceEvents::QUOTE_PREPERSIST => 'createQuoteCreationEvent',
			JLMCommerceEvents::QUOTE_PREUPDATE => 'createQuoteModifiedEvent',   // fonctionne pas
			JLMCommerceEvents::QUOTEVARIANT_PREPERSIST => 'createQuoteVariantCreationEvent',
			JLMCommerceEvents::QUOTEVARIANT_INSEIZURE => 'createQuoteVariantInSeizureEvent',
			JLMCommerceEvents::QUOTEVARIANT_READY => 'createQuoteVariantReadyEvent',
			JLMCommerceEvents::QUOTEVARIANT_SENDED => 'createQuoteVariantSendedEvent',
			JLMCommerceEvents::QUOTEVARIANT_GIVEN => 'createQuoteVariantGivenEvent',
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
		$event->getEntity()->getQuote()->addEvent(Quote::EVENT_CREATION, array('variant'=>$event->getEntity()->getNumber()));
	}
	
	public function createQuoteVariantGivenEvent(QuoteVariantEvent $event)
	{
		$event->getQuoteVariant()->getQuote()->addEvent(Quote::EVENT_GIVEN, array('variant'=>$event->getQuoteVariant()->getNumber()));
	}
	
	public function createQuoteVariantSendedEvent(QuoteVariantEvent $event)
	{
		$event->getQuoteVariant()->getQuote()->addEvent(Quote::EVENT_SEND, array('variant'=>$event->getQuoteVariant()->getNumber()));
	}
	
	public function createQuoteVariantReadyEvent(QuoteVariantEvent $event)
	{
		$event->getQuoteVariant()->getQuote()->addEvent(Quote::EVENT_READY, array('variant'=>$event->getQuoteVariant()->getNumber()));
	}
	
	public function createQuoteVariantInSeizureEvent(QuoteVariantEvent $event)
	{
		$event->getQuoteVariant()->getQuote()->addEvent(Quote::EVENT_RETURNINSEIZURE, array('variant'=>$event->getQuoteVariant()->getNumber()));
	}
	
	public function createQuoteVariantReceiptEvent(QuoteVariantEvent $event)
	{
		$event->getQuoteVariant()->getQuote()->addEvent(Quote::EVENT_RECEIPT, array('variant'=>$event->getQuoteVariant()->getNumber()));
	}
}
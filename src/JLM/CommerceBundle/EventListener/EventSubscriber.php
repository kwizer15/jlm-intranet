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
use JLM\CommerceBundle\Entity\QuoteVariant;

class EventSubscriber implements EventSubscriberInterface
{	
	private $om;
	
	public function __construct(ObjectManager $om)
	{
		$this->om = $om;
	}
	
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
	
	private function _addDoctrineEvent(DoctrineEvent $event, $name, $options = array())
	{
		$entity = $event->getEntity();
		$entity->addEvent($name, $options);
		$this->_persist($entity);
	}
	
	private function _addQuoteVariantEvent(QuoteVariantEvent $event, $name)
	{
		$variant = $event->getQuoteVariant();
		$variant->getQuote()->addEvent($name, array('variant'=>$variant->getNumber()));
		$this->_persist($variant);
	}
	
	private function _persist(QuoteVariant $variant)
	{
		$this->om->persist($variant);
		$this->om->flush();
	}
	
	public function createQuoteCreationEvent(DoctrineEvent $event)
	{
		$this->_addDoctrineEvent($event, Quote::EVENT_CREATION);
	}
	
	public function createQuoteModifiedEvent(DoctrineEvent $event)
	{
		$this->_addDoctrineEvent($event, Quote::EVENT_MODIFIED);
	}
	
	public function createQuoteVariantCreationEvent(DoctrineEvent $event)
	{
		$this->_addDoctrineEvent($event, Quote::EVENT_CREATION, array('variant'=>$event->getEntity()->getNumber()));
	}
	
	public function createQuoteVariantGivenEvent(QuoteVariantEvent $event)
	{
		$this->_addQuoteVariantEvent($event, Quote::EVENT_GIVEN);
	}
	
	public function createQuoteVariantSendedEvent(QuoteVariantEvent $event)
	{
		$this->_addQuoteVariantEvent($event, Quote::EVENT_SEND);
	}
	
	public function createQuoteVariantReadyEvent(QuoteVariantEvent $event)
	{
		$this->_addQuoteVariantEvent($event, Quote::EVENT_READY);
	}
	
	public function createQuoteVariantInSeizureEvent(QuoteVariantEvent $event)
	{
		$this->_addQuoteVariantEvent($event, Quote::EVENT_RETURNINSEIZURE);
	}
	
	public function createQuoteVariantReceiptEvent(QuoteVariantEvent $event)
	{
		$this->_addQuoteVariantEvent($event, Quote::EVENT_RECEIPT);
	}
}
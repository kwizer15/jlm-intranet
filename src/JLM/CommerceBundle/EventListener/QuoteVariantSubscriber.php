<?php
namespace JLM\CommerceBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use JLM\CommerceBundle\JLMCommerceEvents;
use JLM\CommerceBundle\Factory\BillFactory;
use Doctrine\Common\Persistence\ObjectManager;
use JLM\CommerceBundle\Builder\VariantBillBuilder;
use JLM\CoreBundle\Event\FormPopulatingEvent;
use JLM\CoreBundle\Event\DoctrineEvent;

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
			JLMCommerceEvents::QUOTEVARIANT_FORM_POPULATE => 'populateFromQuote',
			JLMCommerceEvents::QUOTEVARIANT_PREPERSIST => 'generateNumber',
		);
	}
	
	public function populateFromQuote(FormPopulatingEvent $event)
	{
		if (null !== $id = $event->getParam('quote'))
		{
			$quote = $this->om->getRepository('JLMCommerceBundle:Quote')->find($id);
        	$event->getForm()->get('quote')->setData($quote);
		}
	}
	
	public function generateNumber(DoctrineEvent $event)
	{
		$number = $this->om->getRepository('JLMCommerceBundle:QuoteVariant')->getCount($event->getEntity()->getQuote())+1;
		$event->getEntity()->setVariantNumber($number);
	}
}
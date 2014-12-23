<?php
namespace JLM\CommerceBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use JLM\CommerceBundle\Event\BillEvent;
use JLM\CommerceBundle\JLMCommerceEvents;
use JLM\CommerceBundle\Factory\BillFactory;
use Doctrine\Common\Persistence\ObjectManager;
use JLM\CommerceBundle\Builder\VariantBillBuilder;

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
			JLMCommerceEvents::BILL_FORM_POPULATE => 'populateFromQuote',
		);
	}
	
	public function populateFromQuote(BillEvent $event)
	{
		if (null !== $id = $event->getParam('quote'))
		{
			$quote = $this->om->getRepository('JLMCommerceBundle:Quote')->find($id);
			$entity = BillFactory::create(new VariantBillBuilder($quote));
        	$event->getForm()->setData($entity);
		}
	}
}
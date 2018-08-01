<?php
namespace JLM\OfficeBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use JLM\CommerceBundle\JLMCommerceEvents;
use JLM\CommerceBundle\Entity\Quote;
use Doctrine\Common\Persistence\ObjectManager;
use JLM\CoreBundle\Event\FormPopulatingEvent;
use JLM\CoreBundle\Event\RequestEvent;

class QuoteSubscriber implements EventSubscriberInterface
{	
	private $om;
	
	public function __construct(ObjectManager $om)
	{
		$this->om = $om;
	}
	
	public static function getSubscribedEvents()
	{
		return array(
			JLMCommerceEvents::QUOTE_FORM_POPULATE => 'populateFromAsk',
		);
	}
	
	public function populateFromAsk(FormPopulatingEvent $event)
	{
		if (null !== $ask = $this->getAsk($event))
		{
			$entity = Quote::createFromAskQuote($ask);
        	$event->getForm()->setData($entity);
        	$event->getForm()->add('ask', 'hidden', array('data' => $ask->getId(), 'mapped' => false));
		}
	}
	
	private function getAsk(RequestEvent $event)
	{
		$id = $event->getParam('jlm_commerce_quote', array('ask'=>$event->getParam('ask')));
		
		return (isset($id['ask']) && $id['ask'] !== null) ? $this->om->getRepository('JLMOfficeBundle:AskQuote')->find($id['ask']) : null;
	}
}
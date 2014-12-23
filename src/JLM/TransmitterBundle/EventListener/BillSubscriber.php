<?php
namespace JLM\TransmitterBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use JLM\CommerceBundle\Event\BillEvent;
use JLM\CommerceBundle\JLMCommerceEvents;
use JLM\CommerceBundle\Factory\BillFactory;
use Doctrine\Common\Persistence\ObjectManager;
use JLM\TransmitterBundle\Builder\AttributionBillBuilder;

class BillSubscriber implements EventSubscriberInterface
{	
	private $om;
	
	public function __construct(ObjectManager $om)
	{
		$this->om = $om;
	}
	
	public static function getSubscribedEvents()
	{
		return array(
			JLMCommerceEvents::BILL_FORM_POPULATE => 'populateFromAttribution',
		);
	}
	
	public function populateFromAttribution(BillEvent $event)
	{
		if (null !== $id = $event->getParam('attribution'))
		{
			$attribution = $this->om->getRepository('JLMTransmitterBundle:Attribution')->find($id);
			$options = array(
					'port'         => $this->om->getRepository('JLMProductBundle:Product')->find(134),
			);
			$entity = BillFactory::create(new AttributionBillBuilder($attribution, $this->om->getRepository('JLMCommerceBundle:VAT')->find(1)->getRate() * 100, $options));
        	$event->getForm()->setData($entity);
		}
	}
}
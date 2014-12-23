<?php
namespace JLM\TransmitterBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use JLM\CommerceBundle\Event\BillEvent;
use JLM\CommerceBundle\JLMCommerceEvents;
use JLM\CommerceBundle\Factory\BillFactory;
use Doctrine\Common\Persistence\ObjectManager;
use JLM\TransmitterBundle\Builder\AttributionBillBuilder;
use JLM\CoreBundle\Event\FormPopulatingEvent;

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
			JLMCommerceEvents::BILL_AFTER_PERSIST => 'setBillToAttribution',
		);
	}
	
	public function populateFromAttribution(FormPopulatingEvent $event)
	{
		if (null !== $id = $event->getParam('attribution'))
		{
			$attribution = $this->om->getRepository('JLMTransmitterBundle:Attribution')->find($id);
			$options = array(
					'port'         => $this->om->getRepository('JLMProductBundle:Product')->find(134),
			);
			$entity = BillFactory::create(new AttributionBillBuilder($attribution, $this->om->getRepository('JLMCommerceBundle:VAT')->find(1)->getRate() * 100, $options));
        	$event->getForm()->setData($entity);
        	$event->getForm()->add('attribution', 'hidden', array('data' => $id, 'mapped'=>false));
		}
	}
	
	public function setBillToAttribution(BillEvent $event)
	{
		if (null !== $id = $event->getParam('jlm_commerce_bill', 'attribution'))
		{
			$entity = $this->om->getRepository('JLMTransmitterBundle:Attribution')->find($id);
			$entity->setBill($event->getBill());
			$this->om->persist($entity);
			$this->om->flush();
		}
	}
}
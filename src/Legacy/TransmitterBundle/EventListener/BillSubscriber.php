<?php
namespace JLM\TransmitterBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use JLM\CommerceBundle\Event\BillEvent;
use JLM\CommerceBundle\JLMCommerceEvents;
use JLM\CommerceBundle\Factory\BillFactory;
use Doctrine\Common\Persistence\ObjectManager;
use JLM\TransmitterBundle\Builder\AttributionBillBuilder;
use JLM\CoreBundle\Event\FormPopulatingEvent;
use JLM\CoreBundle\Event\RequestEvent;

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
		if (null !== $attribution = $this->getAttribution($event))
		{
			$options = array(
					'port' => $this->om->getRepository('JLMProductBundle:Product')->find(134),
			);
			$entity = BillFactory::create(new AttributionBillBuilder($attribution, $this->om->getRepository('JLMCommerceBundle:VAT')->find(1)->getRate(), $options));
        	$event->getForm()->setData($entity);
        	$event->getForm()->add('attribution', 'hidden', array('data' => $attribution->getId(), 'mapped' => false));
		}
	}
	
	public function setBillToAttribution(BillEvent $event)
	{
		if (null !== $entity = $this->getAttribution($event))
		{
			$entity->setBill($event->getBill());
			$this->om->persist($entity);
			$this->om->flush();
		}
	}
	
	private function getAttribution(RequestEvent $event)
	{
		$id = $event->getParam('jlm_commerce_bill', array('attribution'=>$event->getParam('attribution')));
		
		return (isset($id['attribution']) && $id['attribution'] !== null) ? $this->om->getRepository('JLMTransmitterBundle:Attribution')->find($id['attribution']) : null;
	}
}
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
use Symfony\Component\DependencyInjection\ContainerInterface;
use JLM\CoreBundle\Event\DoctrineEvent;

class BillSubscriber implements EventSubscriberInterface
{	
	private $om;
	
	private $request;
	
	public function __construct(ObjectManager $om, ContainerInterface $container)
	{
		$this->om = $om;
		$this->request = $container->get('request');
	}
	
	public static function getSubscribedEvents()
	{
		return array(
			JLMCommerceEvents::BILL_FORM_POPULATE => 'populateFromAttribution',
			JLMCommerceEvents::BILL_POSTPERSIST => 'setBillToAttribution',
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
	
	public function setBillToAttribution(DoctrineEvent $event)
	{
		if (null !== $entity = $this->getAttribution($event))
		{
			$om = $event->getObjectManager();
			$entity->setBill($event->getEntity());
			$om->persist($entity);
			$om->flush();
		}
	}
	
	private function getAttribution(RequestEvent $event)
	{
		$id = $this->request->get('jlm_commerce_bill', array('attribution'=>$this->request->get('attribution')));
		
		return (isset($id['attribution']) && $id['attribution'] !== null) ? $this->om->getRepository('JLMTransmitterBundle:Attribution')->find($id['attribution']) : null;
	}
}
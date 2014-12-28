<?php
namespace JLM\DailyBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use JLM\CommerceBundle\JLMCommerceEvents;
use JLM\CommerceBundle\Factory\BillFactory;
use Doctrine\Common\Persistence\ObjectManager;
use JLM\DailyBundle\Builder\WorkBillBuilder;
use JLM\DailyBundle\Builder\InterventionBillBuilder;
use JLM\DailyBundle\Entity\Work;
use JLM\CoreBundle\Event\FormPopulatingEvent;
use JLM\CoreBundle\Event\RequestEvent;
use JLM\CommerceBundle\Event\BillEvent;

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
			JLMCommerceEvents::BILL_FORM_POPULATE => 'populateFromIntervention',
			JLMCommerceEvents::BILL_AFTER_PERSIST => 'setBillToIntervention',
		);
	}
	
	public function populateFromIntervention(FormPopulatingEvent $event)
	{
		if (null !== $interv = $this->getIntervention($event))
		{
			$builder = ($interv instanceof Work) ? (($interv->getQuote() !== null) ? new WorkBillBuilder($interv) : null) : null;
        	$builder = ($builder === null) ? new InterventionBillBuilder($interv) : $builder;
        	$entity = BillFactory::create($builder);
        	$event->getForm()->setData($entity);
			$event->getForm()->add('intervention', 'hidden', array('data' => $interv->getId(), 'mapped' => false));
		}
	}
	
	public function setBillToIntervention(BillEvent $event)
	{
		if (null !== $entity = $this->getIntervention($event))
		{
			$entity->setBill($event->getBill());
			$this->om->persist($entity);
			$this->om->flush();
		}
	}
	
	private function getIntervention(RequestEvent $event)
	{
		$id = $event->getParam('jlm_commerce_bill', array('intervention'=>$event->getParam('intervention')));
	
		return (isset($id['intervention']) && $id['intervention'] !== null) ? $this->om->getRepository('JLMDailyBundle:Intervention')->find($id['intervention']) : null;
	}
}
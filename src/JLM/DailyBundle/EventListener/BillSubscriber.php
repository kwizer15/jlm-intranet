<?php
namespace JLM\DailyBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use JLM\CommerceBundle\Event\BillEvent;
use JLM\CommerceBundle\JLMCommerceEvents;
use JLM\CommerceBundle\Factory\BillFactory;
use Doctrine\Common\Persistence\ObjectManager;
use JLM\DailyBundle\Builder\WorkBillBuilder;
use JLM\DailyBundle\Builder\InterventionBillBuilder;
use JLM\DailyBundle\Entity\Work;


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
		);
	}
	
	public function populateFromIntervention(BillEvent $event)
	{
		if (null !== $id = $event->getParam('intervention'))
		{
			$options = array();
//					'penalty' => (string)$this->om->getRepository('JLMCommerceBundle:PenaltyModel')->find(1),
//					'property' => (string)$this->om->getRepository('JLMCommerceBundle:PropertyModel')->find(1),
//					'earlyPayment' => (string)$this->om->getRepository('JLMCommerceBundle:EarlyPaymentModel')->find(1),
//			);
			$interv = $this->om->getRepository('JLMDailyBundle:Intervention')->find($id);
			$builder = ($interv instanceof Work) ? (($interv->getQuote() !== null) ? new WorkBillBuilder($interv, $options) : null) : null;
        	$builder = ($builder === null) ? new InterventionBillBuilder($interv, $options) : $builder;
        	$entity = BillFactory::create($builder);
        	$event->getForm()->setData($entity);
		}
	}
}
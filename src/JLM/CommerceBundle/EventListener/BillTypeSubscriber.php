<?php
namespace JLM\CommerceBundle\EventListener;

use JLM\CoreBundle\EventListener\FormEntitySubscriber;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use JLM\CommerceBundle\Entity\BillLine;
use JLM\CommerceBundle\Entity\Bill;
use JLM\CommerceBundle\JLMCommerceEvents;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class BillTypeSubscriber extends FormEntitySubscriber
{	
	private $dispatcher;
	
	public function __construct(ObjectManager $om, EventDispatcherInterface $dispatcher)
	{
		parent::__construct($om);
		$this->dispatcher = $dispatcher;
	}
	
	public static function getSubscribedEvents()
	{
		return array_merge(parent::getSubscribedEvents(),
			array(
				FormEvents::PRE_SET_DATA => 'onPreSetData',
			)
		);
	}
	
	public function onPreSetData(FormEvent $event)
	{
		$bill = $event->getData();
		$bill = ($bill === null) ? new Bill() : $bill;
		$vat = $this->om->getRepository('JLMCommerceBundle:VAT')->find(1)->getRate();
		$bill
			->setCreation(new \DateTime)
			->setVat($vat)
			->setVatTransmitter($vat)
			->setPenalty((string)$this->om->getRepository('JLMCommerceBundle:PenaltyModel')->find(1))
			->setProperty((string)$this->om->getRepository('JLMCommerceBundle:PropertyModel')->find(1))
			->setEarlyPayment((string)$this->om->getRepository('JLMCommerceBundle:EarlyPaymentModel')->find(1))
			->setMaturity(30)
			->setDiscount(0)
		;

		$event->setData($bill);
		
		$this->dispatcher->dispatch(JLMCommerceEvents::BILLFORM_PRE_SET_DATA, $event);
		
		// On met une ligne s'il n'y en a pas
		if (!sizeof($event->getData()->getLines()))
		{
			$event->getData()->addLine(new BillLine());
		}

	}
}
<?php
namespace JLM\DailyBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\Common\Persistence\ObjectManager;
use JLM\CommerceBundle\JLMCommerceEvents;
use JLM\CommerceBundle\Event\QuoteVariantEvent;
use JLM\DailyBundle\Entity\Work;
use JLM\OfficeBundle\Entity\Order;

class QuoteVariantSubscriber implements EventSubscriberInterface
{	
	private $om;
	
	public function __construct(ObjectManager $om)
	{
		$this->om = $om;
	}
	
	public static function getSubscribedEvents()
	{
		return array(
			JLMCommerceEvents::QUOTEVARIANT_GIVEN => 'createWork',
		);
	}
	
	public function createWork(QuoteVariantEvent $event)
	{
		$entity = $event->getQuoteVariant();
		if ($entity->getWork() === null && $entity->getQuote()->getDoor() !== null)
		{
			// Création de la ligne travaux pré-remplie
			$work = Work::createFromQuoteVariant($entity);
			//$work->setMustBeBilled(true);
			$work->setCategory($this->om->getRepository('JLMDailyBundle:WorkCategory')->find(1));
			$work->setObjective($this->om->getRepository('JLMDailyBundle:WorkObjective')->find(1));
			$order = Order::createFromWork($work);
			$this->om->persist($order);
			$olines = $order->getLines();
			foreach ($olines as $oline)
			{
				$oline->setOrder($order);
				$this->om->persist($oline);
			}
			$work->setOrder($order);
			$this->om->persist($work);
			$entity->setWork($work);
		}
	}
}
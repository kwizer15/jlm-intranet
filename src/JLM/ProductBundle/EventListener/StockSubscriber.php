<?php

/*
 * This file is part of the JLMProductBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ProductBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use JLM\ProductBundle\JLMProductEvents;
use Doctrine\Common\Persistence\ObjectManager;
use JLM\ProductBundle\Event\ProductEvent;
use JLM\ProductBundle\Entity\Stock;


/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class StockSubscriber implements EventSubscriberInterface
{	
	/**
	 * @var ObjectManager
	 */
	private $om;
	
	public function __construct(ObjectManager $om)
	{
		$this->om = $om;
	}
	
	public static function getSubscribedEvents()
	{
		return array(
			JLMProductEvents::PRODUCT_CREATE => 'createStock',
		);
	}
	
	public function createStock(ProductEvent $event)
	{
		$stock = new Stock($event->getProduct());
		$this->om->persist($stock);
		$this->om->flush();
	}
}
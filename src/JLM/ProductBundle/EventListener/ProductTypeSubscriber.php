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
use Symfony\Component\Form\FormEvents;
use JLM\ProductBundle\Entity\SupplierPurchasePrice;
use Symfony\Component\Form\FormEvent;
use JLM\ProductBundle\Entity\Product;


/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class ProductTypeSubscriber implements EventSubscriberInterface
{	
	/**
	 * @return array
	 */
	public static function getSubscribedEvents()
	{
		return array(
			FormEvents::PRE_SET_DATA => 'onPreSetData',
		);
	}
	
	/**
	 * @param FormEvent $event
	 */
	public function onPreSetData(FormEvent $event)
	{
		$entity = ($event->getData() instanceof Product) ? $event->getData() : new Product();
		$entity->setUnity('pièce');
		if (!sizeof($entity->getSupplierPurchasePrices()))
		{
			$spp = new SupplierPurchasePrice();
			$entity->addSupplierPurchasePrice($spp);
		}
		$event->setData($entity);
	}
}
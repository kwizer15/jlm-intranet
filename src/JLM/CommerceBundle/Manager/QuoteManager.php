<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CommerceBundle\Manager;

use JLM\CoreBundle\Manager\BaseManager as Manager;
use JLM\CommerceBundle\Form\Type\QuoteType;
use JLM\CommerceBundle\JLMCommerceEvents;
use JLM\CoreBundle\Event\FormPopulatingEvent;
use JLM\CommerceBundle\Entity\Quote;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class QuoteManager extends Manager
{	
	protected function getFormParam($name, $options = array())
	{
		switch ($name)
		{
			case 'new' :
				return array(
					'method' => 'POST',
					'route' => 'bill_create',
					'params' => array(),
					'label' => 'Créer',
					'type'  => new QuoteType(),
					'entity' => null,
				);
			case 'edit' :
				return array(
					'method' => 'PUT',
					'route' => 'bill_update',
					'params' => array('id' => $options['entity']->getId()),
					'label' => 'Modifier',
					'type'  => new QuoteType(),
					'entity' => $options['entity']
				);
		}
		
		return parent::getFormParam($name, $options);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function populateForm($form)
	{
		// Appel des évenements de remplissage du formulaire
		$this->dispatch(JLMCommerceEvents::QUOTE_FORM_POPULATE, new FormPopulatingEvent($form, $this->getRequest()));
//		
//		// On complète avec ce qui reste vide
//      $vat = $this->om->getRepository('JLMCommerceBundle:VAT')->find(1)->getRate();
//		$params = array(
//				'creation' => new \DateTime,
//				'vat' => $vat,
//				'vatTransmitter' => $vat * 100,
//				'penalty' => $this->om->getRepository('JLMCommerceBundle:PenaltyModel')->find(1).'',
//				'property' => $this->om->getRepository('JLMCommerceBundle:PropertyModel')->find(1).'',
//				'earlyPayment' => $this->om->getRepository('JLMCommerceBundle:EarlyPaymentModel')->find(1).'',
//				'maturity' => 30,
//		);
//		foreach ($params as $key => $value)
//		{
//			$param = $form->get($key)->getData();
//			if (empty($param))
//			{
//				$form->get($key)->setData($value);
//			}
//		}
//		
//		// on met un ligne vide si y en a pas 
//		$lines = $form->get('lines')->getData();
//		if (empty($lines))
//		{
//			$form->get('lines')->setData(array(new BillLine()));
//		}
//	
		return parent::populateForm($form);
	}
}
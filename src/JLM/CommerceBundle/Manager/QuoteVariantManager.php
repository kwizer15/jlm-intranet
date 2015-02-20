<?php

/*
 * This file is part of the JLMCommerceBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CommerceBundle\Manager;

use JLM\CoreBundle\Manager\BaseManager as Manager;
use JLM\CommerceBundle\JLMCommerceEvents;
use JLM\CoreBundle\Event\FormPopulatingEvent;
use JLM\ModelBundle\Form\Type\MailType;
use JLM\CommerceBundle\Form\Type\QuoteVariantType;
use JLM\CommerceBundle\Entity\QuoteLine;
use JLM\CommerceBundle\Entity\Quote;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class QuoteVariantManager extends Manager
{	
	protected function getFormParam($name, $options = array())
	{
		switch ($name)
		{
			case 'new' :
				return array(
					'method' => 'POST',
					'route' => 'variant_create',
					'params' => array(),
					'label' => 'Créer',
					'type'  => new QuoteVariantType(),
					'entity' => null,
				);
			case 'edit' :
				return array(
					'method' => 'POST',
					'route' => 'variant_update',
					'params' => array('id' => $options['entity']->getId()),
					'label' => 'Modifier',
					'type'  => new QuoteVariantType(),
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
		$this->dispatch(JLMCommerceEvents::QUOTEVARIANT_FORM_POPULATE, new FormPopulatingEvent($form, $this->getRequest()));
		
		// On complète avec ce qui reste vide
		$params = array(
				'creation' => new \DateTime,
		);
		foreach ($params as $key => $value)
		{
			$param = $form->get($key)->getData();
			if (empty($param))
			{
				$form->get($key)->setData($value);
			}
		}
		
		$lines = $form->get('lines')->getData();
		if (empty($lines))
		{
			$l = new QuoteLine();
			if ($form->get('quote') instanceof Quote)
			{
				$l->setVat($form->get('quote')->getData()->getVat());
			}
			$form->get('lines')->setData(array($l));
		}

		return parent::populateForm($form);
	}
	
	public function assertState($variant, $states = array())
	{
		if (!in_array($variant->getState(), $states))
		{
			return $this->redirect('quote_show', array('id' => $variant->getQuote()->getId()));
		}
	}
}
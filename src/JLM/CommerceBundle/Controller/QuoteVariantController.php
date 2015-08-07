<?php

/*
 * This file is part of the JLMCommerceBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CommerceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\ModelBundle\Entity\Mail;
use JLM\ModelBundle\Form\Type\MailType;
use JLM\CommerceBundle\Entity\Quote;
use JLM\CommerceBundle\Entity\QuoteVariant;
use JLM\CommerceBundle\Form\Type\QuoteVariantType;
use JLM\CommerceBundle\Entity\QuoteLine;
use JLM\OfficeBundle\Entity\Order;
use JLM\DailyBundle\Entity\Work;
use JLM\CommerceBundle\Event\QuoteEvent;
use JLM\CommerceBundle\JLMCommerceEvents;
use JLM\CommerceBundle\Event\QuoteVariantEvent;
use JLM\CoreBundle\Factory\MailFactory;
use JLM\CommerceBundle\Builder\Email\QuoteVariantConfirmGivenMailBuilder;
use JLM\ModelBundle\JLMModelEvents;
use JLM\CoreBundle\Builder\MailSwiftMailBuilder;
use JLM\CommerceBundle\Builder\Email\QuoteVariantSendMailBuilder;

/**
 * QuoteVariant controller.
 *
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class QuoteVariantController extends Controller
{		
	/**
     * Displays a form to create a new Variant entity.
     */
    public function newAction(Request $request)
    {
    	$manager = $this->container->get('jlm_commerce.quotevariant_manager');
    	$manager->secure('ROLE_USER');
        $form = $manager->createForm('new');
        $form->handleRequest($request);
    	return ($form->isValid())
    		? $manager->redirect('quote_show', array('id' => $form->get('quote')->getData()->getId()))
	    	: $manager->renderResponse('JLMCommerceBundle:QuoteVariant:new.html.twig', array(
    			'quote' => $form->get('quote')->getData(),
    			'entity' => $form->getData(),
    			'form'   => $form->createView()
    	));
    }
    
	/**
	 * Displays a form to edit an existing QuoteVariant entity.
	 */
	public function editAction(Request $request, $id)
	{
		$manager = $this->container->get('jlm_commerce.quotevariant_manager');
		$manager->secure('ROLE_USER');
		$entity = $manager->getEntity($id);
		$manager->assertState($entity, array(QuoteVariant::STATE_INSEIZURE));
		$form = $manager->createForm('edit', array('entity' => $entity));
		$form->handleRequest($request);
		return ($form->isValid())
			? $manager->redirect('quote_show', array('id' => $entity->getQuote()->getId()))
			: $manager->renderResponse('JLMCommerceBundle:QuoteVariant:edit.html.twig',array(
					'quote' => $form->get('quote')->getData(),
					'entity'      => $entity,
					'form'   => $form->createView(),
				));
	}
	
	/**
	 * Change entity state and return the redirect show quote response
	 * Can send a QuoteVariantEvent if the event name is defined
	 * @param int $id
	 * @param int $state
	 * @param string $event
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 */
	private function changeState($id, $state, $event = null)
	{
		$manager = $this->container->get('jlm_commerce.quotevariant_manager');
		$manager->secure('ROLE_USER');
		$entity = $manager->getEntity($id);
		if ($entity->setState($state))
		{
			if ($event !== null)
			{
				$manager->dispatch($event, new QuoteVariantEvent($entity, $this->getRequest()));
			}
			$em = $manager->getObjectManager();
			$em->persist($entity);
			$em->flush();
		}
		
		return $manager->redirect('quote_show', array('id' => $entity->getQuote()->getId()));
	}
	
	/**
	 * Note QuoteVariant as ready to send.
	 */
	public function readyAction($id)
	{
		return $this->changeState($id, QuoteVariant::STATE_READY, JLMCommerceEvents::QUOTEVARIANT_READY);
	}

	/**
	 * Note QuoteVariant as not ready.
	 */
	public function unvalidAction($id)
	{
		return $this->changeState($id, QuoteVariant::STATE_INSEIZURE, JLMCommerceEvents::QUOTEVARIANT_INSEIZURE);
	}
	
	/**
	 * Note QuoteVariant as faxed.
	 */
	public function faxAction($id)
	{
		return $this->changeState($id, QuoteVariant::STATE_SENDED, JLMCommerceEvents::QUOTEVARIANT_SENDED);
	}
	
	/**
	 * Note QuoteVariant as canceled.
	 */
	public function cancelAction($id)
	{
		return $this->changeState($id, QuoteVariant::STATE_CANCELED, JLMCommerceEvents::QUOTEVARIANT_CANCELED);
	}
	
	/**
	 * Note QuoteVariant as receipt.
	 */
	public function receiptAction($id)
	{
		return $this->changeState($id, QuoteVariant::STATE_RECEIPT, JLMCommerceEvents::QUOTEVARIANT_RECEIPT);
	}
	
	/**
	 * Accord du devis / Création de l'intervention
	 */
	public function givenAction($id)
	{
		$this->changeState($id, QuoteVariant::STATE_GIVEN, JLMCommerceEvents::QUOTEVARIANT_GIVEN);
		$manager = $this->container->get('jlm_commerce.quotevariant_manager');
		
		return $manager->redirect('variant_email', array('id' => $id));
	}
	
	/**
	 * Email de confirmation d'accord de devis
	 */
	public function emailAction(Request $request, $id)
	{
		// @todo Passer par un service de formPopulate et créer un controller unique dans CoreBundle
		$manager = $this->container->get('jlm_commerce.quotevariant_manager');
		$manager->secure('ROLE_USER');
		$entity = $manager->getEntity($id);
		$editForm = $this->createForm('jlm_core_mail', MailFactory::create(new QuoteVariantConfirmGivenMailBuilder($entity)));
		$editForm->handleRequest($request);

		return ($editForm->isValid())
				? $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getQuote()->getId())))
				: $manager->renderResponse('JLMCommerceBundle:QuoteVariant:email.html.twig',array(
				'entity' => $entity,
				'form' => $editForm->createView(),
			));
		// $this->get('event_dispatcher')->dispatch(JLMModelEvents::DOOR_SENDMAIL, new DoorEvent($entity->getDoor(), $request));
	}

	/**
	 * Send by mail a QuoteVariant entity.
	 */
	public function sendByMailAction(Request $request, $id)
	{
		$manager = $this->container->get('jlm_commerce.quotevariant_manager');
		$manager->secure('ROLE_USER');
		$entity = $manager->getEntity($id);
		if ($entity->getState() < QuoteVariant::STATE_READY)
		{
			return $manager->redirect('quote_show', array('id' => $entity->getQuote()->getId()));
		}
		
		$form = $this->createForm('jlm_core_mail', MailFactory::create(new QuoteVariantSendMailBuilder($entity)));
		$form->handleRequest($request);
		if ($form->isValid())
		{			
			$manager->dispatch(JLMCommerceEvents::QUOTEVARIANT_SENDED, new QuoteVariantEvent($entity, $request));
				
			return $manager->redirect('quote_show', array('id' => $entity->getQuote()->getId()));
		}
		
		return $manager->renderResponse('JLMCommerceBundle:QuoteVariant:mail.html.twig',array(
				'entity' => $entity,
				'form' => $form->createView(),
			));
	}
	
	/**
	 * Print a Quote
	 */
	public function printAction($id)
	{
		$manager = $this->container->get('jlm_commerce.quotevariant_manager');
		$manager->secure('ROLE_USER');
		$entity = $manager->getEntity($id);
		
		return $manager->renderPdf($entity->getNumber(), 'JLMCommerceBundle:Quote:quote.pdf.php', array('entities'=>array($entity)));
	}
	
	/**
	 * Print a coding
	 */
	public function printcodingAction($id)
	{
		$manager = $this->container->get('jlm_commerce.quotevariant_manager');
		$manager->secure('ROLE_USER');
		$entity = $manager->getEntity($id);
		if ($entity->getState() == QuoteVariant::STATE_CANCELED)
		{
			return $manager->redirect('quote_show', array('id' => $entity->getQuote()->getId()));
		}
		
		return $manager->renderPdf('chiffrage-'.$entity->getNumber(), 'JLMCommerceBundle:QuoteVariant:coding.pdf.php',array('entity'=>$entity));
	}
}
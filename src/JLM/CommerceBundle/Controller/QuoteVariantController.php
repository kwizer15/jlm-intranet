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
    public function newAction()
    {
    	$manager = $this->container->get('jlm_commerce.quotevariant_manager');
    	$manager->secure('ROLE_USER');
        $form   = $manager->createForm('new');
        if ($manager->getHandler($form)->process())
    	{
    		return $manager->redirect('quote_show', array('id' => $form->get('quote')->getData()->getId()));
    	}
    	
    	return $manager->renderResponse('JLMCommerceBundle:QuoteVariant:new.html.twig', array(
    			'quote' => $form->get('quote')->getData(),
    			'entity' => $form->getData(),
    			'form'   => $form->createView()
    	));
    }
    
	/**
	 * Displays a form to edit an existing QuoteVariant entity.
	 */
	public function editAction($id)
	{
		$manager = $this->container->get('jlm_commerce.quotevariant_manager');
		$manager->secure('ROLE_USER');
		$entity = $manager->getEntity($id);
		$manager->assertState($entity, array(QuoteVariant::STATE_INSEIZURE));
		$form = $manager->createForm('edit', array('entity' => $entity));
		if ($manager->getHandler($form)->process())
		{
			return $manager->redirect('quote_show', array('id' => $entity->getQuote()->getId()));
		}
		
		return $manager->renderResponse('JLMCommerceBundle:QuoteVariant:edit.html.twig',array(
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
		return $this->changeState($id, QuoteVariant::STATE_GIVEN, JLMCommerceEvents::QUOTEVARIANT_GIVEN);
	}
	
	/**
	 * Mail
	 * @Template()
	 */
	public function mailAction($id)
	{
		$manager = $this->container->get('jlm_commerce.quotevariant_manager');
		$manager->secure('ROLE_USER');
		$entity = $manager->getEntity($id);
		$manager->assertState(array(
				QuoteVariant::STATE_READY,
				QuoteVariant::STATE_PRINTED,
				QuoteVariant::STATE_SENDED,
				QuoteVariant::STATE_RECEIPT,
				QuoteVariant::STATE_GIVEN
		));
		$mail = new Mail();
		$mail->setSubject('Devis n°'.$entity->getNumber());
		$mail->setFrom('contact@aufedis.fr');
		$mail->setBody($this->renderView('JLMCommerceBundle:QuoteVariant:email.txt.twig', array('intro' => $entity->getIntro(),'door' => $entity->getQuote()->getDoorCp())));
		$mail->setSignature($this->renderView('JLMCommerceBundle:QuoteVariant:emailsignature.txt.twig', array('name' => $entity->getQuote()->getFollowerCp())));
		if ($entity->getQuote()->getContact())
		{
			if ($entity->getQuote()->getContact()->getPerson())
			{
				if ($entity->getQuote()->getContact()->getPerson()->getEmail())
				{
					$mail->setTo($entity->getQuote()->getContact()->getPerson()->getEmail());
				}
			}
		}
		$form   = $this->createForm(new MailType(), $mail);
	
		return array(
				'entity' => $entity,
				'form'   => $form->createView()
		);
	}
	
	/**
	 * Send by mail a QuoteVariant entity.
	 */
	public function sendmailAction($id)
	{
		$manager = $this->container->get('jlm_commerce.quotevariant_manager');
		$manager->secure('ROLE_USER');
		$request = $manager->getRequest();
		$entity = $manager->getEntity($id);
		if ($entity->getState() < QuoteVariant::STATE_READY)
		{
			return $manager->redirect('quote_show', array('id' => $entity->getQuote()->getId()));
		}
		
		// Message
		$mail = new Mail;
		$form = $this->createForm(new MailType(), $mail);
		$form->handleRequest($request);
		 
		if ($form->isValid())
		{
			$mail->setBcc('contact@aufedis.fr');
			
			$message = $mail->getSwift();
			$message->setReadReceiptTo('contact@aufedis.fr');
			$message->attach(\Swift_Attachment::newInstance(
					\JLM\CommerceBundle\Pdf\Quote::get(array($entity)),
					$entity->getNumber().'.pdf','application/pdf'
			))
			;
			$em = $this->getDoctrine()->getManager();
			if ($entity->getQuote()->getVat() == $entity->getQuote()->getVatTransmitter())
			{
				$message->attach(\Swift_Attachment::fromPath(
						$this->get('kernel')->getRootDir().'/../web/bundles/jlmcommerce/pdf/attestation.pdf'
				))
				;
			} 
			$this->get('mailer')->send($message);
			$entity->setState(QuoteVariant::STATE_SENDED);
			$em->persist($entity);
			$em->flush();
		}
		
		return $manager->redirect('quote_show', array('id' => $entity->getQuote()->getId()));
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

		return $manager->renderPdf('chiffrage-'.$entity->getNumber(), 'JLMCommerceBundle:Quote:coding.pdf.php',array('entities'=>array($entity)));
	}
}

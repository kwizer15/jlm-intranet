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
use JLM\OfficeBundle\Entity\Task;
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
	private function createNewForm(QuoteVariant $entity)
	{
		return $this->createForm(new QuoteVariantType(), $entity);
	}
	
	private function createEditForm(QuoteVariant $entity)
	{
		return $this->createForm(new QuoteVariantType(), $entity);
	}
	
	/**
     * Displays a form to create a new Variant entity.
     *
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function newAction(Quote $quote)
    {
        $entity = new QuoteVariant();
        $entity->setQuote($quote);
        
        $entity->setCreation(new \DateTime);
        $l = new QuoteLine;
        $l->setVat($quote->getVat());
        $entity->addLine($l);
        $form   = $this->createNewForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }
    
    /**
     * Creates a new Variant entity.
     *
     * @Template("JLMCommerceBundle:QuoteVariant:new.html.twig")
     * @Secure(roles="ROLE_USER")
     */
    public function createAction(Request $request)
    {
    	$entity  = new QuoteVariant();
    	$form    = $this->createNewForm($entity);
    	$form->handleRequest($request);
    
    	if ($form->isValid())
    	{
    		$em = $this->getDoctrine()->getManager();
    		$lines = $entity->getLines();
			$number = $em->getRepository('JLMCommerceBundle:QuoteVariant')->getCount($entity->getQuote())+1;
			$entity->setVariantNumber($number);
    		$em->persist($entity);
    		$em->flush();
    		return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getQuote()->getId())));
    	}
    
    	return array(
	    	'entity' => $entity,
	    	'form'   => $form->createView()
    	);
    }
    
	/**
	 * Displays a form to edit an existing QuoteVariant entity.
	 *
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function editAction(QuoteVariant $entity)
	{
		// Si le devis est déjà validé, on empèche quelconque modification
		if ($entity->getState() != QuoteVariant::STATE_INSEIZURE)
		{
			return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getQuote()->getId())));
		}
		$editForm = $this->createEditForm($entity);
		
		return array(
				'entity'      => $entity,
				'edit_form'   => $editForm->createView(),
		);
	}
	
	/**
	 * Edits an existing QuoteVariant entity.
	 *
	 * @Template("JLMCommerceBundle:QuoteVariant:edit.html.twig")
	 * @Secure(roles="ROLE_USER")
	 */
	public function updateAction(Request $request, QuoteVariant $entity)
	{
		 
		// Si le devis est déjà validé, on empèche quelconque odification
		if ($entity->getState() != QuoteVariant::STATE_INSEIZURE)
		{
			return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getQuote()->getId())));
		}

		$editForm = $this->createEditForm($entity);
		$editForm->handleRequest($request);
	
		if ($editForm->isValid())
		{
			$em = $this->getDoctrine()->getManager();
			$em->persist($entity);
			$em->flush();
			
			return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getQuote()->getId())));
		}
	
		return array(
				'entity'      => $entity,
				'edit_form'   => $editForm->createView(),
		);
	}
	
	/**
	 * Note QuoteVariant as ready to send.
	 *
	 * @Secure(roles="ROLE_USER")
	 */
	public function readyAction(QuoteVariant $entity)
	{
		if ($entity->getState() < QuoteVariant::STATE_INSEIZURE)
		{
			return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getQuote()->getId())));
		}
		$entity->setState(QuoteVariant::STATE_READY);
		$em = $this->getDoctrine()->getManager();
		$em->persist($entity);
		$em->flush();
		
		return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getQuote()->getId())));
	}
	
	/**
	 * Mail
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function mailAction(QuoteVariant $entity)
	{
		if ($entity->getState() < QuoteVariant::STATE_READY)
		{
			return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getQuote()->getId())));
		}
		$mail = new Mail();
		$mail->setSubject('Devis n°'.$entity->getNumber());
		$mail->setFrom('commerce@jlm-entreprise.fr');
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
	 *
	 * @Secure(roles="ROLE_USER")
	 */
	public function sendmailAction(Request $request, QuoteVariant $entity)
	{
		if ($entity->getState() < QuoteVariant::STATE_READY)
		{
			return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getQuote()->getId())));
		}
		
		// Message
		$mail = new Mail;
		$form = $this->createForm(new MailType(), $mail);
		$form->handleRequest($request);
		 
		if ($form->isValid())
		{
			$mail->setBcc('commerce@jlm-entreprise.fr');
			
			$message = $mail->getSwift();
			$message->setReadReceiptTo('commerce@jlm-entreprise.fr');
			$message->attach(\Swift_Attachment::newInstance(
					$this->render('JLMCommerceBundle:Quote:quote.pdf.php',array('entities'=>array($entity))),
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
		
		return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getQuote()->getId())));
	}
	
	
	
	/**
	 * @Secure(roles="ROLE_USER")
	 */
	public function printAction(QuoteVariant $entity)
	{
		$response = new Response();
		$response->headers->set('Content-Type', 'application/pdf');
		$response->headers->set('Content-Disposition', 'inline; filename='.$entity->getNumber().'.pdf');
		$response->setContent($this->render('JLMCommerceBundle:Quote:quote.pdf.php',array('entities'=>array($entity))));
		 
		return $response;
	}
	
	/**
	 * @Secure(roles="ROLE_USER")
	 */
	public function printcodingAction(QuoteVariant $entity)
	{
		if ($entity->getState() == QuoteVariant::STATE_CANCELED)
		{
			return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getQuote()->getId())));
		}
		$em = $this->getDoctrine()->getManager();
		$em->persist($entity);
		$em->flush();
			
		$response = new Response();
		$response->headers->set('Content-Type', 'application/pdf');
		$response->headers->set('Content-Disposition', 'inline; filename=chiffrage'.$entity->getNumber().'.pdf');
		$response->setContent($this->render('JLMCommerceBundle:QuoteVariant:coding.pdf.php',array('entity'=>$entity)));
			
		return $response;
	}
	
	
	/**
	 * Note QuoteVariant as not ready.
	 *
	 * @Secure(roles="ROLE_USER")
	 */
	public function unvalidAction(QuoteVariant $entity)
	{
		if ($entity->setState(QuoteVariant::STATE_INSEIZURE))
		{
			$em = $this->getDoctrine()->getManager();
			$em->persist($entity);
			$em->flush();
		}
		
		return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getQuote()->getId())));
	}
	
	/**
	 * Note QuoteVariant as faxed.
	 *
	 * @Secure(roles="ROLE_USER")
	 */
	public function faxAction(QuoteVariant $entity)
	{
		if ($entity->setState(QuoteVariant::STATE_SENDED))
		{
			$em = $this->getDoctrine()->getManager();
			$em->persist($entity);
			$em->flush();
		}
		
		return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getQuote()->getId())));
	}
	
	/**
	 * Note QuoteVariant as canceled.
	 *
	 * @Secure(roles="ROLE_USER")
	 */
	public function cancelAction(QuoteVariant $entity)
	{
		if ($entity->setState(QuoteVariant::STATE_CANCELED))
		{
			$em = $this->getDoctrine()->getManager();
			$em->persist($entity);
			$em->flush();
		}
		
		return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getQuote()->getId())));
	}
	
	/**
	 * Note QuoteVariant as receipt.
	 *
	 * @Secure(roles="ROLE_USER")
	 */
	public function receiptAction(QuoteVariant $entity)
	{
		if ($entity->setState(QuoteVariant::STATE_RECEIPT))
		{
			$em = $this->getDoctrine()->getManager();
			$em->persist($entity);
			$em->flush();
		}
		
		return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getQuote()->getId())));;
	}
	
	/**
	 * Accord du devis / Création de l'intervention
	 *
	 * @Secure(roles="ROLE_USER")
	 */
	public function givenAction(QuoteVariant $entity)
	{
		if ($entity->setState(QuoteVariant::STATE_GIVEN))
		{
			$this->get('event_dispatcher')->dispatch(JLMCommerceEvents::QUOTEVARIANT_GIVEN, new QuoteVariantEvent($entity, $this->getRequest()));
			$em = $this->getDoctrine()->getManager();
			$em->persist($entity);
			$em->flush();
		}

		return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getQuote()->getId())));
	}
	
	private function changeEntityState(QuoteVariant $entity, $state)
	{
		$entity->setState($state);
	}
}
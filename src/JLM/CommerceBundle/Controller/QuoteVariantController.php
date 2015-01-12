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
    		foreach ($lines as $line)
    		{
    			$line->setVariant($entity);
    			$em->persist($line);
    		}
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
		if ($entity->getState())
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
		if ($entity->getState())
		{
			return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getQuote()->getId())));
		}
	
		$originalLines = array();
		foreach ($entity->getLines() as $line)
		{
			$originalLines[] = $line;
		}
		$editForm = $this->createEditForm($entity);
		$editForm->handleRequest($request);
	
		if ($editForm->isValid())
		{
			$em = $this->getDoctrine()->getManager();
			$em->persist($entity);
			$lines = $entity->getLines();
			foreach ($lines as $key => $line)
			{
	
				// Nouvelles lignes
				$line->setVariant($entity);
				$em->persist($line);
	
				// On vire les anciennes
				foreach ($originalLines as $key => $toDel)
				{
					if ($toDel->getId() === $line->getId())
					{
						unset($originalLines[$key]);
					}
				}
			}
			foreach ($originalLines as $line)
			{
				$em->remove($line);
			}
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
		if ($entity->getState() < 0)
		{
			return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getQuote()->getId())));
		}
		if ($entity->getState() < 1)
		{
			$entity->setState(1);
		}
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
		if ($entity->getState() < 1)
		{
			return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getQuote()->getId())));
		}
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
	 *
	 * @Secure(roles="ROLE_USER")
	 */
	public function sendmailAction(Request $request, QuoteVariant $entity)
	{
		if ($entity->getState() < 1)
		{
			return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getQuote()->getId())));
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
			if ($entity->getState() < 3)
			{
				$entity->setState(3);
			}
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
		if ($entity->getState() < 0)
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
		$response = $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getQuote()->getId())));
		if (!$this->changeEntityState($entity, 0))
		{
			return $response;
		}
		$em = $this->getDoctrine()->getManager();
		$em->persist($entity);
		$em->flush();
		
		return $response;
	}
	
	/**
	 * Note QuoteVariant as faxed.
	 *
	 * @Secure(roles="ROLE_USER")
	 */
	public function faxAction(QuoteVariant $entity)
	{
		$response = $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getQuote()->getId())));
		if (!$this->changeEntityState($entity, 3))
		{
			return $response;
		}
		$em = $this->getDoctrine()->getManager();
		$em->persist($entity);
		$em->flush();
		
		return $response;
	}
	
	/**
	 * Note QuoteVariant as canceled.
	 *
	 * @Secure(roles="ROLE_USER")
	 */
	public function cancelAction(QuoteVariant $entity)
	{
		$entity->setState(-1);
		$em = $this->getDoctrine()->getManager();
		$em->persist($entity);
		$em->flush();
		
		return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getQuote()->getId())));
	}
	
	/**
	 * Note QuoteVariant as receipt.
	 *
	 * @Secure(roles="ROLE_USER")
	 */
	public function receiptAction(QuoteVariant $entity)
	{
		$response = $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getQuote()->getId())));
		if (!$this->changeEntityState($entity, 4))
		{
			return $response;
		}
		$em = $this->getDoctrine()->getManager();
		$em->persist($entity);
		$em->flush();
		
		return $response;
	}
	
	/**
	 * Note QuoteVariant as given.
	 *
	 * @Secure(roles="ROLE_USER")
	 */
	public function oldgivenAction(QuoteVariant $entity)
	{
		$response = $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getQuote()->getId())));
		if (!$this->changeEntityState($entity, 5))
		{
			return $response;
		}
		$em = $this->getDoctrine()->getManager();
		
		$task = new Task();
		$task->setDoor($entity->getQuote()->getDoor());
		$task->setPlace($entity->getQuote()->getDoorCp());
		$task->setTodo('Accord du devis n°'.$entity->getNumber());
		$task->setType($em->getRepository('JLMOfficeBundle:TaskType')->find(3));
		$task->setUrlSource($this->generateUrl('variant_print', array('id' => $entity->getId())));
		$task->setUrlAction($this->generateUrl('order_new_quotevariant', array('id' => $entity->getId())));
		
		$em->persist($entity);
		$em->persist($task);
		$em->flush();
		
		return $response;
	}
	
	/**
	 * Accord du devis / Création de l'intervention
	 *
	 * @Secure(roles="ROLE_USER")
	 */
	public function givenAction(QuoteVariant $entity)
	{
		if (!$this->changeEntityState($entity, 5))
		{
			return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getQuote()->getId())));
		}
		
		$em = $this->getDoctrine()->getManager();
//		if ($entity->getWork() === null && $entity->getQuote()->getDoor() !== null)
//		{			
//			// Création de la ligne travaux pré-remplie
//			$work = Work::createFromQuoteVariant($entity);
//			//$work->setMustBeBilled(true);
//			$work->setCategory($em->getRepository('JLMDailyBundle:WorkCategory')->find(1));
//			$work->setObjective($em->getRepository('JLMDailyBundle:WorkObjective')->find(1));
//			$order = Order::createFromWork($work);
//			$em->persist($order);
//			$olines = $order->getLines();
//			foreach ($olines as $oline)
//			{
//				$oline->setOrder($order);
//				$em->persist($oline);
//			}
//			$work->setOrder($order);
//			$em->persist($work);
//			$entity->setWork($work);
//		}
		$em->persist($entity);
		$em->flush();
		
		return $this->redirect($this->generateUrl('bill_new',array('quote'=>$entity->getId())));
	}
	
	private function changeEntityState(QuoteVariant $entity, $state)
	{
		$asserts = array(
			0 => array(1,5),
			3 => array(1,3),
			4 => array(3,4),
			5 => array(4,5),
		);
		// 0
		if ($entity->getState() < $asserts[$state][0])
		{
			return false;
		}
		if ($entity->getState() < $asserts[$state][1])
		{
			$entity->setState($state);
		}
		
		return true;
	}
}
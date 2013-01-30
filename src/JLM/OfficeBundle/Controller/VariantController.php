<?php

namespace JLM\OfficeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\ModelBundle\Entity\Mail;
use JLM\ModelBundle\Form\Type\MailType;
use JLM\OfficeBundle\Entity\Quote;
use JLM\OfficeBundle\Entity\QuoteVariant;
use JLM\OfficeBundle\Form\Type\QuoteVariantType;
use JLM\OfficeBundle\Entity\QuoteLine;
use JLM\OfficeBundle\Entity\Task;



/**
 * Quote controller.
 *
 * @Route("/quote/variant")
 */
class VariantController extends Controller
{
	/**
     * Displays a form to create a new Variant entity.
     *
     * @Route("/{id}/new", name="variant_new")
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
        $form   = $this->createForm(new QuoteVariantType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }
    
    /**
     * Creates a new Variant entity.
     *
     * @Route("/create", name="variant_create")
     * @Method("post")
     * @Template("JLMOfficeBundle:Variant:new.html.twig")
     * @Secure(roles="ROLE_USER")
     */
    public function createAction(Request $request)
    {
    	$entity  = new QuoteVariant();
    	$form    = $this->createForm(new QuoteVariantType(), $entity);
    	$form->bind($request);
    
    	if ($form->isValid())
    	{
    		$em = $this->getDoctrine()->getEntityManager();
    		$lines = $entity->getLines();
    		foreach ($lines as $line)
    		{
    			$line->setVariant($entity);
    			$em->persist($line);
    		}
			$number = $em->getRepository('JLMOfficeBundle:QuoteVariant')->getCount($entity->getQuote())+1;
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
	 * @Route("/{id}/edit", name="variant_edit")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function editAction(QuoteVariant $entity)
	{
		// Si le devis est déjà validé, on empèche quelconque modification
		if ($entity->getState())
			return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getQuote()->getId())));
		$editForm = $this->createForm(new QuoteVariantType(), $entity);
		return array(
				'entity'      => $entity,
				'edit_form'   => $editForm->createView(),
		);
	}
	
	/**
	 * Edits an existing QuoteVariant entity.
	 *
	 * @Route("/{id}/update", name="variant_update")
	 * @Method("post")
	 * @Template("JLMOfficeBundle:Variant:edit.html.twig")
	 * @Secure(roles="ROLE_USER")
	 */
	public function updateAction(Request $request, QuoteVariant $entity)
	{
		 
		// Si le devis est déjà validé, on empèche quelconque odification
		if ($entity->getState())
			return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getQuote()->getId())));
	
		$originalLines = array();
		foreach ($entity->getLines() as $line)
			$originalLines[] = $line;
		$editForm = $this->createForm(new QuoteVariantType(), $entity);
		$editForm->bind($request);
	
		if ($editForm->isValid()) {
			$em = $this->getDoctrine()->getEntityManager();
			$em->persist($entity);
			foreach ($entity->getLines() as $key => $line)
			{
	
				// Nouvelles lignes
				$line->setVariant($entity);
				$em->persist($line);
	
				// On vire les anciennes
				foreach ($originalLines as $key => $toDel)
					if ($toDel->getId() === $line->getId())
					unset($originalLines[$key]);
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
	 * @Route("/{id}/ready", name="variant_ready")
	 * @Secure(roles="ROLE_USER")
	 */
	public function readyAction(QuoteVariant $entity)
	{
		if ($entity->getState() < 0)
			return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getQuote()->getId())));
		
		if ($entity->getState() < 1)
			$entity->setState(1);
		$em = $this->getDoctrine()->getEntityManager();
		$em->persist($entity);
		$em->flush();
		return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getQuote()->getId())));
	}
	
	/**
	 * Mail
	 * @Route("/{id}/mail", name="variant_mail")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function mailAction(QuoteVariant $entity)
	{
		if ($entity->getState() < 1)
			return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getQuote()->getId())));
		$mail = new Mail();
		$mail->setSubject('Devis n°'.$entity->getNumber());
		$mail->setFrom('commerce@jlm-entreprise.fr');
		$mail->setBody($this->renderView('JLMOfficeBundle:Variant:email.txt.twig', array('intro' => $entity->getIntro(),'door' => $entity->getQuote()->getDoorCp())));
		$mail->setSignature($this->renderView('JLMOfficeBundle:Variant:emailsignature.txt.twig', array('name' => $entity->getQuote()->getFollowerCp())));
		if ($entity->getQuote()->getContact())
			if ($entity->getQuote()->getContact()->getPerson())
			if ($entity->getQuote()->getContact()->getPerson()->getEmail())
			$mail->setTo($entity->getQuote()->getContact()->getPerson()->getEmail());
		$form   = $this->createForm(new MailType(), $mail);
	
		return array(
				'entity' => $entity,
				'form'   => $form->createView()
		);
	}
	
	/**
	 * Send by mail a QuoteVariant entity.
	 *
	 * @Route("/{id}/sendmail", name="variant_sendmail")
	 * @Method("post")
	 * @Secure(roles="ROLE_USER")
	 */
	public function sendmailAction(Request $request, QuoteVariant $entity)
	{
		if ($entity->getState() < 1)
			return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getQuote()->getId())));
		
		// Message
		$mail = new Mail;
		$form = $this->createForm(new MailType(), $mail);
		$form->bind($request);
		 
		if ($form->isValid()) {
			$mail->setCC('commerce@jlm-entreprise.fr');
			
			$message = $mail->getSwift();
			$message->setReadReceiptTo('commerce@jlm-entreprise.fr');
			$message->attach(\Swift_Attachment::newInstance(
					$this->render('JLMOfficeBundle:Quote:quote.pdf.php',array('entity'=>array($entity))),
					$entity->getNumber().'.pdf','application/pdf'
			))
			;
			 
			$this->get('mailer')->send($message);
			if ($entity->getState() < 3)
				$entity->setState(3);
			$em = $this->getDoctrine()->getEntityManager();
			$em->persist($entity);
			$em->flush();
		}
		return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getQuote()->getId())));
	}
	
	
	
	/**
	 * @Route("/{id}/print",name="variant_print")
	 * @Secure(roles="ROLE_USER")
	 */
	public function printAction(QuoteVariant $entity)
	{
		$response = new Response();
		$response->headers->set('Content-Type', 'application/pdf');
		$response->headers->set('Content-Disposition', 'inline; filename='.$entity->getNumber().'.pdf');
		$response->setContent($this->render('JLMOfficeBundle:Quote:quote.pdf.php',array('entity'=>array($entity))));
		 
		//   return array('entity'=>$entity);
		return $response;
	}
	
	/**
	 * @Route("/{id}/printcoding",name="variant_printcoding")
	 * @Secure(roles="ROLE_USER")
	 */
	public function printcodingAction(QuoteVariant $entity)
	{
		if ($entity->getState() < 0)
			return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getQuote()->getId())));
	
		$em = $this->getDoctrine()->getEntityManager();
		$em->persist($entity);
		$em->flush();
			
		$response = new Response();
		$response->headers->set('Content-Type', 'application/pdf');
		$response->headers->set('Content-Disposition', 'inline; filename=chiffrage'.$entity->getNumber().'.pdf');
		$response->setContent($this->render('JLMOfficeBundle:Variant:coding.pdf.php',array('entity'=>$entity)));
			
		//   return array('entity'=>$entity);
		return $response;
	}
	
	
	/**
	 * Note QuoteVariant as not ready.
	 *
	 * @Route("/{id}/unvalid", name="variant_unvalid")
	 * @Secure(roles="ROLE_USER")
	 */
	public function unvalidAction(QuoteVariant $entity)
	{
		if ($entity->getState() < 1)
			return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getQuote()->getId())));
	
		if ($entity->getState() < 5)
			$entity->setState(0);
		$em = $this->getDoctrine()->getEntityManager();
		$em->persist($entity);
		$em->flush();
		return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getQuote()->getId())));
	}
	
	/**
	 * Note QuoteVariant as faxed.
	 *
	 * @Route("/{id}/fax", name="variant_fax")
	 * @Secure(roles="ROLE_USER")
	 */
	public function faxAction(QuoteVariant $entity)
	{
		if ($entity->getState() < 1)
			return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getQuote()->getId())));
	
		if ($entity->getState() < 3)
			$entity->setState(3);
		$em = $this->getDoctrine()->getEntityManager();
		$em->persist($entity);
		$em->flush();
		return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getQuote()->getId())));
	}
	
	/**
	 * Note QuoteVariant as receipt.
	 *
	 * @Route("/{id}/receipt", name="variant_receipt")
	 * @Secure(roles="ROLE_USER")
	 */
	public function receiptAction(QuoteVariant $entity)
	{
		if ($entity->getState() < 3)
			return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getQuote()->getId())));
	
		if ($entity->getState() < 4)
			$entity->setState(4);
		$em = $this->getDoctrine()->getEntityManager();
		$em->persist($entity);
		$em->flush();
		return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getQuote()->getId())));
	}
	
	/**
	 * Note QuoteVariant as given.
	 *
	 * @Route("/{id}/given", name="variant_given")
	 * @Secure(roles="ROLE_USER")
	 */
	public function givenAction(QuoteVariant $entity)
	{
		if ($entity->getState() < 4)
			return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getQuote()->getId())));
	
		if ($entity->getState() < 5)
			$entity->setState(5);
		
		$em = $this->getDoctrine()->getEntityManager();
		
		$task = new Task();
		$task->setDoor($entity->getQuote()->getDoor());
		$task->setPlace($entity->getQuote()->getDoorCp());
		$task->setTodo('Accord du devis n°'.$entity->getNumber());
		$task->setType($em->getRepository('JLMOfficeBundle:TaskType')->find(3));
		$task->setUrlSource($this->generateUrl('variant_print', array('id' => $entity->getId())));
		
		$em = $this->getDoctrine()->getEntityManager();
		$em->persist($entity);
		$em->persist($task);
		$em->flush();
		return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getQuote()->getId())));
	}
}
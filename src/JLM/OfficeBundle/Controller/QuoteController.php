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
use JLM\OfficeBundle\Form\Type\QuoteType;
use JLM\OfficeBundle\Entity\QuoteLine;



/**
 * Quote controller.
 *
 * @Route("/quote")
 */
class QuoteController extends Controller
{
    /**
     * Lists all Quote entities.
     *
     * @Route("/", name="quote")
     * @Route("/page/{page}", name="quote_page")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function indexAction($page = 1)
    {
    	$limit = 10;
        $em = $this->getDoctrine()->getEntityManager();
           
        $nb = $em->getRepository('JLMOfficeBundle:Quote')->getTotal();
        $nbPages = ceil($nb/$limit);
        $nbPages = ($nbPages < 1) ? 1 : $nbPages;
        $offset = ($page-1) * $limit;
        if ($page < 1 || $page > $nbPages)
        {
        	throw $this->createNotFoundException('Page insexistante (page '.$page.'/'.$nbPages.')');
        }
        
        $entities = $em->getRepository('JLMOfficeBundle:Quote')->findBy(
        		array(),
        		array('number'=>'desc'),
        		$limit,
        		$offset
        );
        
        return array(
        		'entities' => $entities,
        		'page'     => $page,
        		'nbPages'  => $nbPages,
        );
    }

    /**
     * Finds and displays a Quote entity.
     *
     * @Route("/{id}/show", name="quote_show")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function showAction(Quote $entity)
    {
        return array('entity'=> $entity);
    }
    
    /**
     * Displays a form to create a new Quote entity.
     *
     * @Route("/new", name="quote_new")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function newAction()
    {
        $entity = new Quote();
        $entity->setCreation(new \DateTime);
      //  $entity->addLine(new QuoteLine);
        $em = $this->getDoctrine()->getEntityManager();
        $vat = $em->getRepository('JLMModelBundle:VAT')->find(1)->getRate();
		$entity->setVat($vat);
		$entity->setVatTransmitter($vat);
        $form   = $this->createForm(new QuoteType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Quote entity.
     *
     * @Route("/create", name="quote_create")
     * @Method("post")
     * @Template("JLMOfficeBundle:Quote:new.html.twig")
     * @Secure(roles="ROLE_USER")
     */
    public function createAction(Request $request)
    {
        $entity  = new Quote();
        $form    = $this->createForm(new QuoteType(), $entity);
        $form->bind($request);
		
        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getEntityManager();
            $number = $entity->getCreation()->format('ym');
            $n = ($em->getRepository('JLMOfficeBundle:Quote')->getLastNumber() + 1);
            for ($i = strlen($n); $i < 4 ; $i++)
            	$number.= '0';
            $number.= $n;
            $entity->setNumber($number);
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getId())));  
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Quote entity.
     *
     * @Route("/{id}/edit", name="quote_edit")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function editAction(Quote $entity)
    {
    	// Si le devis est déjà validé, on empèche quelconque modification
    	if ($entity->getState())
    		return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getId())));
        $editForm = $this->createForm(new QuoteType(), $entity);
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Quote entity.
     *
     * @Route("/{id}/update", name="quote_update")
     * @Method("post")
     * @Template("JLMOfficeBundle:Quote:edit.html.twig")
     * @Secure(roles="ROLE_USER")
     */
    public function updateAction(Request $request, Quote $entity)
    {
    	
    	// Si le devis est déjà validé, on empèche quelconque modification
    	if ($entity->isValid())
    		return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getId())));
    	 
        $editForm = $this->createForm(new QuoteType(), $entity);
        $editForm->bind($request);
        
        if ($editForm->isValid()) {
        	$em = $this->getDoctrine()->getEntityManager();
        	$em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getId())));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Valid a Quote entity.
     *
     * @Route("/{id}/valid", name="quote_valid")
     * @Secure(roles="ROLE_USER")
     */
    public function validAction(Request $request, Quote $entity)
    {
    	$entity->setValid();
    	$em = $this->getDoctrine()->getEntityManager();
    	$em->persist($entity);
    	$em->flush();
    	return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getId())));
    }
    
    /**
     * dévalide a Quote entity.
     *
     * @Route("/{id}/unvalid", name="quote_unvalid")
     * @Secure(roles="ROLE_USER")
     */
    public function unvalidAction(Request $request, Quote $entity)
    {
    	$entity->setValid(false);
    	$entity->setSend(false);
    	$entity->setGiven(false);
    	$em = $this->getDoctrine()->getEntityManager();
    	$em->persist($entity);
    	$em->flush();
    	return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getId())));
    }
    
    /**
     * Send a Quote entity.
     *
     * @Route("/{id}/send", name="quote_send")
     * @Method("post")
     * @Secure(roles="ROLE_USER")
     */
    public function sendAction(Request $request, Quote $entity)
    {
    	if (!$entity->isValid())
    		return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getId())));
    	$entity->setSend();
    	$em = $this->getDoctrine()->getEntityManager();
    	$em->persist($entity);
    	$em->flush();
    	
    	// Message
    	$mail = new Mail;
    	$form = $this->createForm(new MailType(), $mail);
    	$form->bind($request);
    	
    	if ($form->isValid()) {
    		$message = $mail->getSwift();
	    	$message->attach(\Swift_Attachment::newInstance(
	    			$this->render('JLMOfficeBundle:Quote:older.pdf.php',array('entity'=>$entity)),
	    			$entity->getNumber().'.pdf','application/pdf'
    			))
    		;
  	
    		$this->get('mailer')->send($message);
    	}
    	return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getId())));
    }
    
    /**
     * Mail
     * @Route("/{id}/mail", name="quote_mail")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function mailAction(Quote $entity)
    {
    	if (!$entity->isValid())
    		return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getId())));
    	$mail = new Mail();
        $mail->setSubject('Devis n°'.$entity->getNumber());
    	$mail->setFrom('commerce@jlm-entreprise.fr');
    	$mail->setBody($this->renderView('JLMOfficeBundle:Quote:email.txt.twig', array('intro' => $entity->getIntro())));
    	if ($entity->getContact())
    		if ($entity->getContact()->getPerson())
    			if ($entity->getContact()->getPerson()->getEmail())
    				$mail->setTo($entity->getContact()->getPerson()->getEmail());
        $form   = $this->createForm(new MailType(), $mail);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }
    
    
	/**
     * Given a Quote entity.
     *
     * @Route("/{id}/given", name="quote_given")
     * @Secure(roles="ROLE_USER")
     */
    public function givenAction(Request $request, Quote $entity)
    {
    	if (!$entity->isSend() || !$entity->isValid())
    		return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getId())));
    	$entity->setGiven();
    	$em = $this->getDoctrine()->getEntityManager();
    	$em->persist($entity);
    	$em->flush();
    	return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getId())));
    }
    
    /**
     * Deletes a Quote entity.
     *
     * @Route("/{id}/delete", name="quote_delete")
     * @Method("post")
     * @Secure(roles="ROLE_USER")
     */
    public function deleteAction(Request $request, Quote $quote)
    {
        $form = $this->createDeleteForm($quote->getId());
        $form->bind($request);
        if ($form->isValid()) {
            $em->remove($entity);
            $em->flush();
        }
        return $this->redirect($this->generateUrl('quote'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
   /**
    * @Route("/{id}/pdf",name="quote_pdf")
    * @Secure(roles="ROLE_USER")
     */
   public function pdfAction(Quote $entity)
   {
	   	if (!$entity->isValid())
	   		return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getId())));
	   	$entity->setSend();
	   	$em = $this->getDoctrine()->getEntityManager();
	   	$em->persist($entity);
	   	$em->flush();
   	
    //    $content = $entity->getPDF();
	   	
	   	
	   	
        $response = new Response();
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'inline; filename='.$entity->getNumber().'.pdf');
        $response->setContent($this->render('JLMOfficeBundle:Quote:older.pdf.php',array('entity'=>$entity)));
         
     //   return array('entity'=>$entity);
        return $response;
   }
}

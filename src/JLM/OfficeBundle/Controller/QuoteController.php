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
use JLM\ModelBundle\Entity\Door;
use JLM\OfficeBundle\Entity\Quote;
use JLM\OfficeBundle\Form\Type\QuoteType;
use JLM\OfficeBundle\Entity\QuoteLine;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;



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
     * @Route("/page/{page}/state/{state}", name="quote_state")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function indexAction($page = 1, $state = null)
    {
    	$limit = 20;
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('JLMOfficeBundle:Quote');
        if ($state === null)
        	$nb = $repo->getTotal();
        else
        	$nb = $repo->getCountState($state);
        $nbPages = ceil($nb/$limit);
        $nbPages = ($nbPages < 1) ? 1 : $nbPages;
        $offset = ($page-1) * $limit;
        if ($page < 1)
        	$page = 1;
        elseif ($page > $nbPages)
        	$page = $nbPages;
        
        if ($state === null)
	        $entities = $repo->findBy(
	        		array(),
	        		array('number'=>'desc'),
	        		$limit,
	        		$offset
	        );
        else
        	$entities = $repo->getByState($state,$limit,$offset);
        
        return array(
        		'entities' => $entities,
        		'page'     => $page,
        		'nbPages'  => $nbPages,
        		'state'	   => $state,
        );
    }
    
    /**
     * Lists lasts Quote entities.
     *
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function lastAction($limit = 10)
    {
    	$em = $this->getDoctrine()->getEntityManager();

    	$entities = $em->getRepository('JLMOfficeBundle:Quote')->findBy(
    			array(),
    			array('number'=>'desc'),
    			$limit
    	);
    
    	return array(
    			'entities' => $entities,
    	);
    }
    
    /**
     * sidebar Quote entities.
     *
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function sidebarAction()
    {
    	$em = $this->getDoctrine()->getEntityManager();

    $repo = $em->getRepository('JLMOfficeBundle:Quote');
    	return array(
    			'all' => $repo->getTotal(),
    			'input' => $repo->getCountState(0),
    			'wait' => $repo->getCountState(1),
    			'send' => $repo->getCountState(3),
    			'given' => $repo->getCountState(5),
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
     * @Route("/new/door/{id}", name="quote_new_door")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function newAction(Door $door = null)
    {
    	$user = $this->container->get('security.context')->getToken()->getUser();
    	if (!is_object($user) || !$user instanceof UserInterface) {
    		throw new AccessDeniedException('This user does not have access to this section.');
    	}
        $entity = new Quote();
        $entity->setCreation(new \DateTime);
		$entity->setFollowerCp($user->getPerson()->getName());
		$em = $this->getDoctrine()->getEntityManager();
		$vat = $em->getRepository('JLMModelBundle:VAT')->find(1)->getRate();
		
		if (!empty($door))
		{
			$entity->setDoor($door);
			$entity->setDoorCp($door->toString().' - '.$door.'');
			$contract = $door->getActualContract();
			$trustee = (empty($contract)) ? $door->getSite()->getTrustee() : $contract->getTrustee();		
			$entity->setTrustee($trustee);
			$entity->setTrusteeName($trustee->getName());
			$entity->setTrusteeAddress($trustee->getAddress().'');
			$entity->setVat($door->getSite()->getVat()->getRate());
		}
		else
		{
			$entity->setVat($vat);
		}
      //  $entity->addLine(new QuoteLine);
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
    	if ($entity->getState())
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
     * Resultats de la barre de recherche.
     *
     * @Route("/search", name="quote_search")
     * @Method("post")
     * @Secure(roles="ROLE_USER")
     * @Template()
     */
    public function searchAction(Request $request)
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	$query = $request->request->get('query');
    	$results = $em->getRepository('JLMOfficeBundle:Quote')->search($query);
    	if (sizeof($results) == 1)
    		return $this->redirect($this->generateUrl('quote_show', array('id' => $results[0]->getId())));
    	return array(
    		'query'   => $query,
    		'results' => $results,
    	);
    }
    
    /**
     * Imprimer toute les variantes
     *
     * @Route("/{id}/print", name="quote_print")
     * @Secure(roles="ROLE_USER")
     */
    public function printAction(Quote $entity)
    {
    	$response = new Response();
    	$response->headers->set('Content-Type', 'application/pdf');
    	$response->headers->set('Content-Disposition', 'inline; filename='.$entity->getNumber().'.pdf');
    	$response->setContent($this->render('JLMOfficeBundle:Quote:quote.pdf.php',array('entities'=>$entity->getVariants())));
    		
    	//   return array('entity'=>$entity);
    	return $response;
    }
    
    /**
     * Imprimer la chemise
     *
     * @Route("/{id}/jacket", name="quote_jacket")
     * @Secure(roles="ROLE_USER")
     */
    public function jacketAction(Quote $entity)
    {
    	$response = new Response();
    	$response->headers->set('Content-Type', 'application/pdf');
    	$response->headers->set('Content-Disposition', 'inline; filename='.$entity->getNumber().'.pdf');
    	$response->setContent($this->render('JLMOfficeBundle:Quote:jacket.pdf.php',array('entity'=>$entity)));
    
    	//   return array('entity'=>$entity);
    	return $response;
    }
    
    /**
     * Mail
     * @Route("/{id}/mail", name="quote_mail")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function mailAction(Quote $entity)
    {
    	if ($entity->getState() < 1)
    		return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getQuote()->getId())));
    	$mail = new Mail();
    	$mail->setSubject('Devis n°'.$entity->getNumber());
    	$mail->setFrom('commerce@jlm-entreprise.fr');
    	$mail->setBody($this->renderView('JLMOfficeBundle:Quote:email.txt.twig', array('door' => $entity->getDoorCp())));
    	$mail->setSignature($this->renderView('JLMOfficeBundle:Variant:emailsignature.txt.twig', array('name' => $entity->getFollowerCp())));
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
     * Send by mail a QuoteVariant entity.
     *
     * @Route("/{id}/sendmail", name="quote_sendmail")
     * @Method("post")
     * @Secure(roles="ROLE_USER")
     */
    public function sendmailAction(Request $request, Quote $entity)
    {
    	if ($entity->getState() < 1)
    		return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getId())));
    
    	// Message
    	$mail = new Mail;
    	$form = $this->createForm(new MailType(), $mail);
    	$form->bind($request);
    		
    	if ($form->isValid()) {
    		$mail->setBcc('commerce@jlm-entreprise.fr');
    			
    		$message = $mail->getSwift();
    		$message->setReadReceiptTo('commerce@jlm-entreprise.fr');
    		foreach ($entity->getVariants() as $variant)
    			if ($variant->getState() > 0)
    			{
		    		$message->attach(\Swift_Attachment::newInstance(
		    				$this->render('JLMOfficeBundle:Quote:quote.pdf.php',array('entities'=>array($variant))),
		    				$variant->getNumber().'.pdf','application/pdf'
		    		))
		    		;
		    		if ($variant->getState() < 3)
		    			$variant->setState(3);
    			}
    			if ($entity->getVat() == $entity->getVatTransmitter())
    				$message->attach(\Swift_Attachment::fromPath(
						$this->get('kernel')->getRootDir().'/../web/bundles/jlmoffice/pdf/attestation.pdf'
				));
    
    		$this->get('mailer')->send($message);
    		$em = $this->getDoctrine()->getEntityManager();
    		$em->persist($entity);
    		$em->flush();
    	}
    	return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getId())));
    }
}

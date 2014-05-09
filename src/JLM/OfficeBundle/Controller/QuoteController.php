<?php

namespace JLM\OfficeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\DefaultBundle\Entity\Search;
use JLM\DefaultBundle\Form\Type\SearchType;
use JLM\ModelBundle\Entity\Mail;
use JLM\ModelBundle\Form\Type\MailType;
use JLM\ModelBundle\Entity\Door;
use JLM\OfficeBundle\Entity\Quote;
use JLM\OfficeBundle\Entity\AskQuote;
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
    private $response;
    
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
    	
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('JLMOfficeBundle:Quote');
        list($return, $response) = $this->_cacheLastModified($repo);
        $c = $this->getRequest()->cookies->all();
        var_dump($c);
        // $i = $this->get('session')->all();
        // var_dump(unserialize($i['_security_main'])); exit;
        if ($return)
        {
            return $response;
        }
        
        $limit = 20;
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
        	$entities = $repo->getAll($limit,$offset);
        else
        	$entities = $repo->getByState($state,$limit,$offset);
        
        return $this->render('JLMOfficeBundle:Quote:index.html.twig',array(
        		'entities' => $entities,
        		'page'     => $page,
        		'nbPages'  => $nbPages,
        		'state'	   => $state,
        ),$response);
    }
    
    private function _cacheLastModified($repo)
    {
        // Vérification du cache
        $lastModified = $repo->getLastModified();
        $response = new Response;
        $response->setLastModified($lastModified);
        $response->setPublic();
        return array($response->isNotModified($this->getRequest()),$response);
    }
    
    /**
     * Lists lasts Quote entities.
     * @Secure(roles="ROLE_USER")
     */
    public function lastAction($limit = 10)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('JLMOfficeBundle:Quote');
    	list($return, $response) = $this->_cacheLastModified($repo);
    	if ($return)
    	{
    	    return $response;
    	}
    	
    	$entities = $repo->findBy(
    			array(),
    			array('number'=>'desc'),
    			$limit
    	);
    
    	return $this->render('JLMOfficeBundle:Quote:last.html.twig',array('entities' => $entities), $response);
    }
    
    /**
     * sidebar Quote entities.
     * @Secure(roles="ROLE_USER")
     */
    public function sidebarAction()
    {
        
    	$em = $this->getDoctrine()->getManager();
    	$repo = $em->getRepository('JLMOfficeBundle:Quote');
    	
        list($return, $response) = $this->_cacheLastModified($repo);
    	if ($return)
    	{
    	    return $response;
    	}
    	
    	// Calcul
    	$date = new \DateTime;
    	$year = $date->format('Y');
    	return $this->render('JLMOfficeBundle:Quote:sidebar.html.twig',array('count' => array(
    			'all' => $repo->getCountState('uncanceled', $year),
    			'input' => $repo->getCountState(0, $year),
    			'wait' => $repo->getCountState(1, $year),
    			'send' => $repo->getCountState(3, $year),
    			'given' => $repo->getCountState(5, $year),
    	)),$response);
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
     * Nouveau devis depuis un demande de devis
     * 
     * @Route("/new/fromask/{id}", name="quote_newfromask")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function newAction(AskQuote $askquote)
    {
    	$user = $this->container->get('security.context')->getToken()->getUser();
    	if (!is_object($user) || !$user instanceof UserInterface) {
    		throw new AccessDeniedException('This user does not have access to this section.');
    	}
    	$em = $this->getDoctrine()->getManager();
    	$vat = $em->getRepository('JLMModelBundle:VAT')->find(1)->getRate();
    	$entity = Quote::createFromAskQuote($askquote);
    	$entity->setFollowerCp($user->getPerson()->getName());
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
            $em = $this->getDoctrine()->getManager();
            $lastNumber = $em->getRepository('JLMOfficeBundle:Quote')->getLastNumber();
            $entity->generateNumber($lastNumber);
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
        	$em = $this->getDoctrine()->getManager();
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
    	$entity = new Search;
    	$form = $this->createForm(new SearchType(), $entity);
    	$form->handleRequest($request);
    	if ($form->isValid())
    	{
    		$em = $this->getDoctrine()->getManager();
    		return array(
    				'layout'=> array('form_search_query'=>$entity),
    				'results' => $em->getRepository('JLMOfficeBundle:Quote')->search($entity),
    				'query' => $entity->getQuery(),
    		);
    	}
    	return array('layout'=>array('form_search_query'=>$entity),'query' => $entity->getQuery(),);
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
    		$em = $this->getDoctrine()->getManager();
    		$em->persist($entity);
    		$em->flush();
    	}
    	return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getId())));
    }
}

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

use FOS\UserBundle\Model\UserInterface;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\CommerceBundle\Entity\QuoteLine;
use JLM\CommerceBundle\Entity\Quote;
use JLM\CommerceBundle\Form\Type\QuoteType;
use JLM\CommerceBundle\Model\QuoteInterface;
use JLM\DefaultBundle\Entity\Search;
use JLM\DefaultBundle\Form\Type\SearchType;
use JLM\ModelBundle\Entity\Door;
use JLM\ModelBundle\Entity\Mail;
use JLM\ModelBundle\Form\Type\MailType;
use JLM\OfficeBundle\Entity\AskQuote;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Quote controller.
 *
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class QuoteController extends Controller
{
    /**
     * Lists all Quote entities.
     */
    public function indexAction($state = null)
    {
    	$manager = $this->container->get('jlm_commerce.quote_manager');
    	$manager->secure('ROLE_USER');
    	$request = $manager->getRequest();
    	$page = $request->get('page', 1);
    	$limit = $request->get('limit', 20);
    	$state = $request->get('state', null);
        $repo = $manager->getRepository();
        $nb = ($state === null) ? $repo->getTotal() : $repo->getCountState($state);
        $nbPages = ceil($nb/$limit);
        $nbPages = ($nbPages < 1) ? 1 : $nbPages;
        $offset = ($page-1) * $limit;
        
       	$page = ($page > $nbPages) ? $nbPages : $page;
        $entities = ($state === null) ? $repo->getAll($limit,$offset) : $repo->getByState($state,$limit,$offset);
 
        return $manager->renderResponse('JLMCommerceBundle:Quote:index.html.twig', 
        	array(
        		'entities' => $entities,
        		'page'     => $page,
        		'nbPages'  => $nbPages,
        		'state'	   => $state,
        ));
    }

    /**
     * Finds and displays a Quote entity.
     */
    public function showAction($id)
    {
    	$manager = $this->container->get('jlm_commerce.quote_manager');
    	$manager->secure('ROLE_USER');
    	
        return $manager->renderResponse('JLMCommerceBundle:Quote:show.html.twig', 
        		array('entity'=> $manager->getEntity($id))
        );
    }
    
    /**
     * Nouveau devis depuis un demande de devis
     * 
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
    	$vat = $em->getRepository('JLMCommerceBundle:VAT')->find(1)->getRate();
    	$entity = Quote::createFromAskQuote($askquote);
    	$entity->setFollowerCp($user->getContact()->getName());
    	$entity->setVatTransmitter($vat);
    	
    	$form   = $this->createNewForm($entity);
    
    	return array(
    			'entity' => $entity,
    			'form'   => $form->createView()
    	);
    }

    /**
     * Creates a new Quote entity.
     *
     * @Template("JLMCommerceBundle:Quote:new.html.twig")
     * @Secure(roles="ROLE_USER")
     */
    public function createAction(Request $request)
    {
        $entity  = new Quote();
        $form    = $this->createNewForm($entity);
        $form->handleRequest($request);
		
        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $lastNumber = $em->getRepository('JLMCommerceBundle:Quote')->getLastNumber();
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
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function editAction(Quote $entity)
    {
    	// Si le devis est déjà validé, on empèche quelconque modification
    	if ($entity->getState())
    	{
    		return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getId())));
    	}
        $editForm = $this->createEditForm($entity);
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Quote entity.
     *
     * @Template("JLMCommerceBundle:Quote:edit.html.twig")
     * @Secure(roles="ROLE_USER")
     */
    public function updateAction(Request $request, Quote $entity)
    {
    	
    	// Si le devis est déjà validé, on empèche quelconque modification
    	if ($entity->getState())
    	{
    		return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getId())));
    	}
    	 
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);
        
        if ($editForm->isValid())
        {
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
     * @Secure(roles="ROLE_USER")
     */
    public function deleteAction(Request $request, Quote $quote)
    {
        $form = $this->createDeleteForm($quote->getId());
        $form->handleRequest($request);
        if ($form->isValid())
        {
        	$em = $this->getDoctrine()->getManager();
            $em->remove($quote);
            $em->flush();
        }
        
        return $this->redirect($this->generateUrl('quote'));
    }

    /**
     * Create a delete form
     * @param unknown $id
     * @return \Symfony\Component\Form\Form
     */
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
     * @Secure(roles="ROLE_USER")
     * @Template()
     */
    public function searchAction(Request $request)
    {
    	$formData = $request->get('jlm_core_search');
    	
    	if (is_array($formData) && array_key_exists('query', $formData))
    	{
    		$em = $this->getDoctrine()->getManager();
    		$entity = new Search();
    		$query = $formData['query'];
    		$entity->setQuery($query);
    		return array(
    				'results' => $em->getRepository('JLMCommerceBundle:Quote')->search($entity),
    				'query' => $entity->getQuery(),
    		);
    	}
    	
    	return array();
    }
    
    /**
     * Imprimer toute les variantes
     * 
     * @Secure(roles="ROLE_USER")
     */
    public function printAction(Quote $entity)
    {
    	$response = new Response();
    	$response->headers->set('Content-Type', 'application/pdf');
    	$response->headers->set('Content-Disposition', 'inline; filename='.$entity->getNumber().'.pdf');
    	$response->setContent($this->render('JLMCommerceBundle:Quote:quote.pdf.php',array('entities'=>$entity->getVariants())));
    		
    	//   return array('entity'=>$entity);
    	return $response;
    }
    
    /**
     * Imprimer la chemise
     *
     * @Secure(roles="ROLE_USER")
     */
    public function jacketAction(Quote $entity)
    {
    	$response = new Response();
    	$response->headers->set('Content-Type', 'application/pdf');
    	$response->headers->set('Content-Disposition', 'inline; filename='.$entity->getNumber().'.pdf');
    	$response->setContent($this->render('JLMCommerceBundle:Quote:jacket.pdf.php',array('entity'=>$entity)));
    
    	//   return array('entity'=>$entity);
    	return $response;
    }
    
    /**
     * Mail
     * 
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
    	$mail->setBody($this->renderView('JLMCommerceBundle:Quote:email.txt.twig', array('door' => $entity->getDoorCp())));
    	$mail->setSignature($this->renderView('JLMCommerceBundle:QuoteVariant:emailsignature.txt.twig', array('name' => $entity->getFollowerCp())));
    	if ($entity->getContact())
    	{
    		if ($entity->getContact()->getPerson())
    		{
    			if ($entity->getContact()->getPerson()->getEmail())
    			{
    				$mail->setTo($entity->getContact()->getPerson()->getEmail());
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
    public function sendmailAction(Request $request, Quote $entity)
    {
    	if ($entity->getState() < 1)
    	{
    		return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getId())));
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
    		foreach ($entity->getVariants() as $variant)
    			if ($variant->getState() > 0)
    			{
		    		$message->attach(\Swift_Attachment::newInstance(
		    				$this->render('JLMCommerceBundle:Quote:quote.pdf.php',array('entities'=>array($variant))),
		    				$variant->getNumber().'.pdf','application/pdf'
		    		))
		    		;
		    		if ($variant->getState() < 3)
		    		{
		    			$variant->setState(3);
		    		}
    			}
    			if ($entity->getVat() == $entity->getVatTransmitter())
    			{
    				$message->attach(\Swift_Attachment::fromPath(
						$this->get('kernel')->getRootDir().'/../web/bundles/jlmcommerce/pdf/attestation.pdf'
					));
    			}
    
    		$this->get('mailer')->send($message);
    		$em = $this->getDoctrine()->getManager();
    		$em->persist($entity);
    		$em->flush();
    	}
    	return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getId())));
    }
    
    /**
     * Create a new form
     * 
     * @param Quote $entity
     * @return \Symfony\Component\Form\Form
     */
    private function createNewForm(Quote $entity)
    {
    	return $this->createForm(new QuoteType(), $entity);
    }
    
    /**
     * Create an edit form
     * @param Quote $entity
     * @return \Symfony\Component\Form\Form
     */
    private function createEditForm(Quote $entity)
    {
    	return $this->createForm(new QuoteType(), $entity);
    }
}

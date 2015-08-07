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

use Symfony\Component\DependencyInjection\ContainerAware;
use JLM\CoreBundle\Form\Type\MailType;
use JLM\CommerceBundle\JLMCommerceEvents;
use JLM\CommerceBundle\Event\QuoteEvent;
use JLM\CommerceBundle\Entity\Event;
use JLM\CommerceBundle\Entity\Quote;
use Symfony\Component\HttpFoundation\Request;
use JLM\CoreBundle\Factory\MailFactory;
use JLM\CommerceBundle\Builder\Email\QuoteSendMailBuilder;
use JLM\CommerceBundle\Event\QuoteVariantEvent;

/**
 * Quote controller.
 *
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class QuoteController extends ContainerAware
{
    /**
     * Lists all Quote entities.
     */
    public function indexAction()
    {
    	$manager = $this->container->get('jlm_commerce.quote_manager');
    	$manager->secure('ROLE_USER');
    	$states = array(
    			'all' => 'All',
    			'in_seizure' => 'InSeizure',
    			'waiting' => 'Waiting',
    			'sended' => 'Sended',
    			'given' => 'Given',
    			'canceled' => 'Canceled'
    	);
    	$state = $manager->getRequest()->get('state');
    	$state = (!array_key_exists($state, $states)) ? 'all' : $state;
    	$views = array('index'=>'Liste','follow'=>'Suivi');
    	$view = $manager->getRequest()->get('view');
    	$view = (!array_key_exists($view, $views)) ? 'index' : $view;
    	
    	$method = $states[$state];
    	
    	return $manager->renderResponse('JLMCommerceBundle:Quote:'.$view.'.html.twig',
    			$manager->pagination('getCount'.$method, 'get'.$method, 'quote', array('state' => $state, 'view' => $view))
    	);
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
     * Nouveau devis
     */
    public function newAction(Request $request)
    {
    	$manager = $this->container->get('jlm_commerce.quote_manager');
    	$manager->secure('ROLE_USER');
    	$form = $manager->createForm('new');
    	$form->handleRequest($request);
    	if ($form->isValid())
    	{
    		$entity = $form->getData();
    		$manager->dispatch(JLMCommerceEvents::QUOTE_AFTER_PERSIST, new QuoteEvent($entity, $manager->getRequest()));
    	
    		return $manager->redirect('quote_show', array('id' => $form->getData()->getId()));
    	}
    	
    	return $manager->renderResponse('JLMCommerceBundle:Quote:new.html.twig', array(
    			'form'   => $form->createView()
    	));
    }

    /**
     * Displays a form to edit an existing Quote entity.
     */
    public function editAction(Request $request, $id)
    {
    	$manager = $this->container->get('jlm_commerce.quote_manager');
    	$manager->secure('ROLE_USER');
    	$entity = $manager->getEntity($id);
    	$manager->assertState($entity, array(0));
    	$form = $manager->createForm('edit', array('entity' => $entity));
    	$form->handleRequest($request);
    	
    	return $form->isValid()
    		? $manager->redirect('quote_show', array('id' => $form->getData()->getId()))
    		: $manager->renderResponse('JLMCommerceBundle:Quote:edit.html.twig', array(
	            'entity'      => $entity,
	            'edit_form'   => $form->createView(),
	        ));
    }
     
    /**
     * Resultats de la barre de recherche.
     */
    public function searchAction()
    {
    	$manager = $this->container->get('jlm_commerce.quote_manager');
    	$manager->secure('ROLE_USER');
    	
    	return $manager->renderSearch('JLMCommerceBundle:Quote:search.html.twig');
    }
    
    /**
     * Imprimer toute les variantes
     */
    public function printAction($id)
    {
    	$manager = $this->container->get('jlm_commerce.quote_manager');
    	$manager->secure('ROLE_USER');
    	$entity = $manager->getEntity($id);
    	$filename = $entity->getNumber().'.pdf';
    	
    	return $manager->renderPdf($filename, 'JLMCommerceBundle:Quote:quote.pdf.php', array('entities'=>array($entity->getVariants())));
    }
    
    /**
     * Imprimer la chemise
     */
    public function jacketAction($id)
    {
    	$manager = $this->container->get('jlm_commerce.quote_manager');
    	$manager->secure('ROLE_USER');
    	$entity = $manager->getEntity($id);
    	$filename = $entity->getNumber().'-jacket.pdf';
    	 
    	return $manager->renderPdf($filename, 'JLMCommerceBundle:Quote:jacket.pdf.php',array('entity'=>$entity));
    }
    
    /**
     * Mail
     */
    public function sendByMailAction(Request $request, $id)
    {
    	$manager = $this->container->get('jlm_commerce.quote_manager');
    	$manager->secure('ROLE_USER');
    	$entity = $manager->getEntity($id);
    	$manager->assertState($entity, array(1,2,3,4,5));
    	$form = $manager->getFormFactory()->create('jlm_core_mail', MailFactory::create(new QuoteSendMailBuilder($entity)));
    	$form->handleRequest($request);
    	 
    	if ($form->isValid())
    	{
    		$variants = $entity->getSendableVariants();
    		foreach ($variants as $variant)
    		{
    			$manager->dispatch(JLMCommerceEvents::QUOTEVARIANT_SENDED, new QuoteVariantEvent($variant, $request));
    		}
    		
    		return $manager->redirect('quote_show', array('id' => $entity->getId()));
    	}
    	
    	return $manager->renderResponse('JLMCommerceBundle:Quote:mail.html.twig', array(
    			'entity' => $entity,
    			'form'   => $form->createView()
    	));
    }
}

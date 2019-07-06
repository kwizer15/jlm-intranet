<?php

namespace JLM\FrontBundle\Controller;

class DefaultController extends Controller
{    
    public function contactAction()
    {
    	$request = $this->getRequest();
    	
    	$form = $this->createForm('jlm_front_contacttype', null, array(
    			'action' => $this->generateUrl('jlm_front_contact'),
    			'method' => 'POST',
    	));
    	$form->add('submit','submit');
    	$form->handleRequest($request);
    	 
    	if ($form->isValid())
    	{
    		$mailer = $this->container->get('jlm_front.mailer'); 
    		$mailer->sendContactEmailMessage($form->getData());
    		$mailer->sendConfirmContactEmailMessage($form->getData());
    		
    		return $this->render('JLMFrontBundle:Default:contact_confirm.html.twig');
    	}
    	
    	return $this->render('JLMFrontBundle:Default:contact.html.twig', array(
    			'form' => $form->createView(),
    	));
    }
    
    public function installationAction($code)
    {
    	$em = $this->getDoctrine()->getManager();
    
    	$entity = $em->getRepository('JLMModelBundle:Door')->getByCode($code);
    	if ($entity === null)
    	{
    		throw $this->createNotFoundException('Cette installation n\'existe pas');
    	}
    
    	return $this->render('JLMFrontBundle:Default:installation.html.twig',array('door'=>$entity));
    }
}

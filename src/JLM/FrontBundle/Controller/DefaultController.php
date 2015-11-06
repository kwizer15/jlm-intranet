<?php

/*
 * This file is part of the JLMFrontBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
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
    		$this->container->get('jlm_front.mailer')->sendContactEmailMessage($form->getData());
    		$this->container->get('jlm_front.mailer')->sendConfirmContactEmailMessage($form->getData());
    		return $this->render('JLMFrontBundle:Default:contact_confirm.html.twig');
    	}
    	
    	return $this->render('JLMFrontBundle:Default:contact.html.twig', array(
    			'form' => $form->createView(),
    	));
    }
    
    public function installationAction($code)
    {
    	$em = $this->getDoctrine()->getManager();
    
    	$entity = $em->getRepository('JLMFrontBundle:Door')->getByCode($code);
    	if ($entity === null)
    	{
    		throw $this->createNotFoundException('Cette installation n\'existe pas');
    	}
    
    	return $this->render('JLMFrontBundle:Default:installation.html.twig',array('door'=>$entity));
    }
}

<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ContactBundle\Manager;

use JLM\ContactBundle\Form\Type\PersonType;
use JLM\ContactBundle\Form\Type\CompanyType;
use JLM\ContactBundle\Form\Type\AssociationType;
use JLM\ContactBundle\Entity\Person;
use JLM\ContactBundle\Entity\Company;
use JLM\ContactBundle\Entity\Association;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use JLM\CoreBundle\Form\Handler\DoctrineHandler;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class ContactManager
{
	protected $class;
	
	protected $om;
	
	protected $request;
	
    public function __construct($class)
    {
    	$this->class = $class;
    }
    
    public function setServices()
    {
    	$this->om = $this->container->get('doctrine')->getManager();
    	$this->request = $this->container->get('request');
    }
    
    public function createForm($method, $entity)
    {
    	$url = '';
    	$type = $entity->getType();
    	switch ($method)
    	{
    		case 'POST':
    			$url = $this->generateUrl('jlm_contact_contact_new', array('id' => $type));
    			break;
    		case 'PUT':
    			$url = $this->generateUrl('jlm_contact_contact_edit', array('id' => $entity->getId()));
    			break;
    		default:
    			throw new LogicException('HTTP request method must be POST or PUT only');
    	}
    		
    	$form = $this->container->get('form.factory')->create($this->getFormType($type), $entity,
    			array(
    					'action' => $url,
    					'method' => $method,
    			)
    	);
    	$form->add('submit','submit',array('label'=>'Enregistrer'));
    
    	return $form;
    }
    
    public function getRepository()
    {
    	return $this->om->getRepository('JLMContactBundle:CorporationContact');
    	return $this->om->getRepository($this->class);	// A tester
    }
    
    public function getObjectManager()
    {
    	return $this->om;
    }
    
    public function getNewEntity($type)
    {
    	switch ($type)
    	{
    		case 'person':
    			return new Person();
    		case 'company':
    			return new Company();
    		case 'association':
    			return new Association();
    	}
    
    	return null;
    }
    
    public function getEntity($id)
    {
    	$entity = $this->getRepository()->find($id);
    	if (!$entity)
    	{
    		throw $this->createNotFoundException('Unable to find Contact entity.');
    	}
    
    	return $entity;
    }
    
    public function getFormType($type)
    {
    	switch ($type)
    	{
    		case 'person':
    			return new PersonType();
    		case 'company':
    			return new CompanyType();
    		case 'association':
    			return new AssociationType();
    	}
    	 
    	return null;
    }
    
    public function renderResponse($view, array $parameters = array(), Response $response = null)
    {
    	return $this->container->get('templating')->renderResponse($view, $parameters, $response);
    }
    
    public function redirect($url, $status = 302)
    {
    	return new RedirectResponse($url, $status);
    }
    
    public function redirectReferer()
    {
    	return new RedirectResponse($this->request->headers->get('referer'));
    }
    
    public function getSession()
    {
    	return $this->container->get('session');
    }
    
    public function getHandler($form, $entity)
    {
    	return new DoctrineHandler($form, $this->request, $this->om, $entity);
    }
    
    public function getRequest()
    {
    	return $this->request;
    }
    
    public function getRouter()
    {
    	return $this->container->get('router');
    }
}
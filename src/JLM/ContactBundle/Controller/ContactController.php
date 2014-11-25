<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ContactBundle\Controller;

use JLM\ContactBundle\Entity\ContactPhone;
use JLM\ContactBundle\Form\Handler\DoctrineHandler;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Form\Exception\LogicException;
use JLM\ContactBundle\Entity\Contact;
use JLM\ContactBundle\Entity\Person;
use JLM\ContactBundle\Entity\Company;
use JLM\ContactBundle\Entity\Association;
use JLM\ContactBundle\Form\Type\PersonType;
use JLM\ContactBundle\Form\Type\CompanyType;
use JLM\ContactBundle\Form\Type\AssociationType;

/**
 * Person controller.
 */
class ContactController extends Controller
{
	/**
	 * Edit or add a contact
	 * @param int|string $id The entity identifier or typeof new entity
	 */
	public function editAction($id)
	{
		if ($id == 'person' || $id == 'company' || $id == 'association')
		{
			$type = $id;
			$id = 0;
			$entity = $this->getNewEntity($type);
			$entity->addPhone(new ContactPhone());
			$method = 'POST';
		}
		else
		{
			$entity = $this->getEntity($id);
			$method = 'PUT';
		}

		$form = $this->createContactForm($method, $entity);
		$request = $this->container->get('request');
		$em = $this->container->get('doctrine')->getManager();
		$handler = new DoctrineHandler($form, $request, $em);
	
		if ($handler->process($method))
		{
			$router = $this->container->get('router');
			$url = $router->generate('jlm_contact_contact_show', array('id'=>$entity->getId()));
			 
			return new RedirectResponse($url);
		}
	
		return $this->render('JLMContactBundle:Contact:new.html.twig', array('form'=>$form->createView(), 'c'=>$entity));
	}
	
	private function createContactForm($method, Contact $entity)
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
	
	public function listAction()
	{
		$em = $this->get('doctrine')->getManager();
		$repo = $em->getRepository('JLMContactBundle:Contact');
		$entities = $repo->findAll();
		
		return $this->render('JLMContactBundle:Contact:list.html.twig', array('entities'=>$entities));
	}
    
    public function showAction($id)
    {
        $entity = $this->getEntity($id);
        
        return $this->render('JLMContactBundle:Contact:show.html.twig', array('entity'=>$entity));
    }
    
    public function unactiveAction($id)
    {
    	$entity = $this->getEntity($id);
    	$entity->setActive(false);
    	
    	$em = $this->get('doctrine')->getManager();
    	$em->persist($entity);
    	$em->flush();
    	
    	$this->get('session')->setFlash('notice', 'Contact '.$entity->getName().' désactivé');
    	
    	return $this->redirect($this->get('request')->headers->get('referer'));
    }
    
    private function getEntity($id)
    {
        $em = $this->container->get('doctrine')->getManager();
        $entity = $em->getRepository('JLMContactBundle:Contact')->find($id);
        if (!$entity)
        {
            throw $this->createNotFoundException('Unable to find Contact entity.');
        }
    
        return $entity;
    }
    
    /**
     * 
     * @param string $type
     * @return \JLM\ContactBundle\Form\Type\AbstractType| null
     */
    private function getFormType($type)
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
    
    /**
     * 
     * @param string $type
     * @return Contact
     */
    private function getNewEntity($type)
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
}
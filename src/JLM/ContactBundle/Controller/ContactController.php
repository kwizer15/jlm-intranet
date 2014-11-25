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
use JLM\ContactBundle\Entity\Person;
use JLM\ContactBundle\Form\Handler\DoctrineHandler;
use JLM\ContactBundle\Form\Type\PersonType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Form\Exception\LogicException;

/**
 * Person controller.
 */
class ContactController extends Controller
{
    /**
     * Edit or add a contact
     * @param int $id The entity identifier (0 for a new entity)
     */
    public function editAction($id = 0)
    {
        $entity = new Person();
        $entity->addPhone(new ContactPhone());
        $method = 'POST';
        if ($id)
        {
        	$entity = $this->getEntity($id);
        	$method = 'PUT';
        }
        
        $form = $this->createPersonForm($method, $entity);
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
    
    private function createPersonForm($method, Person $entity)
    {
    	$url = '';
    	switch ($method)
    	{
    		case 'POST':
    			$url = $this->generateUrl('jlm_contact_contact_new');
    			break;
    		case 'PUT':
    			$url = $this->generateUrl('jlm_contact_contact_edit', array('id' => $entity->getId()));
    			break;
    		default:
    			throw new LogicException('HTTP request method must be POST or PUT only');
    	}
    	
        $form = $this->container->get('form.factory')->create(new PersonType(), $entity,
            array(
                'action' => $url,
                'method' => $method,
            )
        );
        $form->add('submit','submit',array('label'=>'Enregistrer'));
        
        return $form;
    }
}
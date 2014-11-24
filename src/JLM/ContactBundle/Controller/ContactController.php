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

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\ContactBundle\Manager\ContactManager;
use JLM\ContactBundle\Form\Type\PersonType;
use JLM\ContactBundle\Entity\Person;
use JLM\ContactBundle\Entity\CorporationContact;
use JLM\ModelBundle\Entity\Technician;
use JLM\ContactBundle\Entity\Phone;
use Symfony\Component\HttpFoundation\RedirectResponse;
use JLM\ContactBundle\Entity\ContactPhone;
use JLM\ContactBundle\Form\Handler\ContactNewHandler;

/**
 * Person controller.
 */
class ContactController extends Controller
{
    /**
     * Create a new contact
     */
    public function newAction()
    {
        $request = $this->container->get('request');
        
        $entity = new Person();
        $entity->addPhone(new ContactPhone());
        $form = $this->createNewForm($entity);

        $em = $this->container->get('doctrine')->getManager();
        
        $handler = new ContactNewHandler($form, $request, $em);
        if ($handler->process('POST'))
        {
        	$router = $this->container->get('router');
        	$url = $router->generate('jlm_contact_contact_show', array('id'=>$entity->getId()));
        	
        	return new RedirectResponse($url);
        }
        
        return $this->render('JLMContactBundle:Contact:new.html.twig', array('form'=>$form->createView(), 'c'=>$entity));
    }
    
    /**
     * Create a new contact
     */
    public function editAction($id)
    {
        $request = $this->container->get('request');
    
        $entity = $this->getEntity($id);
        $originalPhones = array();
        foreach ($entity->getPhones() as $phone)
        {
            $originalPhones[] = $phone;
        }
        $form = $this->createEditForm($entity);
        
//        $handler = new ContactEditHandler($form, $request, $em);
//        if ($handler->process('PUT'))
//        {
//        	$router = $this->container->get('router');
//        	$url = $router->generate('jlm_contact_contact_show', array('id'=>$entity->getId()));
//        	
//        	return new RedirectResponse($url);
//        }
        $form->handleRequest($request);
        if ($request->getMethod() == 'PUT')
        {
            if ($form->isValid())
            {
                $em = $this->container->get('doctrine')->getManager();
                $em->persist($entity);
                $phones = $entity->getPhones();
                foreach ($phones as $key => $phone)
                {
                	$phone->setContact($entity);
                	$em->persist($phone->getPhone());	// Persist Phone
                	$em->persist($phone);				// Persist ContactPhone
                    foreach ($originalPhones as $key => $toDel)
                    {
                        if ($toDel->getId() === $phone->getId())
                        {
                            unset($originalPhones[$key]);
                        }
                    }
                }
                foreach ($originalPhones as $phone)
                {
                    $em->remove($phone);
                    $em->remove($phone->getPhone());
                } 
                
                $em->flush();
                $router = $this->container->get('router');
                $url = $router->generate('jlm_contact_contact_show', array('id'=>$entity->getId()));
    
                return new RedirectResponse($url);
            }
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
    
    private function createNewForm(Person $entity)
    {
        $form = $this->container->get('form.factory')->create(new PersonType(), $entity,
            array(
                'action' => $this->generateUrl('jlm_contact_contact_new'),
                'method' => 'POST',
            )
        );
        $form->add('submit','submit',array('label'=>'Enregistrer'));
        
        return $form;
    }
    
    private function createEditForm(Person $entity)
    {
        $form = $this->container->get('form.factory')->create(new PersonType(), $entity,
            array(
                'action' => $this->generateUrl('jlm_contact_contact_edit', array('id'=>$entity->getId())),
                'method' => 'PUT',
            )
        );
        $form->add('submit','submit',array('label'=>'Enregistrer'));
    
        return $form;
    }
}
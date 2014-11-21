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
        $entity->addPhone(new Phone());
        $form = $this->createNewForm($entity);
        $form->handleRequest($request);
        if ($request->getMethod() == 'POST')
        {
            if ($form->isValid())
            {
                $em = $this->container->get('doctrine')->getManager();
                $phones = $entity->getPhones();
                foreach ($phones as $phone)
                {
                    $em->persist($phone);
                }
                $em->persist($entity);
                $em->flush();
                $router = $this->container->get('router');
                $url = $router->generate('jlm_contact_contact_show', array('id'=>$entity->getId()));
                
                return new RedirectResponse($url);
            }
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
        $form->handleRequest($request);
        if ($request->getMethod() == 'PUT')
        {
            if ($form->isValid())
            {
                $em = $this->container->get('doctrine')->getManager();
                
                $phones = $entity->getPhones();
                foreach ($phones as $phone)
                {
                    $em->persist($phone);
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
                } 
                $em->persist($entity);
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
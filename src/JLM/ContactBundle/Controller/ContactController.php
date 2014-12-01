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

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * Person controller.
 */
class ContactController extends ContainerAware
{
	/**
	 * Edit or add a contact
	 * @param int|string $id The entity identifier or typeof new entity
	 */
	public function editAction($id)
	{
		$manager = $this->container->get('jlm_contact.contact_manager');
		$method = ($id == 'person' || $id == 'company' || $id == 'association') ? 'POST' : 'PUT';
		$entity = $manager->getEntity($id);
		$form = $manager->createForm($method, $entity);
		$request = $manager->getRequest();
		$handler = $manager->getHandler($form, $entity); 
	
		if ($request->isXmlHttpRequest())
		{
			if ($handler->process($method))
			{
				$resp = array('ok'=>true);
				return new JsonResponse($resp);
			}
			
			return $manager->renderResponse('JLMContactBundle:Contact:modal_new.html.twig', array('form'=>$form->createView(), 'c'=>$entity));
		}
		
		if ($handler->process($method))
		{
			return $manager->redirect('jlm_contact_contact_show', array('id'=>$entity->getId())); 
		}
	
		return $manager->renderResponse('JLMContactBundle:Contact:new.html.twig', array('form'=>$form->createView(), 'c'=>$entity));
	}
	
	public function listAction()
	{
		$manager = $this->container->get('jlm_contact.contact_manager');
		$entities = $manager->getRepository()->findAll();
		
		return $manager->renderResponse('JLMContactBundle:Contact:list.html.twig', array('entities'=>$entities));
	}
    
    public function showAction($id)
    {
    	$manager = $this->container->get('jlm_contact.contact_manager');
        $entity = $manager->getEntity($id);
        $template = 'JLMContactBundle:Contact:show_'.$entity->getType().'.html.twig';
        
        return $manager->renderResponse($template, array('entity'=>$entity));
    }
    
    public function unactiveAction($id)
    {
    	$manager = $this->container->get('jlm_contact.contact_manager');
    	$entity = $manager->getEntity($id);
    	$entity->setActive(false);
    	
    	$em = $manager->getObjectManager();
    	$em->persist($entity);
    	$em->flush();
    	
    	$manager->getSession()->setFlash('notice', 'Contact '.$entity->getName().' désactivé');
    	
    	return $manager->redirectReferer();
    }
}
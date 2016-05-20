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
		$manager->secure('ROLE_OFFICE');
		if (in_array($id, array('person','company','association'))) {
			$type = $id;
			$id = null;
			$formName = 'new';
			$entity = null;
		}
		else {
			$entity = $manager->getEntity($id);
			$formName = 'edit';
			$type = $entity->getType();
		}
		$form = $manager->createForm($formName, array('type' => $type, 'entity' => $entity));
		$process = $manager->getHandler($form, $entity)->process();
		
		return $manager->getRequest()->isXmlHttpRequest()
			? ($process ? $manager->renderJson(array('ok'=>true))
						: $manager->renderResponse('JLMContactBundle:Contact:modal_new.html.twig', array('form' => $form->createView()))) 
			: ($process ? $manager->redirect('jlm_contact_contact_show', array('id' => $form->getData()->getId()))
			            : $manager->renderResponse('JLMContactBundle:Contact:new.html.twig', array('form' => $form->createView())))
			;
	}
	
	public function listAction()
	{
		$manager = $this->container->get('jlm_contact.contact_manager');
		$manager->secure('ROLE_OFFICE');
		$request = $manager->getRequest();
		$ajax = $manager->getRequest()->isXmlHttpRequest();
		$repo = $manager->getRepository();

		return $ajax ? $manager->renderJson(array('contacts' => $repo->getArray($request->get('q',''), $request->get('page_limit',10))))
		                  : $manager->renderResponse('JLMContactBundle:Contact:list.html.twig', $manager->pagination('getCountAll', 'getAll', 'jlm_contact_contact', array()));
	}
    
    public function showAction($id)
    {
    	$manager = $this->container->get('jlm_contact.contact_manager');
    	$manager->secure('ROLE_OFFICE');
    	$entity = $manager->getEntity($id);
    	
		return $manager->getRequest()->isXmlHttpRequest()
			? $manager->renderJson($manager->getRepository()->getByIdToArray($id))
		    : $manager->renderResponse('JLMContactBundle:Contact:show_' . $entity->getType() . '.html.twig', array('entity'=>$entity));
    }
    
    public function unactiveAction($id)
    {
    	$manager = $this->container->get('jlm_contact.contact_manager');
    	$manager->secure('ROLE_OFFICE');
    	$entity = $manager->getEntity($id);
    	$entity->setActive(false);
    	
    	$em = $manager->getObjectManager();
    	$em->persist($entity);
    	$em->flush();
    	
    	$manager->getSession()->setFlash('notice', 'Contact ' . $entity->getName() . ' désactivé');
    	
    	return $manager->redirectReferer();
    }
}
<?php

/*
 * This file is part of the JLMContractBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ContractBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JLM\ContractBundle\Event\ContractEvent;
use JLM\ContractBundle\JLMContractEvents;
use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class ContractController extends ContainerAware
{
    /**
     * Lists all Contract entities.
     *
     * @deprecated not used
     */
    public function indexAction()
    {
    	$manager = $this->container->get('jlm_contract.contract_manager');
    	$manager->secure('ROLE_USER');
        $entities = $manager->getRepository()->findAll();

        return $manager->renderResponse('JLMContractBundle:Contract:index.html.twig', array('entities' => $entities));
    }

    /**
     * Finds and displays a Contract entity.
     *
     * @Secure(roles="ROLE_USER")
     */
    public function showAction($id)
    {
    	$manager = $this->container->get('jlm_contract.contract_manager');
    	$manager->secure('ROLE_USER');
    	$entity = $manager->getEntity($id);
    	
        return $manager->renderResponse('JLMContractBundle:Contract:show.html.twig', array('entity' => $entity));
    }
    
/**
     * Creates a new Contract entity.
     */
    public function newAction()
    {
    	$manager = $this->container->get('jlm_contract.contract_manager');
    	$manager->secure('ROLE_USER');
    	$form   = $manager->createNewForm();
    	if ($manager->getHandler($form)->process('POST'))
    	{
    		$event = new ContractEvent($form->getData());
    		$manager->dispatch(JLMContractEvents::AFTER_CONTRACT_PERSIST, $event);
    		
            return $manager->redirect('door_show', array('id' => $entity->getDoor()->getId()));
        }

        $template = $manager->getRequest()->isXmlHttpRequest()
        		? 'JLMContractBundle:Contract:modal_new.html.twig'
        		: 'JLMContractBundle:Contract:new.html.twig'
          		;
          		
        return $manager->renderResponse($template, array(
            'form'   => $form->createView()
        ));
    }
    
    /**
     * Edits an existing Contract entity.
     */
    public function editAction($id, $formName)
    {
    	$manager = $this->container->get('jlm_contract.contract_manager');
    	$manager->secure('ROLE_USER');
    	$entity = $manager->getEntity($id);
    	$form = $manager->createForm($formName, array('entity' => $entity));
    	if ($manager->getHandler($form)->process())
    	{
    		$event = new ContractEvent($form->getData());
    		$manager->dispatch(JLMContractEvents::AFTER_CONTRACT_PERSIST, $event);
    		
    		return $this->redirect($this->generateUrl('door_show', array('id' => $entity->getDoor()->getId())));
    	}
    	 
    	return $manager->renderResponse('JLMContractBundle:Contract:'.$formName.'.html.twig', array(
    			'entity' => $entity,
    			'form'   => $form->createView(),
    	));
    }
}

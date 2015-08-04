<?php

/*
 * This file is part of the JLMCommerceBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CommerceBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use JLM\CommerceBundle\JLMCommerceEvents;
use JLM\CommerceBundle\Event\BillEvent;
use JLM\DailyBundle\Form\Type\ExternalBillType;
use JLM\CoreBundle\Entity\Search;
use JLM\CommerceBundle\Builder\Email\BillBoostMailBuilder;
use JLM\CoreBundle\Factory\MailFactory;
use JLM\CoreBundle\Builder\MailSwiftMailBuilder;
use JLM\CommerceBundle\Builder\Email\BillBoostBusinessMailBuilder;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class BillController extends ContainerAware
{
	/**
	 * List bills
	 */
	public function indexAction()
	{
		$manager = $this->container->get('jlm_commerce.bill_manager');
		$manager->secure('ROLE_USER');
		$request = $manager->getRequest();
		$states = array(
			'all' => 'All',
			'in_seizure' => 'InSeizure',
			'sended' => 'Sended',
			'payed' => 'Payed',
			'canceled' => 'Canceled'
		);
		$state = $request->get('state');
		$state = (!array_key_exists($state, $states)) ? 'all' : $state;
		$method = $states[$state];
		$functionCount = 'getCount'.$method;
		$functionDatas = 'get'.$method;
		
		return $manager->renderResponse('JLMCommerceBundle:Bill:index.html.twig',
				$manager->pagination($functionCount, $functionDatas, 'bill', array('state' => $state))
		);
	}
    
    /**
     * Finds and displays a Bill entity.
     */
    public function showAction($id)
    {
    	$manager = $this->container->get('jlm_commerce.bill_manager');
    	$manager->secure('ROLE_USER');
    	
        return $manager->renderResponse('JLMCommerceBundle:Bill:show.html.twig',array('entity'=> $manager->getEntity($id)));
    }
    
    /**
     * Displays a form to create a new Bill entity.
     */
    public function newAction()
    {
    	$manager = $this->container->get('jlm_commerce.bill_manager');
    	$manager->secure('ROLE_USER');
    	$form = $manager->createForm('new');
		if ($manager->getHandler($form)->process())
		{
			$entity = $form->getData();
			$manager->dispatch(JLMCommerceEvents::BILL_AFTER_PERSIST, new BillEvent($entity, $manager->getRequest()));

			return $manager->redirect('bill_show', array('id' => $form->getData()->getId()));
		}
		
        return $manager->renderResponse('JLMCommerceBundle:Bill:new.html.twig', array(
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Bill entity.
     */
    public function editAction($id)
    {
    	$manager = $this->container->get('jlm_commerce.bill_manager');
    	$manager->secure('ROLE_USER');
    	$entity = $manager->getEntity($id);
    	$manager->assertState($entity, array(0));
        $editForm = $manager->createForm('edit', array('entity'=> $entity));
        
        if ($manager->getHandler($editForm, $entity)->process())
        {
        	return $manager->redirect('bill_show', array('id' => $entity->getId()));
        }
        
        return $manager->renderResponse('JLMCommerceBundle:Bill:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));

    }

    /**
     * Imprimer la facture
     */
    public function printAction($id)
    {
        return $this->printer($id);
    }
    
    /**
     * Imprimer un duplicata de facture
     */
    public function printduplicateAction($id)
    {
    	return $this->printer($id, true);
    }
    
    private function printer($id, $duplicate = false)
    {
    	$manager = $this->container->get('jlm_commerce.bill_manager');
    	$manager->secure('ROLE_USER');
    	$entity = $manager->getEntity($id);
        $filename = $entity->getNumber();
        $filename = ($duplicate) ? $filename.'-duplicata' : $filename;
        $filename .= '.pdf';
        
        return $manager->renderPdf($filename, 'JLMCommerceBundle:Bill:print.pdf.php',array('entities'=>array($entity),'duplicate'=>$duplicate));
    }
    
    /**
     * Imprimer la liste des factures à faire
     */
    public function printlistAction()
    {
    	$manager = $this->container->get('jlm_commerce.bill_manager');
    	$manager->secure('ROLE_USER');
    	
    	return $manager->renderPdf('factures-a-faire', 'JLMCommerceBundle:Bill:printlist.pdf.php',
    			array('entities' => $manager->getObjectManager()->getRepository('JLMDailyBundle:Intervention')->getToBilled())
    			);
    }
    
    /**
     * Note Bill as ready to send.
     */
    public function readyAction($id)
    {
    	return $this->stateChange($id, 1);
    }
    
    /**
     * Note Bill as been send.
     */
    public function sendAction($id)
    {
    	$manager = $this->container->get('jlm_commerce.bill_manager');
    	$manager->secure('ROLE_USER');
    	$entity = $manager->getEntity($id);
    	if ($entity->getState() != 1)
    	{
    		$entity->setState(1);
    		$this->container->get('event_dispatcher')->dispatch(JLMCommerceEvents::BILL_SEND, new BillEvent($entity, $manager->getRequest()));
    	}
    	$em = $manager->getObjectManager();
    	$em->persist($entity);
    	$em->flush();
    	
    	return $manager->redirectReferer();
    }
    
    /**
     * Note Bill as been canceled.
     */
    public function cancelAction($id)
    {
    	return $this->stateChange($id, -1);
    }
    
    /**
     * Note Bill retour à la saisie.
     */
    public function backAction($id)
    {
    	return $this->stateChange($id, 0);
    }
    
    /**
     * Note Bill réglée.
     */
    public function payedAction($id)
    {
    	return $this->stateChange($id, 2);
    }
    
    private function stateChange($id, $newState)
    {
    	$manager = $this->container->get('jlm_commerce.bill_manager');
    	$manager->secure('ROLE_USER');
    	$entity = $manager->getEntity($id);
        switch ($newState)
        {
        	case 1:
        	    $redirect = ($entity->getState() < 0);    
        	    $set = ($entity->getState() < $newState);
        	    break;
        	case 2:
        	    $redirect = ($entity->getState() > 1);
        	    $set = ($entity->getState() == 1);
        	    break;
        	case -1:
        	case 0:
        	    $redirect = ($entity->getState() < 1);
        	    $set = ($entity->getState() > $newState);
        	    break;

        }
        if ($redirect)
        {
            return $manager->redirect('bill_show', array('id' => $entity->getId()));
        }
        if ($set)
        {
            $entity->setState($newState);
        }
        $em = $manager->getObjectManager();
        $em->persist($entity);
        $em->flush();
         
        return $manager->redirectReferer();
    }
    
    /**
     * Display bills to do
     */
    public function todoAction()
    {
    	$manager = $this->container->get('jlm_commerce.bill_manager');
    	$manager->secure('ROLE_USER');
    	$om = $manager->getObjectManager();
    	$list = $om->getRepository('JLMDailyBundle:Intervention')->getToBilled();
    	$forms_externalBill = array();
    	foreach ($list as $interv)
    	{
    		$forms_externalBill[] = $manager->getFormFactory()->createNamed('externalBill'.$interv->getId(),new ExternalBillType(), $interv)->createView();
    	}
    	return $manager->renderResponse('JLMCommerceBundle:Bill:todo.html.twig', array(
    			'entities'=>$list,
    			'forms_externalbill' => $forms_externalBill,
    	));
    }
    
    /**
     * Search
     */
    public function searchAction()
    {
    	$manager = $this->container->get('jlm_commerce.bill_manager');
    	$manager->secure('ROLE_USER');
    	$formData = $manager->getRequest()->get('jlm_core_search');
    	$params = array();
    	if (is_array($formData) && array_key_exists('query', $formData))
    	{
    		$params = array('results' => $manager->getRepository()->search($formData['query']));
    	}
    	 
    	return $manager->renderResponse('JLMCommerceBundle:Bill:search.html.twig', $params);
    }
}

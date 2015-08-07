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
class BillBoostController extends ContainerAware
{
	/**
	 * List bills
	 */
	public function indexAction()
	{
		$manager = $this->container->get('jlm_commerce.billboost_manager');
    	$manager->secure('ROLE_USER');
    	$repo = $manager->getRepository();
    	
    	return $manager->renderResponse('JLMCommerceBundle:BillBoost:index.html.twig', array(
    			'entities' => array_merge(
    					$repo->getBillsToBoost(3, 15, false),
    					$repo->getBillsToBoost(2, 30),
    					$repo->getBillsToBoost(1, 30)
    				)
    	));
	}
    
    /**
     * Email de relance facture
     */
    public function emailAction($id)
    {
    	// @todo Passer par un service de formPopulate et créer un controller unique dans CoreBundle
    	$manager = $this->container->get('jlm_commerce.bill_manager');
    	$manager->secure('ROLE_USER');
    	$entity = $manager->getEntity($id);
    	$request = $manager->getRequest();
    	$site = $entity->getSiteObject();
    	$builder = ($site === null) ? new BillBoostMailBuilder($entity) : new BillBoostBusinessMailBuilder($site, $manager->getObjectManager());
    	$mail = MailFactory::create($builder);
    	$editForm = $this->container->get('form.factory')->create(new \JLM\CoreBundle\Form\Type\MailType(), $mail);
    	$editForm->handleRequest($request);
    	if ($editForm->isValid())
    	{
    		$this->container->get('mailer')->send(MailFactory::create(new MailSwiftMailBuilder($editForm->getData())));
    		$this->container->get('event_dispatcher')->dispatch(JLMCommerceEvents::BILL_BOOST_SENDMAIL, new BillEvent($entity, $request));
    		
    		return $manager->redirectReferer();
    	}
    
    	return $manager->renderResponse('JLMCommerceBundle:BillBoost:email.html.twig',array(
    			'entity' => $entity,
    			'form' => $editForm->createView(),
    	));
    }
    
    /**
     * Imprimer le courrier de relance 
     */
    public function printAction($id)
    {
    	$manager = $this->container->get('jlm_commerce.bill_manager');
    	$manager->secure('ROLE_USER');
    	$entity = $manager->getEntity($id);
    	$repo = $manager->getObjectManager()->getRepository('JLMCommerceBundle:BillBoost');
    	$number = $repo->getCountBoostsByBill($entity);
    	
    	return $manager->renderPdf($entity->getNumber(), 'JLMCommerceBundle:BillBoost:print.pdf.php',array('entities'=>array($entity), 'number'=>$number));
    }
    
    /**
     * Noter relance effectuée
     */
    public function sendedAction($id)
    {
    	$manager = $this->container->get('jlm_commerce.bill_manager');
    	$manager->secure('ROLE_USER');
    	$entity = $manager->getEntity($id);
    	$em = $manager->getObjectManager();
    	$em->persist($entity);
    	$em->flush();
    	
    	$this->container->get('event_dispatcher')->dispatch(JLMCommerceEvents::BILL_BOOST, new BillEvent($entity, $manager->getRequest()));
    	
    	return $manager->redirect('jlm_commerce_billboost');
    }
}

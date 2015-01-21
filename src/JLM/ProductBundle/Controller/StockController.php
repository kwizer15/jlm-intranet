<?php

/*
 * This file is part of the JLMProductBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ProductBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use JLM\ProductBundle\Pdf\Stock;
use Symfony\Component\HttpFoundation\Response;

/**
 * Stock controller.
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class StockController extends ContainerAware
{
    /**
     * Lists all Stock entities.
     *
     */
    public function indexAction()
    {
    	$manager = $this->container->get('jlm_product.stock_manager');
    	$manager->secure('ROLE_USER');

        return $manager->renderResponse('JLMProductBundle:Stock:index.html.twig',
        		$manager->pagination('getCount', 'getAll', 'jlm_product_stock')
        );
    }

    /**
     * Displays a form to edit an existing Stock entity.
     *
     */
    public function editAction($id)
    {
    	$manager = $this->container->get('jlm_product.stock_manager');
    	$manager->secure('ROLE_USER');
        $entity = $manager->getEntity($id);
        $form = $manager->createForm('edit', array('entity' => $entity));
        if ($manager->getHandler($form)->process())
        {
        	return $manager->isAjax() ? $manager->renderJson(array()) : $manager->redirect('jlm_product_stock_edit', array('id' => $id));
        }
        $template = $manager->isAjax() ? 'modal_edit.html.twig' : 'edit.html.twig';
        
        return  $manager->renderResponse('JLMProductBundle:Stock:'.$template, array(
        	'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
    
    public function inventoryAction()
    {
    	$manager = $this->container->get('jlm_product.stock_manager');
    	$manager->secure('ROLE_USER');
    	$entity = $manager->getRepository()->getAll(500);
    	$form = $manager->createForm('inventory', array('entity' => $entity));
    	
    	if ($manager->getHandler($form)->process())
    	{
    		return $manager->redirect('jlm_product_stock_inventory');
    	}
    	
    	return $manager->renderResponse('JLMProductBundle:Stock:inventory.html.twig', array(
    			'form'   => $form->createView(),
    	));
    }
    
    /**
     * Imprime la liste d'attribution
     */
    public function printAction()
    {
    	$manager = $this->container->get('jlm_product.stock_manager');
    	$manager->secure('ROLE_USER');
    	$stocks = $manager->getRepository()->getAll(500);
		$response = new Response();
		$response->headers->set('Content-Type', 'application/pdf');
		$response->headers->set('Content-Disposition', 'inline; filename=stock.pdf');
		$response->setContent(Stock::get($stocks));
    
    	return $response;
    }
}

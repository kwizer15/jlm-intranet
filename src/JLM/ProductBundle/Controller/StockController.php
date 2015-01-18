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
        	return $manager->redirect('jlm_product_stock_edit', array('id' => $id));
        }
        return $manager->renderResponse('JLMProductBundle:Stock:edit.html.twig', array(
        	'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
}

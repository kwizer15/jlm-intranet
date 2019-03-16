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

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JLM\ProductBundle\Pdf\Stock;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Stock controller.
 *
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class StockController extends Controller
{

    /**
     * Lists all Stock entities.
     *
     */
    public function indexAction(Request $request)
    {
        $manager = $this->container->get('jlm_product.stock_manager');
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        return $manager->renderResponse(
            '@JLMProduct/stock/index.html.twig',
            $manager->pagination($request, 'getCount', 'getAll', 'jlm_product_stock')
        );
    }

    /**
     * Displays a form to edit an existing Stock entity.
     *
     * @param Request $request
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse|\Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction(Request $request, $id)
    {
        $manager = $this->container->get('jlm_product.stock_manager');
        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        $entity = $manager->getEntity($id);
        $form = $manager->createForm('edit', $request, ['entity' => $entity]);
        if ($manager->getHandler($form)->process()) {
            return $request->isXmlHttpRequest()
                ? $manager->renderJson([])
                : $manager->redirect(
                    'jlm_product_stock_edit',
                    ['id' => $id]
                );
        }
        $template = $request->isXmlHttpRequest() ? 'modal_edit.html.twig' : 'edit.html.twig';

        return $manager->renderResponse(
            '@JLMProduct/stock/' . $template,
            [
                'entity' => $entity,
                'form' => $form->createView(),
            ]
        );
    }

    public function inventoryAction(Request $request)
    {
        $manager = $this->container->get('jlm_product.stock_manager');
        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        $entity = $manager->getRepository()->getAll(500);
        $form = $manager->createForm('inventory', $request, ['entity' => $entity]);

        if ($manager->getHandler($form)->process()) {
            return $manager->redirect('jlm_product_stock_inventory');
        }

        return $manager->renderResponse(
            '@JLMProduct/stock/inventory.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * Imprime la liste d'attribution
     */
    public function printAction()
    {
        $manager = $this->container->get('jlm_product.stock_manager');
        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        $stocks = $manager->getRepository()->getAll(500);
        $response = new Response();
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'inline; filename=stock.pdf');
        $response->setContent(Stock::get($stocks));

        return $response;
    }
}

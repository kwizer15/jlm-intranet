<?php

namespace JLM\ProductBundle\Controller;

use JLM\ProductBundle\Entity\Stock;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\ProductBundle\Entity\Product;
use JLM\ProductBundle\Form\Type\ProductType;
use JLM\ProductBundle\JLMProductEvents;
use JLM\ProductBundle\Event\ProductEvent;

/**
 * Product controller.
 */
class ProductController extends Controller
{
    /**
     * Lists all Product entities.
     *
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $page = $request->get('page', 1);
        $limit = $request->get('limit', 15);
        $all = $request->get('all', 0);
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('JLMProductBundle:Product');
        $nb = $repo->getTotal(!$all);
        $nbPages = ceil($nb/$limit);
        $nbPages = ($nbPages < 1) ? 1 : $nbPages;
        $offset = ($page-1) * $limit;
        if ($page < 1 || $page > $nbPages) {
            throw $this->createNotFoundException('Page inexistante (page '.$page.'/'.$nbPages.')');
        }

        $entities = $repo->getAll($limit, $offset, !$all);

        return [
                'entities' => $entities,
                'page'     => $page,
                'nbPages'  => $nbPages,
               ];
    }

    /**
     * Finds and displays a Product entity.
     *
     * @Template()
     */
    public function showAction($id)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $entity = $this->getEntity($id);
        $stock = $this->getDoctrine()->getManager()->getRepository('JLMProductBundle:Stock')->getByProduct($entity);
        $deleteForm = $this->createDeleteForm($id);

        return [
                'entity'      => $entity,
                'stock'       => $stock,
                'delete_form' => $deleteForm->createView(),
               ];
    }

    /**
     * Displays a form to create a new Product entity.
     *
     * @Template()
     */
    public function newAction()
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $entity = new Product();
        $entity->setUnity('pièce');
        $entity->setDiscountSupplier(0);
        $entity->setExpenseRatio(10);
        $entity->setShipping(0);
        $entity->setUnitPrice(0);
        
        $form   = $this->createNewForm($entity);
            
        return [
                'entity' => $entity,
                'form'   => $form->createView(),
               ];
    }

    /**
     * Creates a new Product entity.
     *
     * @Template("@JLMProduct/product/new.html.twig")
     */
    public function createAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $entity = new Product();

        $form = $this->createNewForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('event_dispatcher')->dispatch(JLMProductEvents::PRODUCT_CREATE, new ProductEvent($entity));
            
            return $this->redirect($this->generateUrl('jlm_product_product_show', ['id' => $entity->getId()]));
        }

        return [
                'entity' => $entity,
                'form'   => $form->createView(),
               ];
    }

    /**
     * Displays a form to edit an existing Product entity.
     *
     * @Template()
     */
    public function editAction($id)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $entity = $this->getEntity($id);
        $editForm = $this->createEditForm($entity);

        return [
                'entity'    => $entity,
                'edit_form' => $editForm->createView(),
               ];
    }

    /**
     * Edits an existing Product entity.
     *
     * @Template("@JLMProduct/product/edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $entity = $this->getEntity($id);
        $editForm = $this->createEditForm($entity);

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('jlm_product_product_show', ['id' => $entity->getId()]));
        }

        return [
                'entity'    => $entity,
                'edit_form' => $editForm->createView(),
               ];
    }

    /**
     * Deletes a Product entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $form = $this->createDeleteForm($id);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $this->getEntity($id);

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('jlm_product_product'));
    }
    
    /**
     * Get the entity from id
     * @param int $id
     * @return ProductCategory
     */
    private function getEntity($id)
    {
        $em = $this->getDoctrine()->getManager();
    
        $entity = $em->getRepository('JLMProductBundle:Product')->find($id);
    
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }
    
        return $entity;
    }
    
    /**
     * Get the delete form
     * @param int $id
     * @return \Symfony\Component\Form\Form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(['id' => $id])
            ->add('id', HiddenType::class)
            ->getForm()
        ;
    }
    
    /**
     * Get the edit form
     * @param ProductCategory $entity
     * @return \Symfony\Component\Form\Form
     */
    private function createEditForm(Product $entity)
    {
        return $this->createForm(ProductType::class, $entity);
    }
    
    /**
     * Get the new form
     * @param ProductCategory $entity
     * @return \Symfony\Component\Form\Form
     */
    private function createNewForm(Product $entity)
    {
        return $this->createForm(ProductType::class, $entity);
    }
}

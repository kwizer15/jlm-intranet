<?php

namespace JLM\ProductBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\ProductBundle\Entity\ProductCategory;
use JLM\ProductBundle\Form\Type\ProductCategoryType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;

/**
 * ProductCategory controller.
 */
class ProductCategoryController extends Controller
{
    /**
     * Lists all ProductCategory entities.
     *
     * @Template()
     */
    public function indexAction()
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('JLMProductBundle:ProductCategory')->findAll();

        return ['entities' => $entities];
    }

    /**
     * Finds and displays a ProductCategory entity.
     *
     * @Template()
     */
    public function showAction($id)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $entity = $this->getEntity($id);

        $deleteForm = $this->createDeleteForm($id);

        return [
                'entity'      => $entity,
                'delete_form' => $deleteForm->createView(),
               ];
    }

    /**
     * Displays a form to create a new ProductCategory entity.
     *
     * @Template()
     */
    public function newAction()
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $entity = new ProductCategory();
        $form   = $this->createNewForm($entity);

        return [
                'entity' => $entity,
                'form'   => $form->createView(),
               ];
    }

    /**
     * Creates a new ProductCategory entity.
     *
     * @Template("JLMProductBundle:ProductCategory:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $entity  = new ProductCategory();
        $form    = $this->createNewForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('jlm_product_productcategory_show', ['id' => $entity->getId()]));
        }

        return [
                'entity' => $entity,
                'form'   => $form->createView(),
               ];
    }

    /**
     * Displays a form to edit an existing ProductCategory entity.
     *
     * @Template()
     */
    public function editAction($id)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $entity = $this->getEntity($id);

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return [
                'entity'      => $entity,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
               ];
    }

    /**
     * Edits an existing ProductCategory entity.
     *
     * @Template("JLMProductBundle:ProductCategory:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $entity = $this->getEntity($id);

        $editForm   = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('jlm_product_productcategory_edit', ['id' => $id]));
        }

        return [
                'entity'      => $entity,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
               ];
    }

    /**
     * Deletes a ProductCategory entity.
     */
    public function deleteAction(Request $request, $id)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $entity = $this->getEntity($id);
            $em = $this->getDoctrine()->getManager();
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('jlm_product_productcategory'));
    }
    
    /**
     * Get the entity from id
     * @param int $id
     * @return ProductCategory
     */
    private function getEntity($id)
    {
        $em = $this->getDoctrine()->getManager();
    
        $entity = $em->getRepository('JLMProductBundle:ProductCategory')->find($id);
    
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProductCategory entity.');
        }
    
        return $entity;
    }
    
    /**
     * Get the delete form
     * @param int $id
     * @return Form
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
    private function createEditForm(ProductCategory $entity)
    {
        return $this->createForm(ProductCategoryType::class, $entity);
    }
    
    /**
     * Get the new form
     * @param ProductCategory $entity
     * @return \Symfony\Component\Form\Form
     */
    private function createNewForm(ProductCategory $entity)
    {
        return $this->createForm(ProductCategoryType::class, $entity);
    }
}

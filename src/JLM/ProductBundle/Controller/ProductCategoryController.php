<?php

namespace JLM\ProductBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\ProductBundle\Entity\ProductCategory;
use JLM\ProductBundle\Form\Type\ProductCategoryType;
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
     * @Secure(roles="ROLE_USER")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('JLMProductBundle:ProductCategory')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a ProductCategory entity.
     *
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function showAction($id)
    {
        $entity = $this->getEntity($id);

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new ProductCategory entity.
     *
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function newAction()
    {
        $entity = new ProductCategory();
        $form   = $this->createNewForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new ProductCategory entity.
     *
     * @Template("JLMProductBundle:ProductCategory:new.html.twig")
     * @Secure(roles="ROLE_USER")
     */
    public function createAction(Request $request)
    {
        $entity  = new ProductCategory();
        $form    = $this->createNewForm($entity);
        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('jlm_product_productcategory_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing ProductCategory entity.
     *
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function editAction($id)
    {
        $entity = $this->getEntity($id);

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing ProductCategory entity.
     *
     * @Template("JLMProductBundle:ProductCategory:edit.html.twig")
     * @Secure(roles="ROLE_USER")
     */
    public function updateAction(Request $request, $id)
    {
        $entity = $this->getEntity($id);

        $editForm   = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        $editForm->handleRequest($request);

        if ($editForm->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('jlm_product_productcategory_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a ProductCategory entity.
     *
     * @Secure(roles="ROLE_USER")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid())
        {    
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
     * @return \Symfony\Component\Form\Form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
        ->add('id', 'hidden')
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
        return $this->createForm(new ProductCategoryType(), $entity);
    }
    
    /**
     * Get the new form
     * @param ProductCategory $entity
     * @return \Symfony\Component\Form\Form
     */
    private function createNewForm(ProductCategory $entity)
    {
        return $this->createForm(new ProductCategoryType(), $entity);
    }
}

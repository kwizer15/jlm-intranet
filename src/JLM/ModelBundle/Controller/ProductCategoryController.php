<?php

namespace JLM\ModelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\ModelBundle\Entity\ProductCategory;
use JLM\ModelBundle\Form\ProductCategoryType;

/**
 * ProductCategory controller.
 *
 * @Route("/productcategory")
 */
class ProductCategoryController extends Controller
{
    /**
     * Lists all ProductCategory entities.
     *
     * @Route("/", name="productcategory")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('JLMModelBundle:ProductCategory')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a ProductCategory entity.
     *
     * @Route("/{id}/show", name="productcategory_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JLMModelBundle:ProductCategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProductCategory entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new ProductCategory entity.
     *
     * @Route("/new", name="productcategory_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new ProductCategory();
        $form   = $this->createForm(new ProductCategoryType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new ProductCategory entity.
     *
     * @Route("/create", name="productcategory_create")
     * @Method("post")
     * @Template("JLMModelBundle:ProductCategory:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new ProductCategory();
        $request = $this->getRequest();
        $form    = $this->createForm(new ProductCategoryType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('productcategory_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing ProductCategory entity.
     *
     * @Route("/{id}/edit", name="productcategory_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JLMModelBundle:ProductCategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProductCategory entity.');
        }

        $editForm = $this->createForm(new ProductCategoryType(), $entity);
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
     * @Route("/{id}/update", name="productcategory_update")
     * @Method("post")
     * @Template("JLMModelBundle:ProductCategory:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JLMModelBundle:ProductCategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProductCategory entity.');
        }

        $editForm   = $this->createForm(new ProductCategoryType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('productcategory_edit', array('id' => $id)));
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
     * @Route("/{id}/delete", name="productcategory_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('JLMModelBundle:ProductCategory')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ProductCategory entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('productcategory'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

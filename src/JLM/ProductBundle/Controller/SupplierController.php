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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\ProductBundle\Entity\Supplier;
use JLM\ProductBundle\Form\Type\SupplierType;

/**
 * Supplier controller.
 *
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class SupplierController extends Controller
{
    /**
     * Lists all Supplier entities.
     *
     * @Template()
     * @Secure(roles="ROLE_OFFICE")
     */
    public function indexAction($page = 1)
    {
        $limit = 15;
        $em = $this->getDoctrine()->getManager();
        $nb = $em->getRepository('JLMProductBundle:Supplier')->getTotal();
        $nbPages = ceil($nb/$limit);
        $nbPages = ($nbPages < 1) ? 1 : $nbPages;
        $offset = ($page-1) * $limit;
        if ($page < 1 || $page > $nbPages) {
            throw $this->createNotFoundException('Page insexistante (page '.$page.'/'.$nbPages.')');
        }

        $entities = $em->getRepository('JLMProductBundle:Supplier')->getAll($limit, $offset);

        return [
                'entities' => $entities,
                'page'     => $page,
                'nbPages'  => $nbPages,
               ];
    }

    /**
     * Finds and displays a Supplier entity.
     *
     * @Template()
     * @Secure(roles="ROLE_OFFICE")
     */
    public function showAction(Supplier $entity)
    {
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('JLMProductBundle:Product')->findBy(
            ['supplier' => $entity],
            ['designation' => 'asc']
        );
        
        return [
                'entity'   => $entity,
                'products' => $products,
               ];
    }

    /**
     * Displays a form to create a new Supplier entity.
     *
     * @Template()
     * @Secure(roles="ROLE_OFFICE")
     */
    public function newAction()
    {
        $entity = new Supplier();
        $form   = $this->createNewForm($entity);

        return [
                'entity' => $entity,
                'form'   => $form->createView(),
               ];
    }

    /**
     * Creates a new Supplier entity.
     *
     * @Template("JLMProductBundle:Supplier:new.html.twig")
     * @Secure(roles="ROLE_OFFICE")
     */
    public function createAction()
    {
        $entity  = new Supplier();
        $request = $this->getRequest();
        $form    = $this->createNewForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('supplier_show', ['id' => $entity->getId()]));
        }

        return [
                'entity' => $entity,
                'form'   => $form->createView(),
               ];
    }

    /**
     * Displays a form to edit an existing Supplier entity.
     *
     * @Template()
     * @Secure(roles="ROLE_OFFICE")
     */
    public function editAction($id)
    {
        $entity = $entity = $this->getEntity($id);

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return [
                'entity'      => $entity,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
               ];
    }

    /**
     * Edits an existing Supplier entity.
     *
     * @Template("JLMProductBundle:Supplier:edit.html.twig")
     * @Secure(roles="ROLE_OFFICE")
     */
    public function updateAction($id)
    {
        $entity = $this->getEntity($id);

        $editForm   = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity->getAddress());
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('supplier_show', ['id' => $id]));
        }

        return [
                'entity'      => $entity,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
               ];
    }

    /**
     * Deletes a Supplier entity.
     *
     * @Secure(roles="ROLE_OFFICE")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $this->getEntity($id);

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('supplier'));
    }

    /**
     * Create a delete form
     * @param integer $id
     * @return \Symfony\Component\Form\Form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(['id' => $id])
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
    /**
     * Get the entity from id
     * @param integer $id
     * @return Supplier
     */
    private function getEntity($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('JLMProductBundle:Supplier')->find($id);
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Supplier entity.');
        }
        
        return $entity;
    }
    
    /**
     * Create a new form
     * @param Supplier $entity
     * @return \Symfony\Component\Form\Form
     */
    private function createNewForm(Supplier $entity)
    {
        return $this->createForm(new SupplierType(), $entity);
    }
    
    /**
     * Create an edit form
     * @param Supplier $entity
     * @return \Symfony\Component\Form\Form
     */
    private function createEditForm(Supplier $entity)
    {
        return $this->createForm(new SupplierType(), $entity);
    }
}

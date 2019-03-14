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
use JLM\ProductBundle\Entity\Supplier;
use JLM\ProductBundle\Form\Type\SupplierType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;

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
     */
    public function indexAction($page = 1)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

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
     */
    public function showAction(Supplier $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

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
     */
    public function newAction()
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

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
     * @param Request $request
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $entity  = new Supplier();
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
     */
    public function editAction($id)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

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
     * @param Request $request
     * @param $id
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
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
     * @param Request $request
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
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
            ->add('id', HiddenType::class)
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
        return $this->createForm(SupplierType::class, $entity);
    }
    
    /**
     * Create an edit form
     * @param Supplier $entity
     * @return \Symfony\Component\Form\Form
     */
    private function createEditForm(Supplier $entity)
    {
        return $this->createForm(SupplierType::class, $entity);
    }
}

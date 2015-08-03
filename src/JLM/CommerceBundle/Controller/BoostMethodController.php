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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use JLM\CommerceBundle\Entity\BoostMethod;

/**
 * BoostMethod controller.
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class BoostMethodController extends Controller
{
    /**
     * Lists all BoostMethod entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('JLMCommerceBundle:BoostMethod')->findAll();

        return $this->render('JLMCommerceBundle:BoostMethod:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new BoostMethod entity.
     *
     */
    public function newAction(Request $request)
    {
        $entity = new BoostMethod();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('boostmethod_show', array('id' => $entity->getId())));
        }

        return $this->render('JLMCommerceBundle:BoostMethod:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a BoostMethod entity.
     *
     * @param BoostMethod $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(BoostMethod $entity)
    {
        $form = $this->createForm('jlm_commerce_boostmethod', $entity, array(
            'action' => $this->generateUrl('boostmethod_new'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Finds and displays a BoostMethod entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JLMCommerceBundle:BoostMethod')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BoostMethod entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('JLMCommerceBundle:BoostMethod:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a BoostMethod entity.
    *
    * @param BoostMethod $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(BoostMethod $entity)
    {
        $form = $this->createForm('jlm_commerce_boostmethod', $entity, array(
            'action' => $this->generateUrl('boostmethod_edit', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing BoostMethod entity.
     *
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JLMCommerceBundle:BoostMethod')->find($id);

        if (!$entity)
        {
            throw $this->createNotFoundException('Unable to find BoostMethod entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid())
        {
            $em->flush();

            return $this->redirect($this->generateUrl('boostmethod_edit', array('id' => $id)));
        }

        return $this->render('JLMCommerceBundle:BoostMethod:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a BoostMethod entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('JLMCommerceBundle:BoostMethod')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find BoostMethod entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('boostmethod'));
    }

    /**
     * Creates a form to delete a BoostMethod entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('boostmethod_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}

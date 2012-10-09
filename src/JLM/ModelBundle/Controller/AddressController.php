<?php

namespace JLM\ModelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\ModelBundle\Entity\Address;
use JLM\ModelBundle\Form\AddressType;

/**
 * Address controller.
 *
 * @Route("/address")
 */
class AddressController extends Controller
{
    /**
     * Lists all Address entities.
     *
     * @Route("/", name="address")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('JLMModelBundle:Address')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Address entity.
     *
     * @Route("/{id}/show", name="address_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JLMModelBundle:Address')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Address entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Address entity.
     *
     * @Route("/new", name="address_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Address();
        $form   = $this->createForm(new AddressType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Address entity.
     *
     * @Route("/create", name="address_create")
     * @Method("post")
     * @Template("JLMModelBundle:Address:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Address();
        $request = $this->getRequest();
        $form    = $this->createForm(new AddressType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('address_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Address entity.
     *
     * @Route("/{id}/edit", name="address_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JLMModelBundle:Address')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Address entity.');
        }

        $editForm = $this->createForm(new AddressType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Address entity.
     *
     * @Route("/{id}/update", name="address_update")
     * @Method("post")
     * @Template("JLMModelBundle:Address:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JLMModelBundle:Address')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Address entity.');
        }

        $editForm   = $this->createForm(new AddressType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('address_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Address entity.
     *
     * @Route("/{id}/delete", name="address_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('JLMModelBundle:Address')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Address entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('address'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

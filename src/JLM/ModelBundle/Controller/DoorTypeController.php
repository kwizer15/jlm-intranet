<?php

namespace JLM\ModelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\ModelBundle\Entity\DoorType;
use JLM\ModelBundle\Form\DoorTypeType;

/**
 * DoorType controller.
 *
 * @Route("/doortype")
 */
class DoorTypeController extends Controller
{
    /**
     * Lists all DoorType entities.
     *
     * @Route("/", name="doortype")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('JLMModelBundle:DoorType')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a DoorType entity.
     *
     * @Route("/{id}/show", name="doortype_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JLMModelBundle:DoorType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DoorType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new DoorType entity.
     *
     * @Route("/new", name="doortype_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new DoorType();
        $form   = $this->createForm(new DoorTypeType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new DoorType entity.
     *
     * @Route("/create", name="doortype_create")
     * @Method("post")
     * @Template("JLMModelBundle:DoorType:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new DoorType();
        $request = $this->getRequest();
        $form    = $this->createForm(new DoorTypeType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('doortype_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing DoorType entity.
     *
     * @Route("/{id}/edit", name="doortype_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JLMModelBundle:DoorType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DoorType entity.');
        }

        $editForm = $this->createForm(new DoorTypeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing DoorType entity.
     *
     * @Route("/{id}/update", name="doortype_update")
     * @Method("post")
     * @Template("JLMModelBundle:DoorType:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JLMModelBundle:DoorType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DoorType entity.');
        }

        $editForm   = $this->createForm(new DoorTypeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('doortype_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a DoorType entity.
     *
     * @Route("/{id}/delete", name="doortype_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('JLMModelBundle:DoorType')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DoorType entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('doortype'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

<?php

namespace JLM\ModelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\ModelBundle\Entity\Interlocutor;
use JLM\ModelBundle\Form\InterlocutorType;

/**
 * Interlocutor controller.
 *
 * @Route("/interlocutor")
 */
class InterlocutorController extends Controller
{
    /**
     * Lists all Interlocutor entities.
     *
     * @Route("/", name="interlocutor")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('JLMModelBundle:Interlocutor')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Interlocutor entity.
     *
     * @Route("/{id}/show", name="interlocutor_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JLMModelBundle:Interlocutor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Interlocutor entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Interlocutor entity.
     *
     * @Route("/new", name="interlocutor_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Interlocutor();
        $form   = $this->createForm(new InterlocutorType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Interlocutor entity.
     *
     * @Route("/create", name="interlocutor_create")
     * @Method("post")
     * @Template("JLMModelBundle:Interlocutor:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Interlocutor();
        $request = $this->getRequest();
        $form    = $this->createForm(new InterlocutorType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('interlocutor_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Interlocutor entity.
     *
     * @Route("/{id}/edit", name="interlocutor_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JLMModelBundle:Interlocutor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Interlocutor entity.');
        }

        $editForm = $this->createForm(new InterlocutorType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Interlocutor entity.
     *
     * @Route("/{id}/update", name="interlocutor_update")
     * @Method("post")
     * @Template("JLMModelBundle:Interlocutor:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JLMModelBundle:Interlocutor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Interlocutor entity.');
        }

        $editForm   = $this->createForm(new InterlocutorType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('interlocutor_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Interlocutor entity.
     *
     * @Route("/{id}/delete", name="interlocutor_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('JLMModelBundle:Interlocutor')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Interlocutor entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('interlocutor'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

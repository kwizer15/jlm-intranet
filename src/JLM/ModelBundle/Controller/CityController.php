<?php

namespace JLM\ModelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\ModelBundle\Entity\City;
use JLM\ModelBundle\Form\CityType;

/**
 * City controller.
 *
 * @Route("/city")
 */
class CityController extends Controller
{
    /**
     * Lists all City entities.
     *
     * @Route("/", name="city")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('JLMModelBundle:City')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a City entity.
     *
     * @Route("/{id}/show", name="city_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JLMModelBundle:City')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find City entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new City entity.
     *
     * @Route("/new", name="city_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new City();
        $form   = $this->createForm(new CityType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new City entity.
     *
     * @Route("/create", name="city_create")
     * @Method("post")
     * @Template("JLMModelBundle:City:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new City();
        $request = $this->getRequest();
        $form    = $this->createForm(new CityType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('city_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing City entity.
     *
     * @Route("/{id}/edit", name="city_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JLMModelBundle:City')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find City entity.');
        }

        $editForm = $this->createForm(new CityType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing City entity.
     *
     * @Route("/{id}/update", name="city_update")
     * @Method("post")
     * @Template("JLMModelBundle:City:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JLMModelBundle:City')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find City entity.');
        }

        $editForm   = $this->createForm(new CityType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('city_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a City entity.
     *
     * @Route("/{id}/delete", name="city_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('JLMModelBundle:City')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find City entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('city'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

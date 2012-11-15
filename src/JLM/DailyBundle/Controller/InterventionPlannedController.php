<?php

namespace JLM\DailyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\DailyBundle\Entity\InterventionPlanned;
use JLM\DailyBundle\Form\InterventionPlannedType;

/**
 * InterventionPlanned controller.
 *
 * @Route("/interventionplanned")
 */
class InterventionPlannedController extends Controller
{
    /**
     * Lists all InterventionPlanned entities.
     *
     * @Route("/", name="interventionplanned")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('JLMDailyBundle:InterventionPlanned')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a InterventionPlanned entity.
     *
     * @Route("/{id}/show", name="interventionplanned_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JLMDailyBundle:InterventionPlanned')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find InterventionPlanned entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new InterventionPlanned entity.
     *
     * @Route("/new", name="interventionplanned_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new InterventionPlanned();
        $form   = $this->createForm(new InterventionPlannedType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new InterventionPlanned entity.
     *
     * @Route("/create", name="interventionplanned_create")
     * @Method("POST")
     * @Template("JLMDailyBundle:InterventionPlanned:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new InterventionPlanned();
        $form = $this->createForm(new InterventionPlannedType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('interventionplanned_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing InterventionPlanned entity.
     *
     * @Route("/{id}/edit", name="interventionplanned_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JLMDailyBundle:InterventionPlanned')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find InterventionPlanned entity.');
        }

        $editForm = $this->createForm(new InterventionPlannedType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing InterventionPlanned entity.
     *
     * @Route("/{id}/update", name="interventionplanned_update")
     * @Method("POST")
     * @Template("JLMDailyBundle:InterventionPlanned:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JLMDailyBundle:InterventionPlanned')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find InterventionPlanned entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new InterventionPlannedType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('interventionplanned_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a InterventionPlanned entity.
     *
     * @Route("/{id}/delete", name="interventionplanned_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('JLMDailyBundle:InterventionPlanned')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find InterventionPlanned entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('interventionplanned'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

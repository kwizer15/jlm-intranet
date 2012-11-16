<?php

namespace JLM\DailyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\DailyBundle\Entity\InterventionPlanned;
use JLM\DailyBundle\Form\Type\InterventionPlannedType;

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
     * @Secure(roles="ROLE_USER")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('JLMDailyBundle:InterventionPlanned')->findBy(array(),array('priority'=>'asc','creation'=>'asc'));

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a InterventionPlanned entity.
     *
     * @Route("/{id}/show", name="interventionplanned_show")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function showAction(InterventionPlanned $entity)
    {
        $deleteForm = $this->createDeleteForm($entity);

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
     * @Secure(roles="ROLE_USER")
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
     * @Secure(roles="ROLE_USER")
     */
    public function createAction(Request $request)
    {
        $entity  = new InterventionPlanned();
        $form = $this->createForm(new InterventionPlannedType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
        	$entity->setCreation(new \DateTime);
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
     * @Secure(roles="ROLE_USER")
     */
    public function editAction(InterventionPlanned $entity)
    {
        $editForm = $this->createForm(new InterventionPlannedType(), $entity);
        $deleteForm = $this->createDeleteForm($entity);

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
     * @Secure(roles="ROLE_USER")
     */
    public function updateAction(Request $request, InterventionPlanned $entity)
    {
        $em = $this->getDoctrine()->getManager();

        $deleteForm = $this->createDeleteForm($entity);
        $editForm = $this->createForm(new InterventionPlannedType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('interventionplanned_show', array('id' => $entity->getId())));
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
     * @Secure(roles="ROLE_USER")
     */
    public function deleteAction(Request $request, InterventionPlanned $entity)
    {
        $form = $this->createDeleteForm($entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('interventionplanned'));
    }

    private function createDeleteForm(InterventionPlanned $entity)
    {
        return $this->createFormBuilder(array('id' => $entity->getId()))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

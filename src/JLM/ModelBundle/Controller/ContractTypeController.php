<?php

namespace JLM\ModelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\ModelBundle\Entity\ContractType;
use JLM\ModelBundle\Form\ContractTypeType;

/**
 * ContractType controller.
 *
 * @Route("/contracttype")
 */
class ContractTypeController extends Controller
{
    /**
     * Lists all ContractType entities.
     *
     * @Route("/", name="contracttype")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('JLMModelBundle:ContractType')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a ContractType entity.
     *
     * @Route("/{id}/show", name="contracttype_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JLMModelBundle:ContractType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ContractType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new ContractType entity.
     *
     * @Route("/new", name="contracttype_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new ContractType();
        $form   = $this->createForm(new ContractTypeType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new ContractType entity.
     *
     * @Route("/create", name="contracttype_create")
     * @Method("post")
     * @Template("JLMModelBundle:ContractType:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new ContractType();
        $request = $this->getRequest();
        $form    = $this->createForm(new ContractTypeType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('contracttype_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing ContractType entity.
     *
     * @Route("/{id}/edit", name="contracttype_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JLMModelBundle:ContractType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ContractType entity.');
        }

        $editForm = $this->createForm(new ContractTypeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing ContractType entity.
     *
     * @Route("/{id}/update", name="contracttype_update")
     * @Method("post")
     * @Template("JLMModelBundle:ContractType:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JLMModelBundle:ContractType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ContractType entity.');
        }

        $editForm   = $this->createForm(new ContractTypeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('contracttype_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a ContractType entity.
     *
     * @Route("/{id}/delete", name="contracttype_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('JLMModelBundle:ContractType')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ContractType entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('contracttype'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

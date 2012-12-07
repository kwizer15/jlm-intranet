<?php

namespace JLM\ModelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\ModelBundle\Entity\Site;
use JLM\ModelBundle\Entity\Door;
use JLM\ModelBundle\Form\Type\DoorType;

/**
 * Door controller.
 *
 * @Route("/door")
 */
class DoorController extends Controller
{
    /**
     * Lists all Door entities.
     *
     * @Route("/", name="door")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('JLMModelBundle:Door')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Door entity.
     *
     * @Route("/{id}/show", name="door_show")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function showAction(Door $entity)
    {
        $em = $this->getDoctrine()->getEntityManager();
		
        $contracts = $em->getRepository('JLMModelBundle:Contract')->findByDoor($entity,array('begin'=>'DESC'));

        $deleteForm = $this->createDeleteForm($entity->getId());

        return array(
            'entity'      => $entity,
        	'contracts'	  => $contracts,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Door entity.
     *
     * @Route("/new", name="door_new")
     * @Route("/new/{id}", name="door_new_id")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function newAction(Site $site = null)
    {
        $entity = new Door();
        if ($site)
        {
        	$entity->setSite($site);
        	$entity->setStreet($site->getAddress()->getStreet());
        }
        $form   = $this->createForm(new DoorType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Door entity.
     *
     * @Route("/create", name="door_create")
     * @Method("post")
     * @Template("JLMModelBundle:Door:new.html.twig")
     * @Secure(roles="ROLE_USER")
     */
    public function createAction()
    {
        $entity  = new Door();
        $request = $this->getRequest();
        $form    = $this->createForm(new DoorType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('door_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Door entity.
     *
     * @Route("/{id}/edit", name="door_edit")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JLMModelBundle:Door')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Door entity.');
        }

        $editForm = $this->createForm(new DoorType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Door entity.
     *
     * @Route("/{id}/update", name="door_update")
     * @Method("post")
     * @Template("JLMModelBundle:Door:edit.html.twig")
     * @Secure(roles="ROLE_USER")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JLMModelBundle:Door')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Door entity.');
        }

        $editForm   = $this->createForm(new DoorType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('door_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Door entity.
     *
     * @Route("/{id}/delete", name="door_delete")
     * @Method("post")
     * @Secure(roles="ROLE_USER")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('JLMModelBundle:Door')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Door entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('door'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

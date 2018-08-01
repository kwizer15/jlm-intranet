<?php

namespace JLM\TransmitterBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\TransmitterBundle\Entity\UserGroup;
use JLM\TransmitterBundle\Form\Type\UserGroupType;
use JLM\ModelBundle\Entity\Site;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * UserGroup controller.
 *
 * @Route("/usergroup")
 */
class UserGroupController extends Controller
{
    /**
     * Displays a form to create a new UserGroup entity.
     *
     * @Route("/new/{id}", name="transmitter_usergroup_new")
     * @Template()
     * @Secure(roles="ROLE_OFFICE")
     */
    public function newAction(Site $site)
    {
        $entity = new UserGroup();
        $entity->setSite($site);
        $form   = $this->createForm(new UserGroupType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new UserGroup entity.
     *
     * @Route("/create", name="transmitter_usergroup_create")
     * @Method("POST")
     * @Template()
     * @Secure(roles="ROLE_OFFICE")
     */
    public function createAction(Request $request)
    {
        $entity  = new UserGroup();
        $form = $this->createForm(new UserGroupType(), $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return new JsonResponse(array());
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing UserGroup entity.
     *
     * @Route("/{id}/edit", name="transmitter_usergroup_edit")
     * @Template()
     * @Secure(roles="ROLE_OFFICE")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JLMTransmitterBundle:UserGroup')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserGroup entity.');
        }
        $hasTransmitter = $em->getRepository('JLMTransmitterBundle:Transmitter')->getCountByUserGroup($entity) > 0;
        $editForm = $this->get('form.factory')->createNamed('userGroupEdit'.$id,new UserGroupType(), $entity);

        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
        	'hasTransmitter' => $hasTransmitter,
        );
    }

    /**
     * Edits an existing UserGroup entity.
     *
     * @Route("/{id}/update", name="transmitter_usergroup_update")
     * @Method("POST")
     * @Template("JLMTransmitterBundle:UserGroup:edit.html.twig")
     * @Secure(roles="ROLE_OFFICE")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JLMTransmitterBundle:UserGroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserGroup entity.');
        }
        $hasTransmitter = $em->getRepository('JLMTransmitterBundle:Transmitter')->getCountByUserGroup($entity) > 0;
        $editForm = $this->get('form.factory')->createNamed('userGroupEdit'.$id,new UserGroupType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return new JsonResponse(array());
        }

        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
        	'hasTransmitter' => $hasTransmitter,
        );
    }

    /**
     * Deletes a UserGroup entity.
     *
     * @Route("/{id}/delete", name="transmitter_usergroup_delete")
     * @Secure(roles="ROLE_OFFICE")
     */
    public function deleteAction($id)
    {
    	$request = $this->getRequest();
    	$em = $this->getDoctrine()->getManager();
    	$entity = $em->getRepository('JLMTransmitterBundle:UserGroup')->find($id);
    	if (!$entity) {
    		throw $this->createNotFoundException('Unable to find UserGroup entity.');
    	}
    	$hasTransmitter = $em->getRepository('JLMTransmitterBundle:Transmitter')->getCountByUserGroup($entity) > 0;
    	if (!$hasTransmitter)
    	{
	        
	
	        $em->remove($entity);
	        $em->flush();
    	}
        return $this->redirect($request->headers->get('referer'));
    }
    
    /**
     * Get Model ID UserGroup entity.
     *
     * @Route("/{id}/defaultmodelid", name="transmitter_usergroup_defaultmodelid")
     * @Method("POST")
     * @Secure(roles="ROLE_OFFICE")
     */
    public function defaultmodelidAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
    	$entity = $em->getRepository('JLMTransmitterBundle:UserGroup')->find($id);
    	if (!$entity) {
    		throw $this->createNotFoundException('Unable to find UserGroup entity.');
    	}
    	return new Response($entity->getModel()->getId());
    }
}

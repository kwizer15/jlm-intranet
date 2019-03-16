<?php

namespace JLM\TransmitterBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\TransmitterBundle\Entity\UserGroup;
use JLM\TransmitterBundle\Form\Type\UserGroupType;
use JLM\ModelBundle\Entity\Site;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * UserGroup controller.
 *
 * @Route(path="/usergroup")
 */
class UserGroupController extends Controller
{
    /**
     * Displays a form to create a new UserGroup entity.
     *
     * @Route(path="/new/{id}", name="transmitter_usergroup_new")
     * @Template()
     */
    public function newAction(Site $site)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $entity = new UserGroup();
        $entity->setSite($site);
        $form   = $this->createForm(UserGroupType::class, $entity);

        return [
                'entity' => $entity,
                'form'   => $form->createView(),
               ];
    }

    /**
     * Creates a new UserGroup entity.
     *
     * @Route(path="/create", name="transmitter_usergroup_create",methods={"POST"})
     * @Template()
     */
    public function createAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $entity  = new UserGroup();
        $form = $this->createForm(UserGroupType::class, $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return new JsonResponse([]);
        }

        return [
                'entity' => $entity,
                'form'   => $form->createView(),
               ];
    }

    /**
     * Displays a form to edit an existing UserGroup entity.
     *
     * @Route(path="/{id}/edit", name="transmitter_usergroup_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JLMTransmitterBundle:UserGroup')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserGroup entity.');
        }
        $hasTransmitter = $em->getRepository('JLMTransmitterBundle:Transmitter')->getCountByUserGroup($entity) > 0;
        $editForm = $this->get('form.factory')->createNamed('userGroupEdit'.$id, UserGroupType::class, $entity);

        return [
                'entity'         => $entity,
                'form'           => $editForm->createView(),
                'hasTransmitter' => $hasTransmitter,
               ];
    }

    /**
     * Edits an existing UserGroup entity.
     *
     * @Route(path="/{id}/update", name="transmitter_usergroup_update",methods={"POST"})
     * @Template("@JLMTransmitter/usergroup/edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JLMTransmitterBundle:UserGroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserGroup entity.');
        }
        $hasTransmitter = $em->getRepository('JLMTransmitterBundle:Transmitter')->getCountByUserGroup($entity) > 0;
        $editForm = $this->get('form.factory')->createNamed('userGroupEdit'.$id, UserGroupType::class, $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return new JsonResponse([]);
        }

        return [
                'entity'         => $entity,
                'form'           => $editForm->createView(),
                'hasTransmitter' => $hasTransmitter,
               ];
    }

    /**
     * Deletes a UserGroup entity.
     *
     * @Route(path="/{id}/delete", name="transmitter_usergroup_delete")
     */
    public function deleteAction(Request $request, $id)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('JLMTransmitterBundle:UserGroup')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserGroup entity.');
        }
        $hasTransmitter = $em->getRepository('JLMTransmitterBundle:Transmitter')->getCountByUserGroup($entity) > 0;
        if (!$hasTransmitter) {
            $em->remove($entity);
            $em->flush();
        }
        return $this->redirect($request->headers->get('referer'));
    }
    
    /**
     * Get Model ID UserGroup entity.
     *
     * @Route(path="/{id}/defaultmodelid", name="transmitter_usergroup_defaultmodelid",methods={"POST"})
     */
    public function defaultmodelidAction($id)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('JLMTransmitterBundle:UserGroup')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserGroup entity.');
        }
        return new Response($entity->getModel()->getId());
    }
}

<?php

namespace JLM\TransmitterBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\TransmitterBundle\Entity\Transmitter;
use JLM\TransmitterBundle\Entity\Attribution;
use JLM\TransmitterBundle\Form\Type\TransmitterType;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Transmitter controller.
 *
 * @Route("/transmitter")
 */
class TransmitterController extends Controller
{
    /**
     * Displays a form to create a new Transmitter entity.
     *
     * @Route("/new/{id}", name="transmitter_new")
     * @Template()
     */
    public function newAction(Attribution $attribution)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $entity = new Transmitter();
        $entity->setAttribution($attribution);
        $form = $this->createForm(new TransmitterType($attribution->getSite()->getId()), $entity);

        return [
            'entity' => $entity,
            'form' => $form->createView(),
        ];
    }

    /**
     * Creates a new Transmitter entity.
     *
     * @Route("/create/{id}", name="transmitter_create")
     * @Method("POST")
     * @Template()
     */
    public function createAction(Request $request, Attribution $attribution)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $entity = new Transmitter();
        $form = $this->createForm(new TransmitterType($attribution->getSite()->getId()), $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            // On met à jour la page de base
            return new JsonResponse([]);
        }

        return [
            'entity' => $entity,
            'form' => $form->createView(),
        ];
    }

    /**
     * Displays a form to edit an existing Transmitter entity.
     *
     * @Route("/{id}/edit", name="transmitter_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JLMTransmitterBundle:Transmitter')->getById($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Transmitter entity.');
        }
        $editForm = $this->get('form.factory')->createNamed(
            'transmitterEdit' . $id,
            new TransmitterType($entity->getAttribution()->getSite()->getId()),
            $entity
        )
        ;
        //$editForm = $this->createForm(new TransmitterType($entity->getAttribution()->getSite()->getId()), $entity);

        return [
            'entity' => $entity,
            'form' => $editForm->createView(),
        ];
    }

    /**
     * Edits an existing Transmitter entity.
     *
     * @Route("/{id}/update", name="transmitter_update")
     * @Method("POST")
     * @Template("JLMTransmitterBundle:Transmitter:create.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JLMTransmitterBundle:Transmitter')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Transmitter entity.');
        }

        $editForm = $this->get('form.factory')->createNamed(
            'transmitterEdit' . $id,
            new TransmitterType($entity->getAttribution()->getSite()->getId()),
            $entity
        )
        ;
        //$editForm = $this->createForm(new TransmitterType($entity->getAttribution()->getSite()->getId()), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return new JsonResponse();
        }

        return [
            'entity' => $entity,
            'form' => $editForm->createView(),
        ];
    }

    /**
     * Unactive Transmitter entity.
     *
     * @Route("/{id}/unactive", name="transmitter_unactive")
     */
    public function unactiveAction(Transmitter $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $entity->setIsActive(false);
        $em = $this->getDoctrine()->getManager();
        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->get('request')->headers->get('referer'));
    }

    /**
     * Reactive Transmitter entity.
     *
     * @Route("/{id}/reactive", name="transmitter_reactive")
     */
    public function reactiveAction(Transmitter $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $entity->setIsActive(true);
        $em = $this->getDoctrine()->getManager();
        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->get('request')->headers->get('referer'));
    }
}

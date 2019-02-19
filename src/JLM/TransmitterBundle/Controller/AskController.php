<?php

namespace JLM\TransmitterBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\TransmitterBundle\Entity\Ask;
use JLM\TransmitterBundle\Form\Type\AskType;
use JLM\TransmitterBundle\Form\Type\AskDontTreatType;

/**
 * AskTransmitter controller.
 *
 * @Route("/ask")
 */
class AskController extends \JLM\OfficeBundle\Controller\AskController
{

    /**
     * Finds and displays a Ask entity.
     *
     * @Route("/{id}/show", name="transmitter_ask_show")
     * @Template()
     */
    public function showAction($id)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JLMTransmitterBundle:Ask')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ask entity.');
        }
        $form   = $this->createForm(new AskDontTreatType(), $entity);
        return [
                'entity'         => $entity,
                'form_donttreat' => $form->createView(),
               ];
    }

    /**
     * Displays a form to create a new Ask entity.
     *
     * @Route("/new", name="transmitter_ask_new")
     * @Template()
     */
    public function newAction()
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $entity = new Ask();
        $entity->setCreation(new \DateTime);
        $form   = $this->createForm(new AskType(), $entity);

        return [
                'entity' => $entity,
                'form'   => $form->createView(),
               ];
    }

    /**
     * Creates a new Ask entity.
     *
     * @Route("/create", name="transmitter_ask_create")
     * @Method("POST")
     * @Template("JLMTransmitterBundle:Ask:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $entity  = new Ask();
        $form = $this->createForm(new AskType(), $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('transmitter_ask_show', ['id' => $entity->getId()]));
        }

        return [
                'entity' => $entity,
                'form'   => $form->createView(),
               ];
    }

    /**
     * Displays a form to edit an existing Ask entity.
     *
     * @Route("/{id}/edit", name="transmitter_ask_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JLMTransmitterBundle:Ask')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ask entity.');
        }

        $editForm = $this->createForm(new AskType(), $entity);

        return [
                'entity'    => $entity,
                'edit_form' => $editForm->createView(),
               ];
    }

    /**
     * Edits an existing Ask entity.
     *
     * @Route("/{id}/update", name="transmitter_ask_update")
     * @Method("POST")
     * @Template("JLMTransmitterBundle:Ask:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('JLMTransmitterBundle:Ask')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ask entity.');
        }

        $editForm = $this->createForm(new AskType(), $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('transmitter_ask_edit', ['id' => $id]));
        }

        return [
                'entity'    => $entity,
                'edit_form' => $editForm->createView(),
               ];
    }
    
    protected function getRepositoryName()
    {
        return 'JLMTransmitterBundle:Ask';
    }
    
    /**
     * Lists all Ask entities.
     *
     * @Route("/page/{page}", name="transmitter_ask_page")
     * @Route("/", name="transmitter_ask")
     * @Template()
     */
    public function indexAction($page = 1)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $parms = parent::indexAction($page);
        $parms['pageRoute'] = 'transmitter_ask_page';
        return $parms;
    }
    
    /**
     * Lists all treated Ask entities.
     *
     * @Route("/treated", name="transmitter_ask_treated")
     * @Route("/treated/page/{page}", name="transmitter_ask_treated_page")
     * @Template("JLMTransmitterBundle:Ask:index.html.twig")
     */
    public function listtreatedAction($page = 1)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $parms = parent::listtreatedAction($page);
        $parms['pageRoute'] = 'transmitter_ask_treated_page';
        return $parms;
    }
    
    /**
     * Lists all untreated Ask entities.
     *
     * @Route("/untreated", name="transmitter_ask_untreated")
     * @Route("/untreated/page/{page}", name="transmitter_ask_untreated_page")
     * @Template("JLMTransmitterBundle:Ask:index.html.twig")
     */
    public function listuntreatedAction($page = 1)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $parms = parent::listuntreatedAction($page);
        $parms['pageRoute'] = 'transmitter_ask_untreated_page';
        return $parms;
    }
    
    /**
     * Note an Ask entities as Don't treated.
     *
     * @Route("/donttreat/{id}", name="transmitter_ask_donttreat")
     * @Template()
     */
    public function donttreatAction($id)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();
        $entity = $this->getEntity($em, $id);
        $form = $this->createForm(new AskDontTreatType, $entity);
        
        if ($this->getRequest()->isMethod('POST')) {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                $em->persist($entity);
                $em->flush();
            }
        }
        return $this->redirect($request->headers->get('referer'));
    }
    
    /**
     * Cancel the no-treatement ok Ask entities.
     *
     * @Route("/canceldonttreat/{id}", name="transmitter_ask_canceldonttreat")
     * @Template()
     */
    public function canceldonttreatAction($id)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        return parent::canceldonttreatAction($id);
    }
    
    /**
     * Display Sidebar
     *
     * @Route("/sidebar", name="transmitter_ask_sidebar")
     * @Template()
     */
    public function sidebarAction()
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        return parent::sidebarAction();
    }
}

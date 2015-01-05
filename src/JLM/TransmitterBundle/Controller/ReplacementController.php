<?php

namespace JLM\TransmitterBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\TransmitterBundle\Entity\Replacement;
use JLM\TransmitterBundle\Entity\Attribution;
use JLM\TransmitterBundle\Form\Type\ReplacementType;

/**
 * Replacement controller.
 *
 * @Route("/replacement")
 */
class ReplacementController extends Controller
{
    /**
     * Displays a form to create a new replacement entity.
     *
     * @Route("/new/{id}", name="transmitter_replacement_new")
     * @Template()
     */
    public function newAction(Attribution $attribution)
    {
        $entity = new Replacement();
        $entity->setAttribution($attribution);
        $form   = $this->createForm(new ReplacementType($attribution->getSite()->getId()), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Series entity.
     *
     * @Route("/create/{id}", name="transmitter_replacement_create")
     * @Method("POST")
     * @Template()
     */
    public function createAction(Request $request, Attribution $attribution)
    {
        $entity  = new Replacement();
        $form = $this->createForm(new ReplacementType($attribution->getSite()->getId()), $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $new = $entity->getNew();
            $old = $entity->getOld();
            $em->persist($new);
            $old->setReplacedTransmitter($new);
            $em->persist($old);
            $em->flush();
			
            // On met à jour la page de base
            return new Response('reload');
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }
}

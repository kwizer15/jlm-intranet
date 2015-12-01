<?php

namespace JLM\TransmitterBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\TransmitterBundle\Entity\Series;
use JLM\TransmitterBundle\Entity\Attribution;
use JLM\TransmitterBundle\Form\Type\SeriesType;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Series controller.
 *
 * @Route("/series")
 */
class SeriesController extends Controller
{
    /**
     * Displays a form to create a new Series entity.
     *
     * @Route("/new/{id}", name="transmitter_series_new")
     * @Template()
     * @Secure(roles="ROLE_OFFICE")
     */
    public function newAction(Attribution $attribution)
    {
        $entity = new Series();
        $entity->setAttribution($attribution);
        $form   = $this->createForm(new SeriesType($attribution->getSite()->getId()), $entity);
		$form->add('submit','submit',array('label'=>'Enregistrer'));
		
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Series entity.
     *
     * @Route("/create/{id}", name="transmitter_series_create")
     * @Method("POST")
     * @Template()
     * @Secure(roles="ROLE_OFFICE")
     */
    public function createAction(Request $request, Attribution $attribution)
    {
        $entity  = new Series();
        $form = $this->createForm(new SeriesType($attribution->getSite()->getId()), $entity);
        $form->add('submit','submit',array('label'=>'Enregistrer'));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $transmitters = $entity->getTransmitters();
            foreach ($transmitters as $transmitter)
            {
            	$em->persist($transmitter);
            }
            $em->flush();
			
            // On met à jour la page de base
            return new JsonResponse(array());
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }
}

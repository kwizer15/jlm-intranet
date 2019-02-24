<?php

namespace JLM\TransmitterBundle\Controller;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
     */
    public function newAction(Attribution $attribution)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        $entity = new Series();
        $entity->setAttribution($attribution);
        $form = $this->createForm(SeriesType::class, $entity, [
            'siteId' => $attribution->getSite()->getId(),
        ]);
        $form->add('submit', SubmitType::class, ['label' => 'Enregistrer']);

        return [
            'entity' => $entity,
            'form' => $form->createView(),
        ];
    }

    /**
     * Creates a new Series entity.
     *
     * @Route("/create/{id}", name="transmitter_series_create")
     * @Method("POST")
     * @Template()
     */
    public function createAction(Request $request, Attribution $attribution)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $entity = new Series();
        $form = $this->createForm(SeriesType::class, $entity, [
            'siteId' => $attribution->getSite()->getId(),
        ]);
        $form->add('submit', SubmitType::class, ['label' => 'Enregistrer']);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $transmitters = $entity->getTransmitters();
            foreach ($transmitters as $transmitter) {
                $em->persist($transmitter);
            }
            $em->flush();

            // On met à jour la page de base
            return new JsonResponse([]);
        }

        return [
            'entity' => $entity,
            'form' => $form->createView(),
        ];
    }
}

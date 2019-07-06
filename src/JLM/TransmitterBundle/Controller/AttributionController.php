<?php

namespace JLM\TransmitterBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\TransmitterBundle\Entity\Attribution;
use JLM\TransmitterBundle\Entity\Ask;
use JLM\TransmitterBundle\Form\Type\AttributionType;
use JLM\CommerceBundle\Factory\BillFactory;
use JLM\TransmitterBundle\Builder\AttributionBillBuilder;

/**
 * Attribution controller.
 *
 * @Route("/attribution")
 */
class AttributionController extends Controller
{
    /**
     * Lists all Attribution entities.
     *
     * @Route("/", name="transmitter_attribution")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

    	$manager = $this->container->get('jlm_core.mail_manager'); //@todo To change : rewrite services as yaml and include a manager service
    	$manager->secure('ROLE_OFFICE');
    	
    	return $manager->paginator('JLMTransmitterBundle:Attribution', $request, array('sort' => '!date'));
    }

    /**
     * Finds and displays a Attribution entity.
     *
     * @Route("/{id}/show", name="transmitter_attribution_show")
     * @Template()
     */
    public function showAction(Attribution $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        return array(
            'entity'      => $entity,
        );
    }

    /**
     * Displays a form to create a new Attribution entity.
     *
     * @Route("/new/{id}", name="transmitter_attribution_new")
     * @Template()
     */
    public function newAction(Ask $ask)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $entity = new Attribution();
        $entity->setCreation(new \DateTime);
        $entity->setAsk($ask);
        $form   = $this->createForm(new AttributionType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Attribution entity.
     *
     * @Route("/create", name="transmitter_attribution_create")
     * @Method("POST")
     * @Template("JLMTransmitterBundle:Attribution:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $entity  = new Attribution();
        $form = $this->createForm(new AttributionType(), $entity);
        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('transmitter_attribution_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Attribution entity.
     *
     * @Route("/{id}/edit", name="transmitter_attribution_edit")
     * @Template()
     */
    public function editAction(Attribution $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $editForm = $this->createForm(new AttributionType(), $entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Attribution entity.
     *
     * @Route("/{id}/update", name="transmitter_attribution_update")
     * @Method("POST")
     * @Template("JLMTransmitterBundle:Attribution:edit.html.twig")
     */
    public function updateAction(Request $request, Attribution $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $em = $this->getDoctrine()->getManager();

        $editForm = $this->createForm(new AttributionType(), $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('transmitter_attribution_show', array('id' => $entity->getId())));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Imprime la liste d'attribution
     *
     * @Route("/{id}/printlist", name="transmitter_attribution_printlist")
     */
    public function printlistAction(Attribution $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        // Retrier les bips par Groupe puis par numéro
        $transmitters = $entity->getTransmitters();
        $resort = array();
        foreach ($transmitters as $transmitter)
        {
        	$index = $transmitter->getUserGroup()->getName();
        	if (!isset($resort[$index]))
        		$resort[$index] = array();
        	$resort[$index][] = $transmitter;
        }
        $final = array();
        foreach ($resort as $list)
        	$final = array_merge($final,$list);
        unset($resort);
        
        
    	$response = new Response();
    	$response->headers->set('Content-Type', 'application/pdf');
    	$response->headers->set('Content-Disposition', 'inline; filename=attribution-'.$entity->getId().'.pdf');
    	$response->setContent($this->render('JLMTransmitterBundle:Attribution:printlist.pdf.php',
    			array(
    					'entity' => $entity,
    					'transmitters' => $final,
    					'withHeader' => true,
    			)));
    
    	return $response;
    }
    
    /**
     * Imprime le courrier
     *
     * @Route("/{id}/printcourrier", name="transmitter_attribution_printcourrier")
     */
    public function printcourrierAction(Attribution $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

    	$response = new Response();
    	$response->headers->set('Content-Type', 'application/pdf');
    	$response->headers->set('Content-Disposition', 'inline; filename=attribution-courrier-'.$entity->getId().'.pdf');
    	$response->setContent($this->render('JLMTransmitterBundle:Attribution:printcourrier.pdf.php',
    			array(
    					'entity' => $entity,
    			)));
    
    	return $response;
    }
    
    /**
     * Generate bill
     *
     * @Route("/{id}/bill", name="transmitter_attribution_bill")
     */
    public function billAction(Attribution $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

    	$em = $this->getDoctrine()->getManager();
    	
    	if ($entity->getBill() !== null)
    	{
    	   return $this->redirect($this->generateUrl('bill_edit', array('id' => $entity->getBill()->getId())));
    	}
    	// @todo trouver un autre solution que le codage brut
    	$options = array(
    	    'port'         => $em->getRepository('JLMProductBundle:Product')->find(134),
    	    'earlyPayment' => (string)$em->getRepository('JLMCommerceBundle:EarlyPaymentModel')->find(1),
    	    'penalty'      => (string)$em->getRepository('JLMCommerceBundle:PenaltyModel')->find(1),
    	    'property'     => (string)$em->getRepository('JLMCommerceBundle:PropertyModel')->find(1),
    	);
    	$bill = BillFactory::create(new AttributionBillBuilder($entity, $em->getRepository('JLMCommerceBundle:VAT')->find(1)->getRate(), $options));
    	$em->persist($bill);
    	$entity->setBill($bill);
    	$em->persist($entity);
    	$em->flush();
    	
    	return $this->redirect($this->generateUrl('bill_edit', array('id' => $bill->getId())));
    }
}

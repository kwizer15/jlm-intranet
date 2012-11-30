<?php

namespace JLM\OfficeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\ModelBundle\Entity\Mail;
use JLM\ModelBundle\Form\Type\MailType;
use JLM\OfficeBundle\Entity\Quote;
use JLM\OfficeBundle\Entity\QuoteVariant;
use JLM\OfficeBundle\Form\Type\QuoteVariantType;
use JLM\OfficeBundle\Entity\QuoteLine;



/**
 * Quote controller.
 *
 * @Route("/quote/variant")
 */
class VariantController extends Controller
{
	/**
     * Displays a form to create a new Variant entity.
     *
     * @Route("/{id}/new", name="variant_new")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function newAction(Quote $quote)
    {
        $entity = new QuoteVariant();
        $entity->setQuote($quote);
        $entity->setCreation(new \DateTime);
        $entity->addLine(new QuoteLine);
        $form   = $this->createForm(new QuoteVariantType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }
    
    /**
     * Creates a new Variant entity.
     *
     * @Route("/create", name="variant_create")
     * @Method("post")
     * @Template("JLMOfficeBundle:Variant:new.html.twig")
     * @Secure(roles="ROLE_USER")
     */
    public function createAction(Request $request)
    {
    	$entity  = new QuoteVariant();
    	$form    = $this->createForm(new QuoteVariantType(), $entity);
    	$form->bind($request);
    
    	if ($form->isValid())
    	{
    		$em->persist($entity);
    		$em->flush();
    		return $this->redirect($this->generateUrl('variant_show', array('id' => $entity->getId())));
    	}
    
    	return array(
	    	'entity' => $entity,
	    	'form'   => $form->createView()
    	);
    }
}
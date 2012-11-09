<?php

namespace JLM\OfficeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\ModelBundle\Entity\Quote;
use JLM\ModelBundle\Entity\QuoteLine;
use JLM\ModelBundle\Form\QuoteType;

/**
 * Quote controller.
 *
 * @Route("/quote")
 */
class QuoteController extends Controller
{
    /**
     * Lists all Quote entities.
     *
     * @Route("/", name="quote")
     * @Route("/page/{page}", name="quote_page")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function indexAction($page = 1)
    {
    	$limit = 10;
        $em = $this->getDoctrine()->getEntityManager();
           
        $nb = $em->getRepository('JLMModelBundle:Quote')->getTotal();
        $nbPages = ceil($nb/$limit);
        $offset = ($page-1) * $limit;
        if ($page < 1 || $page > $nbPages)
        {
        	throw $this->createNotFoundException('Page insexistante (page '.$page.'/'.$nbPages.')');
        }
        
        $entities = $em->getRepository('JLMModelBundle:Quote')->findBy(
        		array(),
        		array('number'=>'desc'),
        		$limit,
        		$offset
        );
        
        return array(
        		'entities' => $entities,
        		'page'     => $page,
        		'nbPages'  => $nbPages,
        );
    }

    /**
     * Finds and displays a Quote entity.
     *
     * @Route("/{id}/show", name="quote_show")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function showAction(Quote $entity)
    {
        return array('entity'=> $entity);
    }
    
    /**
     * Displays a form to create a new Quote entity.
     *
     * @Route("/new", name="quote_new")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function newAction()
    {
        $entity = new Quote();
        $entity->setCreation(new \DateTime);
        $entity->setDiscount(0);
        $entity->addLine(new QuoteLine);
        $em = $this->getDoctrine()->getEntityManager();
        $vat = $em->getRepository('JLMModelBundle:VAT')->find(1)->getRate();
		$entity->setVat($vat);
		$entity->setVatTransmitter($vat);
        $form   = $this->createForm(new QuoteType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Quote entity.
     *
     * @Route("/create", name="quote_create")
     * @Method("post")
     * @Template("JLMOfficeBundle:Quote:new.html.twig")
     * @Secure(roles="ROLE_USER")
     */
    public function createAction(Request $request)
    {
        $entity  = new Quote();
        $form    = $this->createForm(new QuoteType(), $entity);
        $form->bind($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getEntityManager();
            $number = $entity->getCreation()->format('ym');
            $n = ($em->getRepository('JLMModelBundle:Quote')->getLastNumber() + 1);
            for ($i = strlen($n); $i < 4 ; $i++)
            	$number.= '0';
            $number.= $n;
            $entity->setNumber($number);
            $em->persist($entity);
            foreach ($entity->getLines() as $key => $line)
            {
            	$line->setQuote($entity);
            	$em->persist($line);
            }
            $em->flush();
            return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getId())));  
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Quote entity.
     *
     * @Route("/{id}/edit", name="quote_edit")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function editAction(Quote $entity)
    {
    	// Si le devis est déjà validé, on empèche quelconque modification
    	if ($entity->isValid())
    		return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getId())));
        $editForm = $this->createForm(new QuoteType(), $entity);
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Quote entity.
     *
     * @Route("/{id}/update", name="quote_update")
     * @Method("post")
     * @Template("JLMOfficeBundle:Quote:edit.html.twig")
     * @Secure(roles="ROLE_USER")
     */
    public function updateAction(Request $request, Quote $entity)
    {
    	// Si le devis est déjà validé, on empèche quelconque odification
    	if ($entity->isValid())
    		return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getId())));
    	 
        $originalLines = array();
        foreach ($entity->getLines() as $line)
        	$originalLines[] = $line;
        $editForm = $this->createForm(new QuoteType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
        	$em = $this->getDoctrine()->getEntityManager();
        	$em->persist($entity);
        	foreach ($entity->getLines() as $key => $line)
        	{	
        		// Nouvelles lignes
        		$line->setQuote($entity);
        		$em->persist($line);
        		
        		// On vire les anciennes
        		foreach ($originalLines as $key => $toDel) 
        			if ($toDel->getId() === $line->getId()) 
        				unset($originalLines[$key]);
        	}
        	foreach ($originalLines as $line)
        	{
        		$em->remove($line);
        	}
            $em->flush();
            return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getId())));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Valid a Quote entity.
     *
     * @Route("/{id}/valid", name="quote_valid")
     * @Secure(roles="ROLE_USER")
     */
    public function validAction(Request $request, Quote $entity)
    {
    	$entity->setValid();
    	$em = $this->getDoctrine()->getEntityManager();
    	$em->persist($entity);
    	$em->flush();
    	return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getId())));
    }
    
    /**
     * dévalide a Quote entity.
     *
     * @Route("/{id}/unvalid", name="quote_unvalid")
     * @Secure(roles="ROLE_USER")
     */
    public function unvalidAction(Request $request, Quote $entity)
    {
    	$entity->setValid(false);
    	$entity->setSend(false);
    	$entity->setGiven(false);
    	$em = $this->getDoctrine()->getEntityManager();
    	$em->persist($entity);
    	$em->flush();
    	return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getId())));
    }
    
    /**
     * Send a Quote entity.
     *
     * @Route("/{id}/send", name="quote_send")
     * @Secure(roles="ROLE_USER")
     */
    public function sendAction(Request $request, Quote $entity)
    {
    	if (!$entity->isValid())
    		return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getId())));
    	$entity->setSend();
    	$em = $this->getDoctrine()->getEntityManager();
    	$em->persist($entity);
    	$em->flush();
    	return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getId())));
    }
    
	/**
     * Given a Quote entity.
     *
     * @Route("/{id}/given", name="quote_given")
     * @Secure(roles="ROLE_USER")
     */
    public function givenAction(Request $request, Quote $entity)
    {
    	if (!$entity->isSend() || !$entity->isValid())
    		return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getId())));
    	$entity->setGiven();
    	$em = $this->getDoctrine()->getEntityManager();
    	$em->persist($entity);
    	$em->flush();
    	return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getId())));
    }
    
    /**
     * Deletes a Quote entity.
     *
     * @Route("/{id}/delete", name="quote_delete")
     * @Method("post")
     * @Secure(roles="ROLE_USER")
     */
    public function deleteAction(Request $request, Quote $quote)
    {
        $form = $this->createDeleteForm($quote->getId());
        $form->bind($request);
        if ($form->isValid()) {
            $em->remove($entity);
            $em->flush();
        }
        return $this->redirect($this->generateUrl('quote'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
    /**
     * Autocompletion générale
     * @Route("/autocomplete", name="quote_autocompletion")
     * @Method("post")
     * @Secure(roles="ROLE_USER")
     */
    public function autocompletionAction(Request $request)
    {
    	$query = $request->request->get('term');
    	$entity = $request->request->get('entity');
    	if (!in_array($entity,array('Door','Trustee','Product','IntroModel','DelayModel','PaymentModel','SiteContact')))
    		throw $this->createNotFoundException('Entité '.$entity.' inexistante');
    	$em = $this->getDoctrine()->getEntityManager();
    	$action = 'search';
    	if ($entity == 'Product')
    	{
    		$by = $request->request->get('by');
    		if (!in_array($by,array('Reference','Designation')))
    			throw $this->createNotFoundException('Recherche par '.$by.' impossible');
    		$action .= $by;
    	}
    	else
    		$action .= 'Result';
    	$results = $em->getRepository('JLMModelBundle:'.$entity)->$action($query);
    	$json = json_encode($results);
    	$response = new Response();
    	$response->headers->set('Content-Type', 'application/json');
    	$response->setContent($json);
    
    	return $response;
    }
    
    /**
     * Autocomplete door
     *
     * @Route("/autocomplete/door", name="quote_auto_door")
     * @Method("post")
     * @Secure(roles="ROLE_USER")
     */
    public function autodoorAction(Request $request)
    {
    	$query = $request->request->get('term');
    	$em = $this->getDoctrine()->getEntityManager();
    	$results = $em->getRepository('JLMModelBundle:Door')->searchResult($query);
    	$json = json_encode($results);
    	$response = new Response();
    	$response->headers->set('Content-Type', 'application/json');
    	$response->setContent($json);
    	 
    	return $response;
    }
    
    /**
     * Autocomplete trustee
     *
     * @Route("/autocomplete/trustee", name="quote_auto_trustee")
     * @Method("post")
     * @Secure(roles="ROLE_USER")
     */
    public function autotrusteeAction(Request $request)
    {
    	$query = $request->request->get('term');
    	$em = $this->getDoctrine()->getEntityManager();
    	$results = $em->getRepository('JLMModelBundle:Trustee')->searchResult($query);
    	$json = json_encode($results);
    	$response = new Response();
    	$response->headers->set('Content-Type', 'application/json');
    	$response->setContent($json);
    
    	return $response;
    }
    
   /**
    * Autocomplete product
    *
    * @Route("/autocomplete/product/reference", name="quote_auto_product_reference")
    * @Method("post")
    * @Secure(roles="ROLE_USER")
     */
   public function autoproductreferenceAction(Request $request)
   {
   	$query = $request->request->get('term');
   	$em = $this->getDoctrine()->getEntityManager();
   	$results = $em->getRepository('JLMModelBundle:Product')->searchReference($query);
   	$json = json_encode($results);
   	$response = new Response();
   	$response->headers->set('Content-Type', 'application/json');
   	$response->setContent($json);
   
   	return $response;
   }
   
   /**
    * Autocomplete product
    *
    * @Route("/autocomplete/product/designation", name="quote_auto_product_designation")
    * @Method("post")
    * @Secure(roles="ROLE_USER")
     */
   public function autoproductdesignationAction(Request $request)
   {
   	$query = $request->request->get('term');
   	$em = $this->getDoctrine()->getEntityManager();
   	$results = $em->getRepository('JLMModelBundle:Product')->searchDesignation($query);
   	$json = json_encode($results);
   	$response = new Response();
   	$response->headers->set('Content-Type', 'application/json');
   	$response->setContent($json);
   	 
   	return $response;
   }
   
   /**
    * Autocomplete intro
    *
    * @Route("/autocomplete/intro", name="quote_auto_intro")
    * @Method("post")
    * @Secure(roles="ROLE_USER")
     */
   public function autointroAction(Request $request)
   {
   	$query = $request->request->get('term');
   	$em = $this->getDoctrine()->getEntityManager();
   	$results = $em->getRepository('JLMModelBundle:IntroModel')->searchResult($query);
   	$json = json_encode($results);
   	$response = new Response();
   	$response->headers->set('Content-Type', 'application/json');
   	$response->setContent($json);
   	 
   	return $response;
   }
   
   /**
    * Autocomplete delay
    *
    * @Route("/autocomplete/delay", name="quote_auto_delay")
    * @Method("post")
    * @Secure(roles="ROLE_USER")
     */
   public function autodelayAction(Request $request)
   {
   	$query = $request->request->get('term');
   	$em = $this->getDoctrine()->getEntityManager();
   	$results = $em->getRepository('JLMModelBundle:DelayModel')->searchResult($query);
   	$json = json_encode($results);
   	$response = new Response();
   	$response->headers->set('Content-Type', 'application/json');
   	$response->setContent($json);
   	 
   	return $response;
   }
   
   /**
    * Autocomplete payment
    *
    * @Route("/autocomplete/payment", name="quote_auto_payment")
    * @Method("post")
    * @Secure(roles="ROLE_USER")
     */
   public function autopaymentAction(Request $request)
   {
   	$query = $request->request->get('term');
   	$em = $this->getDoctrine()->getEntityManager();
   	$results = $em->getRepository('JLMModelBundle:PaymentModel')->searchResult($query);
   	$json = json_encode($results);
   	$response = new Response();
   	$response->headers->set('Content-Type', 'application/json');
   	$response->setContent($json);
   	 
   	return $response;
   }
   
   /**
    * Autocomplete contact
    *
    * @Route("/autocomplete/contact", name="quote_auto_contact")
    * @Method("post")
    * @Secure(roles="ROLE_USER")
     */
   public function autocontactAction(Request $request)
   {
   	$query = $request->request->get('term');
   	$em = $this->getDoctrine()->getEntityManager();
   	$results = $em->getRepository('JLMModelBundle:SiteContact')->searchResult($query);
   	$json = json_encode($results);
   	$response = new Response();
   	$response->headers->set('Content-Type', 'application/json');
   	$response->setContent($json);
   	 
   	return $response;
   }
   
   /**
    * @Route("/{id}/pdf",name="quote_pdf")
    * @Secure(roles="ROLE_USER")
     */
   public function pdfAction(Quote $entity)
   {
	   	if (!$entity->isValid())
	   		return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getId())));
	   	$entity->setSend();
	   	$em = $this->getDoctrine()->getEntityManager();
	   	$em->persist($entity);
	   	$em->flush();
   	
        $pdf = new \FPDI();
        
        // Template
        $pageCount = $pdf->setSourceFile($_SERVER['DOCUMENT_ROOT'].'bundles/jlmoffice/pdf/devis.pdf');
        $onlyPage = $pdf->importPage(1, '/MediaBox');
        //	$firstPage = $pdf->importPage(2, '/MediaBox');
        //	$middlePage = $pdf->importPage(3, '/MediaBox');
        //	$endPage = $pdf->importPage(4 '/MediaBox');
         
        // Premiere page
        $pdf->addPage();
        $pdf->useTemplate($onlyPage);
        
     /* Cadrillage */ 
     /*  for ($x = 0; $x < 300; $x += 10)
        	for ($y  = 0; $y < 300; $y += 10)
        		$pdf->rect($x,$y,10,10);
      * @Secure(roles="ROLE_USER")
     */  
        
        $pdf->setFillColor(200);
        $pdf->setLeftMargin(4);
        // Follower
        $pdf->setFont('Arial','BU',11);
        $pdf->setY(63);
        $pdf->cell(20,7,utf8_decode('suivi par : '),0,0);
        $pdf->setFont('Arial','B',11);
        $pdf->cell(65,7,utf8_decode($entity->getFollowerCp()),0,1);
        
        // Door
        $pdf->setFont('Arial','BU',11);
        $pdf->cell(15,5,utf8_decode('affaire : '),0,0);
        $pdf->setFont('Arial','',11);
        $pdf->multiCell(90,5,utf8_decode($entity->getDoorCp()));
        
         
        // Trustee
        $pdf->setXY(130,69.5);
        $pdf->multiCell(80,5,utf8_decode($entity->getTrusteeName().chr(10).$entity->getTrusteeAddress()));

        // Contact
        $pdf->setFont('Arial','',10);
        $pdf->setXY(130,93);
        $pdf->cell(40,5,utf8_decode('à l\'attention de '.$entity->getContactCp()),0,1);
        
        // Création
        $pdf->setFont('Arial','B',10);
        $pdf->setY(93);
        $pdf->cell(22,6,'Date','LRT',0,'C',true);
        $pdf->cell(19,6,utf8_decode('Devis n°'),'LRT',1,'C',true);
        $pdf->setFont('Arial','',10);
        $pdf->cell(22,6,$entity->getCreation()->format('d/m/Y'),'LRB',0,'C');
        $pdf->cell(19,6,$entity->getNumber(),'LRB',1,'C');
        
        $pdf->cell(0,3,'',0,1);
        
        // En tête lignes
        $pdf->setFont('Arial','B',10);
        
        $pdf->cell(22,6,utf8_decode('Référence'),1,0,'C',true);
        $pdf->cell(19,6,utf8_decode('Quantité'),1,0,'C',true);
        $pdf->cell(101,6,utf8_decode('Désignation'),1,0,'C',true);
        $pdf->cell(24.5,6,utf8_decode('Prix U.H.T'),1,0,'C',true);
        $pdf->cell(25,6,utf8_decode('Prix H.T'),1,1,'C',true);
        
        
        
        // Lignes
        $pdf->setFont('Arial','',10);
        $lines = $entity->getLines();
	    foreach ($lines as $line)
	    {
	        $pdf->cell(22,7,utf8_decode($line->getReference()),'RL',0);
	        $pdf->cell(19,7,$line->getQuantity(),'RL',0,'R');
	        $pdf->cell(101,7,utf8_decode($line->getDesignation()),'RL',0);
	        $pdf->cell(24.5,7,number_format($line->getUnitPrice()*(1-$line->getDiscount()),2,',',' ').' '.chr(128),'RL',0,'R');
	        $pdf->cell(25,7,number_format($line->getPrice(),2,',',' ').' '.chr(128),'RL',1,'R');        
	        if ($line->getShowDescription())
	        {
	        	$y = $pdf->getY() - 2;
	        	$pdf->setXY(45,$y);
	        	$pdf->setFont('Arial','I',10);
	        	$pdf->multiCell(101,5,utf8_decode($line->getDescription()),0,1);
	        	$pdf->setFont('Arial','',10);
	        	$h = $pdf->getY() - $y;
	        	$pdf->setY($y);
	        	$pdf->cell(22,$h,'','RL',0);
	        	$pdf->cell(19,$h,'','RL',0);
	        	$pdf->cell(101,$h,'','RL',0);
	        	$pdf->cell(24.5,$h,'','RL',0);
	        	$pdf->cell(25,$h,'','RL',1);
	        	
	        }
	    }
	    $h=20;
	    $pdf->cell(22,$h,'','RL',0);
	    $pdf->cell(19,$h,'','RL',0);
	    $pdf->cell(101,$h,'','RL',0);
	    $pdf->cell(24.5,$h,'','RL',0);
	    $pdf->cell(25,$h,'','RL',1);
	    $pdf->setFont('Arial','B',10);
	    $pdf->cell(166.5,6,'MONTANT TOTAL H.T',1,0,'R',true);
	    $pdf->cell(25,6,number_format($entity->getTotalPrice(),2,',',' ').' '.chr(128),1,1,'R',true);
	    
	    $pdf->setFont('Arial','',10);
	    $pdf->cell(22,6,'Tx T.V.A',1,0,'R');
	    $pdf->cell(19,6,number_format($entity->getVat()*100,1,',',' ').' %',1,0,'R');
	    $pdf->cell(101,6,'',1,0);
	    $pdf->setFont('Arial','B',10);
	    $pdf->cell(24.5,6,'montant TVA',1,0);
	    $pdf->cell(25,6,number_format($entity->getTotalVat(),2,',',' ').' '.chr(128),1,1,'R');
	    
	    $pdf->cell(142,6,'',1,0);
	    $pdf->cell(24.5,6,'TOTAL T.T.C',1,0);
	    $pdf->cell(25,6,number_format($entity->getTotalPriceAti(),2,',',' ').' '.chr(128),1,1,'R');
	    
	    $pdf->cell(0,6,'',0,1);
	    
	    // Observations
	    $pdf->setFont('Arial','',10);
	    $pdf->cell(142,6,utf8_decode('Réservé au client'),1,0,'C',true);
	    $pdf->cell(49.5,6,utf8_decode('BON POUR ACCORD'),1,1,'C',true);
	    $pdf->setFont('Arial','IU',10);
	    $pdf->cell(142,6,utf8_decode('Observations éventuelles'),'LR',0,'C');
	    $pdf->cell(49.5,6,utf8_decode('Tampon, date et signature'),'LR',1,'C');
	    $pdf->cell(142,20,'','LRB',0);
	    $pdf->cell(49.5,20,'','LRB',1);
	    
	    // Réglement
	    $pdf->cell(0,6,'',0,1);
	    $pdf->setFont('Arial','BU',10);
	    $pdf->cell(0,5,utf8_decode('Réglement'),0,1);
	    $pdf->setFont('Arial','',10);
	    $pdf->cell(0,5,utf8_decode($entity->getPaymentRules()),0,1);
	    
	    // Délais
	    $pdf->cell(0,6,'',0,1);
	    $pdf->setFont('Arial','BU',10);
	    $pdf->cell(0,5,utf8_decode('Délais'),0,1);
	    $pdf->setFont('Arial','',10);
	    $pdf->cell(0,5,utf8_decode($entity->getDeliveryRules()),0,1);
	    
	    // Délais
	    
	    $ct = substr($entity->getContactCp(),0,2);
	    if ($ct == 'M.')
	    	$who = 'Monsieur';
	    elseif ($ct == 'Mm')
	    	$who = 'Madame';
	    elseif ($ct == 'Ml')
	   		$who = 'Mademoiselle';
	    else
	    	$who = 'Madame, Monsieur';
	    $pdf->cell(0,6,'',0,1);
	    $pdf->multiCell(0,5,utf8_decode('Nous vous en souhaitons bonne récéption et vous prions d\'agréer, '.$who.' l\'expression de nos'.chr(10).'sentiments les meilleurs.'),0,1);
	    
	    
        $content = $pdf->Output('','S');
        $response = new Response();
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'inline; filename=essai.pdf');
        $response->setContent($content);
         
        return $response;
   }
}

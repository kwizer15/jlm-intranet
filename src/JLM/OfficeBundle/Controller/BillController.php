<?php

namespace JLM\OfficeBundle\Controller;


use JMS\SecurityExtraBundle\Annotation\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use JLM\BillBundle\Builder\BillFactory;
use JLM\CommerceBundle\Entity\Bill;
use JLM\CommerceBundle\Entity\BillLine;
use JLM\DailyBundle\Entity\Intervention;
use JLM\DailyBundle\Builder\WorkBillBuilder;
use JLM\DailyBundle\Builder\InterventionBillBuilder;
use JLM\DailyBundle\Entity\Work;
use JLM\DefaultBundle\Controller\PaginableController;
use JLM\DefaultBundle\Entity\Search;
use JLM\DefaultBundle\Form\Type\SearchType;
use JLM\OfficeBundle\Form\Type\BillType;
use JLM\OfficeBundle\Entity\QuoteVariant;
use JLM\OfficeBundle\Builder\VariantBillBuilder;
use JLM\ModelBundle\Entity\Door;
use JLM\ModelBundle\Builder\DoorBillBuilder;
use JLM\DailyBundle\Form\Type\ExternalBillType;


/**
 * Bill controller.
 *
 * @Route("/bill")
 */
class BillController extends PaginableController
{
	/**
	 * @Route("/", name="bill")
	 * @Route("/page/{page}", name="bill_page")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function indexAction($page = 1)
	{
		return $this->pagination('JLMCommerceBundle:Bill','All',$page,10,'bill_page');
	}
	
	/**
	 * @Route("/inseizure", name="bill_listinseizure")
	 * @Route("/inseizure/page/{page}", name="bill_listinseizure_page")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function listinseizureAction($page = 1)
	{
		return $this->pagination('JLMCommerceBundle:Bill','InSeizure',$page,10,'bill_listinseizure_page');
	}
	
	/**
	 * @Route("/sended", name="bill_listsended")
	 * @Route("/sended/page/{page}", name="bill_listsended_page")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function listsendedAction($page = 1)
	{
		return $this->pagination('JLMCommerceBundle:Bill','Sended',$page,10,'bill_listsended_page');
	}
	
	/**
	 * @Route("/payed", name="bill_listpayed")
	 * @Route("/payed/page/{page}", name="bill_listpayed_page")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function listpayedAction($page = 1)
	{
		return $this->pagination('JLMCommerceBundle:Bill','Payed',$page,10,'bill_listpayed_page');
	}
	
	/**
	 * @Route("/canceled", name="bill_listcanceled")
	 * @Route("/canceled/page/{page}", name="bill_listcanceled_page")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function listcanceledAction($page = 1)
	{
		return $this->pagination('JLMCommerceBundle:Bill','Canceled',$page,10,'bill_listcanceled_page');
	}
    
    /**
     * Finds and displays a Bill entity.
     *
     * @Route("/{id}/show", name="bill_show")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function showAction(Bill $entity)
    {
        return array('entity'=> $entity);
    }
    
    /**
     * Displays a form to create a new Bill entity.
     *
     * @Route("/new", name="bill_new")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function newAction()
    {
        $entity = new Bill();
        $entity->setCreation(new \DateTime);
		$em = $this->getDoctrine()->getManager();
		$vat = $em->getRepository('JLMModelBundle:VAT')->find(1)->getRate();
		$entity->setVat($vat);
		$entity = $this->finishNewBill($entity);
        $entity->addLine(new BillLine());
        $form   = $this->createForm(new BillType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }
    
    /**
     * Displays a form to create a new Bill entity.
     *
     * @Route("/new/door/{id}", name="bill_new_door")
     * @Template("JLMOfficeBundle:Bill:new.html.twig")
     * @Secure(roles="ROLE_USER")
     * @deprecated No used
     */
    public function newdoorAction(Door $door)
    {
    	$entity = BillFactory::create(new DoorBillBuilder($door));
    	$form   = $this->createForm(new BillType(), $entity);
    
    	return array(
    			'entity' => $entity,
    			'form'   => $form->createView()
    	);
    }

    /**
     * Displays a form to create a new Bill entity.
     *
     * @Route("/new/quote/{id}", name="bill_new_quotevariant")
     * @Template("JLMOfficeBundle:Bill:new.html.twig")
     * @Secure(roles="ROLE_USER")
     * @deprecated
     */
    public function newquoteAction(QuoteVariant $quote)
    {
        $entity = BillFactory::create(new VariantBillBuilder($quote));
    	$form   = $this->createForm(new BillType(), $entity);
    
    	return array(
    			'entity' => $entity,
    			'form'   => $form->createView()
    	);
    }
    
    /**
     * Displays a form to create a new Bill entity.
     *
     * @Route("/new/intervention/{id}", name="bill_new_intervention")
     * @Template("JLMOfficeBundle:Bill:new.html.twig")
     * @Secure(roles="ROLE_USER")
     */
    public function newinterventionAction(Intervention $interv)
    {
        $em = $this->getDoctrine()->getManager();
        $options = array(
            'penalty' => (string)$em->getRepository('JLMOfficeBundle:PenaltyModel')->find(1),
            'property' => (string)$em->getRepository('JLMOfficeBundle:PropertyModel')->find(1),
            'earlyPayment' => (string)$em->getRepository('JLMOfficeBundle:EarlyPaymentModel')->find(1),
        );
        $builder = ($interv instanceof Work) ? (($interv->getQuote() !== null) ? new WorkBillBuilder($interv, $options) : null) : null;
        $builder = ($builder === null) ? new InterventionBillBuilder($interv, $options) : $builder;
        $entity = BillFactory::create($builder);

    	$form   = $this->createForm(new BillType(), $entity);
    
    	return array(
    			'entity' => $entity,
    			'form'   => $form->createView()
    	);
    }
    
    /**
     * Finish Bill
     */
    public function finishNewBill(Bill $entity)
    {
    	$em = $this->getDoctrine()->getManager();
    	$entity->setPenalty($em->getRepository('JLMOfficeBundle:PenaltyModel')->find(1).'');
    	$entity->setProperty($em->getRepository('JLMOfficeBundle:PropertyModel')->find(1).'');
    	$entity->setEarlyPayment($em->getRepository('JLMOfficeBundle:EarlyPaymentModel')->find(1).'');
    	$entity->setMaturity(30);
    	return $entity;
    }
    
    /**
     * Creates a new Bill entity.
     *
     * @Route("/create", name="bill_create")
     * @Method("post")
     * @Template("JLMOfficeBundle:Bill:new.html.twig")
     * @Secure(roles="ROLE_USER")
     */
    public function createAction(Request $request)
    {
        $entity  = new Bill();
        $em = $this->getDoctrine()->getManager();
        $vat = $em->getRepository('JLMModelBundle:VAT')->find(1)->getRate();
        $entity->setVatTransmitter($vat);
        $form    = $this->createForm(new BillType(), $entity);
        $form->handleRequest($request);
		
        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('bill_show', array('id' => $entity->getId())));  
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Bill entity.
     *
     * @Route("/{id}/edit", name="bill_edit")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function editAction(Bill $entity)
    {
    	// Si le devis est déjà validé, on empèche quelconque modification
    	if ($entity->getState())
    		return $this->redirect($this->generateUrl('bill_show', array('id' => $entity->getId())));
        $editForm = $this->createForm(new BillType(), $entity);
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );

    }

    /**
     * Edits an existing Bill entity.
     *
     * @Route("/{id}/update", name="bill_update")
     * @Method("post")
     * @Template("JLMOfficeBundle:Bill:edit.html.twig")
     * @Secure(roles="ROLE_USER")
     */
    public function updateAction(Request $request, Bill $entity)
    {
    	
    	// Si la facture est déjà validé, on empèche quelconque modification
    	if ($entity->getState())
    		return $this->redirect($this->generateUrl('bill_show', array('id' => $entity->getId())));
    	 
    	$originalLines = array();
    	foreach ($entity->getLines() as $line)
    		$originalLines[] = $line;
        $editForm = $this->createForm(new BillType(), $entity);
        $editForm->handleRequest($request);
        
        if ($editForm->isValid())
        {
        	$em = $this->getDoctrine()->getManager();
        	$em->persist($entity);
	       	$lines = $entity->getLines();
	       	foreach ($lines as $key => $line)
	       	{
	       		$line->setBill($entity);
	       		$em->persist($line);
	       		foreach ($originalLines as $key => $toDel)
	       			if ($toDel->getId() === $line->getId())
	       				unset($originalLines[$key]);
	       	}
	       	foreach ($originalLines as $line)
	       		$em->remove($line);

        	
            $em->flush();
            return $this->redirect($this->generateUrl('bill_show', array('id' => $entity->getId())));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    } 
    
    /**
     * Imprimer la facture
     *
     * @Route("/{id}/print", name="bill_print")
     * @Secure(roles="ROLE_USER")
     */
    public function printAction(Bill $entity)
    {
    	$response = new Response();
    	$response->headers->set('Content-Type', 'application/pdf');
    	$response->headers->set('Content-Disposition', 'inline; filename='.$entity->getNumber().'.pdf');
    	$response->setContent($this->render('JLMOfficeBundle:Bill:print.pdf.php',array('entities'=>array($entity),'duplicate'=>false)));
    
    	//   return array('entity'=>$entity);
    	return $response;
    }
    
    /**
     * Imprimer un duplicata de facture
     *
     * @Route("/{id}/printduplicate", name="bill_printduplicate")
     * @Secure(roles="ROLE_USER")
     */
    public function printduplicateAction(Bill $entity)
    {
    	$response = new Response();
    	$response->headers->set('Content-Type', 'application/pdf');
    	$response->headers->set('Content-Disposition', 'inline; filename='.$entity->getNumber().'-diplicata.pdf');
    	$response->setContent($this->render('JLMOfficeBundle:Bill:print.pdf.php',array('entities'=>array($entity),'duplicate'=>true)));
    
    	//   return array('entity'=>$entity);
    	return $response;
    }
    
    /**
     * Imprimer la liste des factures à faire
     *
     * @Route("/printlist", name="bill_printlist")
     * @Secure(roles="ROLE_USER")
     */
    public function printlistAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$entities = $em->getRepository('JLMDailyBundle:Intervention')->getToBilled();
    	$response = new Response();
    	$response->headers->set('Content-Type', 'application/pdf');
    	$response->headers->set('Content-Disposition', 'inline; filename=factures-a-faire.pdf');
    	$response->setContent($this->render('JLMOfficeBundle:Bill:printlist.pdf.php',array('entities'=>$entities)));
    
    	//   return array('entity'=>$entity);
    	return $response;
    }
    
    /**
     * Note Bill as ready to send.
     *
     * @Route("/{id}/ready", name="bill_ready")
     * @Secure(roles="ROLE_USER")
     */
    public function readyAction(Bill $entity)
    {
    	if ($entity->getState() < 0)
    		return $this->redirect($this->generateUrl('bill_show', array('id' => $entity->getId())));
    
    	if ($entity->getState() < 1)
    		$entity->setState(1);
    	$em = $this->getDoctrine()->getManager();
    	$em->persist($entity);
    	$em->flush();
    	return $this->redirect($this->getRequest()->headers->get('referer'));
    	//return $this->redirect($this->generateUrl('bill_show', array('id' => $entity->getId())));
    }
    
    /**
     * Note Bill as been send.
     *
     * @Route("/{id}/send", name="bill_send")
     * @Secure(roles="ROLE_USER")
     */
    public function sendAction(Bill $entity)
    {
    	if ($entity->getState() != 1)
    		$entity->setState(1);
    	$em = $this->getDoctrine()->getManager();
    	$em->persist($entity);
    	$em->flush();
    	return $this->redirect($this->getRequest()->headers->get('referer'));
    	//return $this->redirect($this->generateUrl('bill_show', array('id' => $entity->getId())));
    }
    
    /**
     * Note Bill as been canceled.
     *
     * @Route("/{id}/cancel", name="bill_cancel")
     * @Secure(roles="ROLE_USER")
     */
    public function cancelAction(Bill $entity)
    {
    	if ($entity->getState() < 1)
    		return $this->redirect($this->generateUrl('bill_show', array('id' => $entity->getId())));
    	if ($entity->getState() > -1)
    		$entity->setState(-1);
    	$em = $this->getDoctrine()->getManager();
    	$em->persist($entity);
    	$em->flush();
    	return $this->redirect($this->getRequest()->headers->get('referer'));
    	//return $this->redirect($this->generateUrl('bill_show', array('id' => $entity->getId())));
    }
    
    /**
     * Note Bill retour à la saisie.
     *
     * @Route("/{id}/back", name="bill_back")
     * @Secure(roles="ROLE_USER")
     */
    public function backAction(Bill $entity)
    {
    	if ($entity->getState() < 1)
    		return $this->redirect($this->generateUrl('bill_show', array('id' => $entity->getId())));
    	if ($entity->getState() > 0)
    		$entity->setState(0);
    	$em = $this->getDoctrine()->getManager();
    	$em->persist($entity);
    	$em->flush();
    	return $this->redirect($this->getRequest()->headers->get('referer'));
    	//return $this->redirect($this->generateUrl('bill_show', array('id' => $entity->getId())));
    }
    
    /**
     * Note Bill réglée.
     *
     * @Route("/{id}/payed", name="bill_payed")
     * @Secure(roles="ROLE_USER")
     */
    public function payedAction(Bill $entity)
    {
    	if ($entity->getState() > 1)
    		return $this->redirect($this->generateUrl('bill_show', array('id' => $entity->getId())));
    	if ($entity->getState() == 1)
    		$entity->setState(2);
    	$em = $this->getDoctrine()->getManager();
    	$em->persist($entity);
    	$em->flush();
    	return $this->redirect($this->getRequest()->headers->get('referer'));
    	//return $this->redirect($this->generateUrl('bill_show', array('id' => $entity->getId())));
    }
    
    /**
     * Sidebar
     * @Route("/sidebar", name="bill_sidebar")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function sidebarAction()
    {
    	$em = $this->getDoctrine()->getManager();
    
    	return array('count'=>array(
    			'todo' => $em->getRepository('JLMDailyBundle:Intervention')->getCountToBilled(),
    			'all' => $em->getRepository('JLMCommerceBundle:Bill')->getTotal(),
    			'input' => $em->getRepository('JLMCommerceBundle:Bill')->getCount(0),
    			'send' => $em->getRepository('JLMCommerceBundle:Bill')->getCount(1),
    			'payed' => $em->getRepository('JLMCommerceBundle:Bill')->getCount(2),
    			'canceled' => $em->getRepository('JLMCommerceBundle:Bill')->getCount(-1),
    	));
    }
    
    /**
     * @Route("/todo", name="bill_todo")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function todoAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$list = $em->getRepository('JLMDailyBundle:Intervention')->getToBilled();
    	$forms_externalBill = array();
    	foreach ($list as $interv)
    	{
    		$forms_externalBill[] = $this->get('form.factory')->createNamed('externalBill'.$interv->getId(),new ExternalBillType(), $interv)->createView();
    	}
    	return array(
    			'entities'=>$list,
    			'forms_externalbill' => $forms_externalBill,
    	);
    }
    
    /**
     * @Route("/toboost", name="bill_toboost")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function toboostAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$bills = $em->getRepository('JLMCommerceBundle:Bill')->getToBoost();
    	
    	return array('entities'=>$bills);
    }
    
    /**
     * Imprimer le courrier de relance 
     *
     * @Route("/{id}/printboost", name="bill_printboost")
     * @Secure(roles="ROLE_USER")
     */
    public function printboostAction(Bill $entity)
    {
    	$response = new Response();
    	$response->headers->set('Content-Type', 'application/pdf');
    	$response->headers->set('Content-Disposition', 'inline; filename='.$entity->getNumber().'.pdf');
    	$response->setContent($this->render('JLMOfficeBundle:Bill:printboost.pdf.php',array('entities'=>array($entity))));
    
    	//   return array('entity'=>$entity);
    	return $response;
    }
    
    /**
     * Noter relance effectuée
     * 
     * @Route("/{id}/boostok", name="bill_boostok")
     * @Secure(roles="ROLE_USER")
     */
    public function boostokAction(Bill $entity)
    {
    	if ($entity->getFirstBoost() === null)
    		$entity->setFirstBoost(new \DateTime);
    	else
    		$entity->setSecondBoost(new \DateTime);
    	$em = $this->getDoctrine()->getManager();
    	$em->persist($entity);
    	$em->flush();
    	return $this->redirect($this->generateUrl('bill_toboost'));
    }
    
    /**
     * @Route("/search",name="bill_search")
     * @Method("POST")
     * @Template()
     */
    public function searchAction(Request $request)
    {
    	$entity = new Search();
    	$form = $this->createForm(new SearchType(), $entity);
    	$form->handleRequest($request);
    	if ($form->isValid())
    	{
    		$em = $this->getDoctrine()->getManager();
    		return array(
    				'layout'=>array('form_search_query'=>$entity),
    				'bills' => $em->getRepository('JLMCommerceBundle:Bill')->search($entity),
    		);
    	}
    	return array('layout'=>array('form_search_query'=>$entity),);
    }
}

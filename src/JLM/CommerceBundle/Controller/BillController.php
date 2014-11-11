<?php

/*
 * This file is part of the JLMCommerceBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CommerceBundle\Controller;

use JMS\SecurityExtraBundle\Annotation\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use JLM\BillBundle\Builder\BillFactory;
use JLM\CommerceBundle\Entity\Bill;
use JLM\CommerceBundle\Entity\BillLine;
use JLM\CommerceBundle\Form\Type\BillType;
use JLM\CommerceBundle\Model\BillInterface;
use JLM\CommerceBundle\Entity\QuoteVariant;
use JLM\OfficeBundle\Builder\VariantBillBuilder;
use JLM\DailyBundle\Entity\Intervention;
use JLM\DailyBundle\Builder\WorkBillBuilder;
use JLM\DailyBundle\Builder\InterventionBillBuilder;
use JLM\DailyBundle\Entity\Work;
use JLM\DefaultBundle\Controller\PaginableController;
use JLM\DefaultBundle\Entity\Search;
use JLM\DefaultBundle\Form\Type\SearchType;
use JLM\ModelBundle\Entity\Door;
use JLM\ModelBundle\Builder\DoorBillBuilder;
use JLM\DailyBundle\Form\Type\ExternalBillType;


/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class BillController extends PaginableController
{
	/**
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function indexAction($page = 1)
	{
		return $this->pagelist('All', $page, 'bill_page');
	}
	
	/**
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function listinseizureAction($page = 1)
	{
		return $this->pagelist('InSeizure', $page, 'bill_listinseizure_page');
	}
	
	/**
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function listsendedAction($page = 1)
	{
		return $this->pagelist('Sended', $page, 'bill_listsended_page');
	}
	
	/**
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function listpayedAction($page = 1)
	{
		return $this->pagelist('Payed', $page, 'bill_listpayed_page');
	}
	
	/**
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function listcanceledAction($page = 1)
	{
		return $this->pagelist('Canceled', $page, 'bill_listcanceled_page');
	}
    
    /**
     * Finds and displays a Bill entity.
     *
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
        $form   = $this->createNewForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }
    
    /**
     * Displays a form to create a new Bill entity.
     *
     * @Template("JLMCommerceBundle:Bill:new.html.twig")
     * @Secure(roles="ROLE_USER")
     * @deprecated No used
     */
    public function newdoorAction(Door $door)
    {
    	$entity = BillFactory::create(new DoorBillBuilder($door));
    	$form   = $this->createNewForm($entity);
    
    	return array(
    			'entity' => $entity,
    			'form'   => $form->createView()
    	);
    }

    /**
     * Displays a form to create a new Bill entity.
     * 
     * @Template("JLMCommerceBundle:Bill:new.html.twig")
     * @Secure(roles="ROLE_USER")
     * @deprecated
     */
    public function newquoteAction(QuoteVariant $quote)
    {
        $entity = BillFactory::create(new VariantBillBuilder($quote));
    	$form   = $this->createNewForm($entity);
    
    	return array(
    			'entity' => $entity,
    			'form'   => $form->createView()
    	);
    }
    
    /**
     * Displays a form to create a new Bill entity.
     *
     * @Template("JLMCommerceBundle:Bill:new.html.twig")
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

    	$form   = $this->createNewForm($entity);
    
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
     * @Template("JLMCommerceBundle:Bill:new.html.twig")
     * @Secure(roles="ROLE_USER")
     */
    public function createAction(Request $request)
    {
        $entity  = new Bill();
        $em = $this->getDoctrine()->getManager();
        $vat = $em->getRepository('JLMModelBundle:VAT')->find(1)->getRate();
        $entity->setVatTransmitter($vat);
        $form    = $this->createNewForm($entity);
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
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function editAction(Bill $entity)
    {
    	// Si le devis est déjà validé, on empèche quelconque modification
    	if ($entity->getState())
    	{
    		return $this->redirect($this->generateUrl('bill_show', array('id' => $entity->getId())));
    	}
        $editForm = $this->createEditForm($entity);
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );

    }

    /**
     * Edits an existing Bill entity.
     *
     * @Template("JLMCommerceBundle:Bill:edit.html.twig")
     * @Secure(roles="ROLE_USER")
     */
    public function updateAction(Request $request, Bill $entity)
    {
    	// Si la facture est déjà validé, on empèche quelconque modification
    	if ($entity->getState())
    	{
    		return $this->redirect($this->generateUrl('bill_show', array('id' => $entity->getId())));
    	}
    	 
    	$originalLines = array();
    	foreach ($entity->getLines() as $line)
    	{
    	   $originalLines[] = $line;
    	}
        $editForm = $this->createEditForm($entity);
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
	       		{
	       			if ($toDel->getId() === $line->getId())
	       			{
	       				unset($originalLines[$key]);
	       			}
	       		}
	       	}
	       	foreach ($originalLines as $line)
	       	{
	       		$em->remove($line);
	       	}
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
     * @Secure(roles="ROLE_USER")
     */
    public function printAction(Bill $entity)
    {
        return $this->printer($entity);
    }
    
    /**
     * Imprimer un duplicata de facture
     *
     * @Secure(roles="ROLE_USER")
     */
    public function printduplicateAction(Bill $entity)
    {
    	return $this->printer($entity, true);
    }
    
    private function printer(BillInterface $entity, $duplicate = false)
    {
        $filename = $entity->getNumber();
        if ($duplicate)
        {
            $filename .= '-duplicata';
        }
        
        $filename .= '.pdf';
            
        $response = new Response();
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'inline; filename='.$filename);
        $response->setContent($this->render('JLMCommerceBundle:Bill:print.pdf.php',array('entities'=>array($entity),'duplicate'=>$duplicate)));
        
        return $response;
    }
    
    /**
     * Imprimer la liste des factures à faire
     *
     * @Secure(roles="ROLE_USER")
     */
    public function printlistAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$entities = $em->getRepository('JLMDailyBundle:Intervention')->getToBilled();
    	$response = new Response();
    	$response->headers->set('Content-Type', 'application/pdf');
    	$response->headers->set('Content-Disposition', 'inline; filename=factures-a-faire.pdf');
    	$response->setContent($this->render('JLMCommerceBundle:Bill:printlist.pdf.php',array('entities'=>$entities)));
    
    	//   return array('entity'=>$entity);
    	return $response;
    }
    
    /**
     * Note Bill as ready to send.
     *
     * @Secure(roles="ROLE_USER")
     */
    public function readyAction(Bill $entity)
    {
    	return $this->stateChange($entity, 1);
    }
    
    /**
     * Note Bill as been send.
     *
     * @Secure(roles="ROLE_USER")
     */
    public function sendAction(Bill $entity)
    {
    	if ($entity->getState() != 1)
    	{
    		$entity->setState(1);
    	}
    	$em = $this->getDoctrine()->getManager();
    	$em->persist($entity);
    	$em->flush();
    	
    	return $this->redirect($this->getRequest()->headers->get('referer'));
    }
    
    /**
     * Note Bill as been canceled.
     *
     * @Secure(roles="ROLE_USER")
     */
    public function cancelAction(Bill $entity)
    {
    	return $this->stateChange($entity, -1);
    }
    
    /**
     * Note Bill retour à la saisie.
     *
     * @Secure(roles="ROLE_USER")
     */
    public function backAction(Bill $entity)
    {
    	return $this->stateChange($entity, 0);
    }
    
    /**
     * Note Bill réglée.
     *
     * @Secure(roles="ROLE_USER")
     */
    public function payedAction(Bill $entity)
    {
    	return $this->stateChange($entity, 2);
    }
    
    private function stateChange(Bill $entity, $newState)
    {
        switch ($newState)
        {
        	case 1:
        	    $redirect = ($entity->getState() < 0);    
        	    $set = ($entity->getState() < $newState);
        	    break;
        	case 2:
        	    $redirect = ($entity->getState() > 1);
        	    $set = ($entity->getState() == 1);
        	    break;
        	case -1:
        	case 0:
        	    $redirect = ($entity->getState() < 1);
        	    $set = ($entity->getState() > $newState);
        	    break;

        }
        if ($redirect)
        {
            return $this->redirect($this->generateUrl('bill_show', array('id' => $entity->getId())));
        }
        if ($set)
        {
            $entity->setState($newState);
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($entity);
        $em->flush();
         
        return $this->redirect($this->getRequest()->headers->get('referer'));
    }
    
    /**
     * Sidebar
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
     * @Secure(roles="ROLE_USER")
     */
    public function printboostAction(Bill $entity)
    {
    	$response = new Response();
    	$response->headers->set('Content-Type', 'application/pdf');
    	$response->headers->set('Content-Disposition', 'inline; filename='.$entity->getNumber().'.pdf');
    	$response->setContent($this->render('JLMCommerceBundle:Bill:printboost.pdf.php',array('entities'=>array($entity))));
    
    	//   return array('entity'=>$entity);
    	return $response;
    }
    
    /**
     * Noter relance effectuée
     * 
     * @Secure(roles="ROLE_USER")
     */
    public function boostokAction(Bill $entity)
    {
        $date = new \DateTime;
    	if ($entity->getFirstBoost() === null)
    	{
    		$entity->setFirstBoost($date);
    	}
    	else
    	{
    		$entity->setSecondBoost($date);
    	}
    	$em = $this->getDoctrine()->getManager();
    	$em->persist($entity);
    	$em->flush();
    	
    	return $this->redirect($this->generateUrl('bill_toboost'));
    }
    
    /**
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
    
    private function createNewForm(BillInterface $entity)
    {
        return $this->createForm(new BillType(), $entity);
    }
    
    private function createEditForm(BillInterface $entity)
    {
        return $this->createForm(new BillType(), $entity);
    }
    
    private function pagelist($functiondata, $page, $route)
    {
        return $this->pagination('JLMCommerceBundle:Bill', $functiondata, $page, 10, $route);
    }
}

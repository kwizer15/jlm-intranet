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
use JLM\OfficeBundle\Entity\Bill;
use JLM\OfficeBundle\Entity\QuoteVariant;
use JLM\OfficeBundle\Form\Type\BillType;
use JLM\OfficeBundle\Entity\BillLine;
use JLM\ModelBundle\Entity\Door;
use JLM\DailyBundle\Entity\Intervention;
use JLM\DailyBundle\Form\Type\ExternalBillType;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use JLM\DefaultBundle\Entity\Search;
use JLM\DefaultBundle\Form\Type\SearchType;



/**
 * Bill controller.
 *
 * @Route("/bill")
 */
class BillController extends Controller
{
    /**
     * Lists all Bill entities.
     *
     * @Route("/", name="bill")
     * @Route("/page/{page}", name="bill_page")
     * @Route("/page/{page}/state/{state}", name="bill_state")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function indexAction($page = 1, $state = null)
    {
    	$limit = 10;
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('JLMOfficeBundle:Bill');
        $nb = $repo->getCount($state);
        	
        $nbPages = ceil($nb/$limit);
        $nbPages = ($nbPages < 1) ? 1 : $nbPages;
        $offset = ($page-1) * $limit;
        if ($page < 1 || $page > $nbPages)
        {
        	throw $this->createNotFoundException('Page insexistante (page '.$page.'/'.$nbPages.')');
        }
        
        $entities = $repo->getByState(
        		$state,
        		$limit,
        		$offset
        );
        
        return array(
        		'entities' => $entities,
        		'page'     => $page,
        		'nbPages'  => $nbPages,
        		'state' => $state,
        );
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
		$this->finishNewBill($entity);
        $entity->addLine(new BillLine);
        $form   = $this->createForm(new BillType, $entity);

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
     */
    public function newdoorAction(Door $door)
    {
    	$entity = new Bill();
    	$entity->setCreation(new \DateTime);
    	$entity->populateFromDoor($door);
    	$this->finishNewBill($entity);
    	$entity->addLine(new BillLine);
    	$form   = $this->createForm(new BillType, $entity);
    
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
     */
    public function newquoteAction(QuoteVariant $quote)
    {
    	$entity = new Bill();
    	$entity->setCreation(new \DateTime);
    	$entity->populateFromQuoteVariant($quote);
    	$this->finishNewBill($entity);
    	$form   = $this->createForm(new BillType, $entity);
    
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
    	$entity = new Bill();
    	$entity->setCreation(new \DateTime);
    	
    	$entity->populateFromIntervention($interv);
    	$this->finishNewBill($entity);
    	$form   = $this->createForm(new BillType, $entity);
    
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
        $form->bind($request);
		
        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $number = $entity->getCreation()->format('ym');
            $n = ($em->getRepository('JLMOfficeBundle:Bill')->getLastNumber() + 1);
            for ($i = strlen($n); $i < 4 ; $i++)
            	$number.= '0';
            $number.= $n;
            $entity->setNumber($number);
            $lines = $entity->getLines();
            foreach ($lines as $line)
            {
            	$line->setBill($entity);
            	$em->persist($line);
            }
            $em->persist($entity);
            $interv = $entity->getIntervention();
            if ($interv !== null)
            {
            	$interv->setBill($entity);
            	$em->persist($interv);
            }
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
        $editForm->bind($request);
        
        if ($editForm->isValid()) {
        	$em = $this->getDoctrine()->getManager();
        	$em->persist($entity);

            foreach ($entity->getLines() as $key => $line)
            {
            
            	// Nouvelles lignes
            	$line->setBill($entity);
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
    	return $this->redirect($this->generateUrl('bill_show', array('id' => $entity->getId())));
    }
    
    /**
     * Note Bill as been send.
     *
     * @Route("/{id}/send", name="bill_send")
     * @Secure(roles="ROLE_USER")
     */
    public function sendAction(Bill $entity)
    {
    	if ($entity->getState() > 1)
    		return $this->redirect($this->generateUrl('bill_show', array('id' => $entity->getId())));
    
    	if ($entity->getState() < 1)
    		$entity->setState(1);
    	$em = $this->getDoctrine()->getManager();
    	$em->persist($entity);
    	$em->flush();
    	return $this->redirect($this->generateUrl('bill_show', array('id' => $entity->getId())));
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
    	return $this->redirect($this->generateUrl('bill_show', array('id' => $entity->getId())));
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
    	return $this->redirect($this->generateUrl('bill_show', array('id' => $entity->getId())));
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
    	return $this->redirect($this->generateUrl('bill_show', array('id' => $entity->getId())));
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
    			'all' => $em->getRepository('JLMOfficeBundle:Bill')->getTotal(),
    			'input' => $em->getRepository('JLMOfficeBundle:Bill')->getCount(0),
    			'send' => $em->getRepository('JLMOfficeBundle:Bill')->getCount(1),
    			'payed' => $em->getRepository('JLMOfficeBundle:Bill')->getCount(2),
    			'canceled' => $em->getRepository('JLMOfficeBundle:Bill')->getCount(-1),
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
    	$bills = $em->getRepository('JLMOfficeBundle:Bill')->getToBoost();
    	
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
    	$entity = new Search;
    	$form = $this->createForm(new SearchType(), $entity);
    	$form->handleRequest($request);
    	if ($form->isValid())
    	{
    		$em = $this->getDoctrine()->getManager();
    		return array(
    				'layout'=>array('form_search_query'=>$entity),
    				'bills' => $em->getRepository('JLMOfficeBundle:Bill')->search($entity),
    		);
    	}
    	return array('layout'=>array('form_search_query'=>$entity->getQuery()),);
    }
}

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
use Symfony\Component\Security\Core\Exception\AccessDeniedException;



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
        $em = $this->getDoctrine()->getEntityManager();
        if ($state === null)
        	$nb = $em->getRepository('JLMOfficeBundle:Bill')->getTotal();
        else
        	$nb = $em->getRepository('JLMOfficeBundle:Bill')->getCount($state);
        $nbPages = ceil($nb/$limit);
        $nbPages = ($nbPages < 1) ? 1 : $nbPages;
        $offset = ($page-1) * $limit;
        if ($page < 1 || $page > $nbPages)
        {
        	throw $this->createNotFoundException('Page insexistante (page '.$page.'/'.$nbPages.')');
        }
        
        $entities = $em->getRepository('JLMOfficeBundle:Bill')->getByState(
        		$state,
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
		$em = $this->getDoctrine()->getEntityManager();
		$vat = $em->getRepository('JLMModelBundle:VAT')->find(1)->getRate();
		$entity->setVat($vat);
        $entity->addLine(new BillLine);
        $entity->setVatTransmitter($vat);
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
    	$em = $this->getDoctrine()->getEntityManager();
    	$vat = $em->getRepository('JLMModelBundle:VAT')->find(1)->getRate();
    	$entity->populateFromDoor($door);
    	$entity->addLine(new BillLine);
    	$entity->setVatTransmitter($vat);
    	$form   = $this->createForm(new BillType, $entity);
    
    	return array(
    			'entity' => $entity,
    			'form'   => $form->createView()
    	);
    }

    /**
     * Displays a form to create a new Bill entity.
     *
     * @Route("/new/quote/{id}", name="bill_new_quote")
     * @Template("JLMOfficeBundle:Bill:new.html.twig")
     * @Secure(roles="ROLE_USER")
     */
    public function newquoteAction(QuoteVariant $quote)
    {
    	$entity = new Bill();
    	$entity->populateFromQuoteVariant($quote);
    	$form   = $this->createForm(new BillType, $entity);
    
    	return array(
    			'entity' => $entity,
    			'form'   => $form->createView()
    	);
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
        $form    = $this->createForm(new BillType(), $entity);
        $form->bind($request);
		
        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getEntityManager();
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
    	
    	// Si le devis est déjà validé, on empèche quelconque modification
    	if ($entity->getState())
    		return $this->redirect($this->generateUrl('bill_show', array('id' => $entity->getId())));
    	 
        $editForm = $this->createForm(new BillType(), $entity);
        $editForm->bind($request);
        
        if ($editForm->isValid()) {
        	$em = $this->getDoctrine()->getEntityManager();
        	$em->persist($entity);
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
    	$response->setContent($this->render('JLMOfficeBundle:Bill:print.pdf.php',array('entities'=>array($entity))));
    
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
    	$em = $this->getDoctrine()->getEntityManager();
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
    	$em = $this->getDoctrine()->getEntityManager();
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
    	$em = $this->getDoctrine()->getEntityManager();
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
    	$em = $this->getDoctrine()->getEntityManager();
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
    	$em = $this->getDoctrine()->getEntityManager();
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
    	$em = $this->getDoctrine()->getEntityManager();
    
    	return array(
    			'all' => $em->getRepository('JLMOfficeBundle:Bill')->getTotal(),
    			'input' => $em->getRepository('JLMOfficeBundle:Bill')->getCount(0),
    			'send' => $em->getRepository('JLMOfficeBundle:Bill')->getCount(1),
    			'payed' => $em->getRepository('JLMOfficeBundle:Bill')->getCount(2),
    			'canceled' => $em->getRepository('JLMOfficeBundle:Bill')->getCount(-1),
    	);
    }
}

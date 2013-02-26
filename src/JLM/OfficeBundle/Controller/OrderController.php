<?php

namespace JLM\OfficeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use JLM\OfficeBundle\Entity\Order;
use JLM\OfficeBundle\Entity\OrderLine;
use JLM\OfficeBundle\Form\Type\OrderType;
use JLM\OfficeBundle\Entity\QuoteVariant;





/**
 * Order controller.
 *
 * @Route("/order")
 */
class OrderController extends Controller
{
	/**
	 * Lists all Order entities.
	 *
	 * @Route("/", name="order")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function indexAction()
	{
		$em = $this->getDoctrine()->getEntityManager();
		$entities = $em->getRepository('JLMOfficeBundle:Order')->findAll();
		return array(
				'entities' => $entities
				);
	}
	
	/**
	 * Finds and displays an Order entity.
	 *
	 * @Route("/{id}/show", name="order_show")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function showAction(Order $entity)
	{
		return array('entity'=> $entity);
	}
	
	/**
	 * Displays a form to create a new Bill entity.
	 *
	 * @Route("/new", name="order_new")
	 * @Route("/new/quotevariant/{id}", name="order_new_quotevariant")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function newAction(QuoteVariant $variant = null)
	{
		$entity = new Order();
		if ($variant)
		{
			$entity->setPlace($variant->getQuote()->getDoorCp());
			$entity->setQuote($variant);
			$vlines = $variant->getLines();
			foreach ($vlines as $vline)
			{
				$flag = true;
				if ($product = $vline->getProduct())
					if ($category = $product->getCategory())
						if ($category->getId() != 2)
							$flag = false;
				if ($flag)
				{
					$oline = new OrderLine;
					$oline->setReference($vline->getReference());
					$oline->setQuantity($vline->getQuantity());
					$oline->setDesignation($vline->getDesignation());
					$entity->addLine($oline);
				}
			}
		}
		else
			$entity->addLine(new OrderLine);
		$form   = $this->createForm(new OrderType(), $entity);
		return array(
				'entity' => $entity,
				'form'   => $form->createView()
		);
	}
	
	/**
	 * Creates a new Bill entity.
	 *
	 * @Route("/create", name="order_create")
	 * @Method("post")
	 * @Template("JLMOfficeBundle:Order:new.html.twig")
	 * @Secure(roles="ROLE_USER")
	 */
	public function createAction(Request $request)
	{
		$entity  = new Order();
		$form    = $this->createForm(new OrderType(), $entity);
		$form->bind($request);
	
		if ($form->isValid())
		{
			$em = $this->getDoctrine()->getEntityManager();
			foreach ($entity->getLines() as $line)
			{
				$line->setOrder($entity);
				$em->persist($line);
			}
			$em->persist($entity);
			$em->flush();
			return $this->redirect($this->generateUrl('order_show', array('id' => $entity->getId())));
		}
	
		return array(
		'entity' => $entity,
		'form'   => $form->createView()
		);
	}
	
	/**
	 * Displays a form to edit an existing Order entity.
	 *
	 * @Route("/{id}/edit", name="order_edit")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function editAction(Order $entity)
	{
		// Si le devis est déjà validé, on empèche quelconque modification
		if ($entity->getState() > 2)
			return $this->redirect($this->generateUrl('order_show', array('id' => $entity->getId())));
		$editForm = $this->createForm(new OrderType(), $entity);
		return array(
				'entity'      => $entity,
				'edit_form'   => $editForm->createView(),
		);
	}
	
	/**
	 * Edits an existing Order entity.
	 *
	 * @Route("/{id}/update", name="order_update")
	 * @Method("post")
	 * @Template("JLMOfficeBundle:Order:edit.html.twig")
	 * @Secure(roles="ROLE_USER")
	 */
	public function updateAction(Request $request, Order $entity)
	{
		 
		// Si la commande est déjà validé, on empèche quelconque modification
		if ($entity->getState() > 2)
			return $this->redirect($this->generateUrl('order_show', array('id' => $entity->getId())));
	
		$editForm = $this->createForm(new OrderType(), $entity);
		$editForm->bind($request);
	
		if ($editForm->isValid())
		{
			$em = $this->getDoctrine()->getEntityManager();
			foreach ($entity->getLines() as $line)
			{
				$line->setOrder($entity);
				$em->persist($line);
			}
			$em->persist($entity);
			$em->flush();
			return $this->redirect($this->generateUrl('order_show', array('id' => $entity->getId())));
		}
	
		return array(
				'entity'      => $entity,
				'edit_form'   => $editForm->createView(),
		);
	}
	
	/**
	 * Imprimer la fiche travaux
	 *
	 * @Route("/{id}/print", name="order_print")
	 * @Secure(roles="ROLE_USER")
	 */
	public function printAction(Order $entity)
	{
		$response = new Response();
		$response->headers->set('Content-Type', 'application/pdf');
		$response->headers->set('Content-Disposition', 'inline; filename='.$entity->getId().'.pdf');
		$response->setContent($this->render('JLMOfficeBundle:Order:print.pdf.php',array('entity'=>array($entity))));
	
		//   return array('entity'=>$entity);
		return $response;
	}
}
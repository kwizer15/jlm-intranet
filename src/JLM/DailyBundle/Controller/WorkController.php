<?php

namespace JLM\DailyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\DailyBundle\Entity\Work;
use JLM\DailyBundle\Form\Type\WorkType;
use JLM\DailyBundle\Form\Type\WorkEditType;
use JLM\DailyBundle\Form\Type\WorkCloseType;
use JLM\ModelBundle\Entity\Door;
use JLM\OfficeBundle\Entity\QuoteVariant;

/**
 * Work controller.
 *
 * @Route("/work")
 */
class WorkController extends Controller
{
	/**
	 * @Route("/list", name="work_list")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function listAction()
	{
		$em = $this->getDoctrine()->getManager();
		$entities = $em->getRepository('JLMDailyBundle:Work')->getPrioritary();
		return array(
				'entities'      => $entities,
		);
	}
	
	/**
	 * Finds and displays a Work entity.
	 *
	 * @Route("/{id}/show", name="work_show")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function showAction(Work $entity)
	{
		$st = new ShiftTechnician();
		$st->setBegin(new \DateTime);
		$form   = $this->createForm(new AddTechnicianType(), $st);
		
		return array(
				'entity' => $entity,
				'form_newtech'   => $form->createView(),
		);
	}
	
	/**
	 * Displays a form to create a new Work entity.
	 *
	 * @Route("/new/door/{id}", name="work_new_door")
	 * @Template("JLMDailyBundle:Work:new.html.twig")
	 * @Secure(roles="ROLE_USER")
	 */
	public function newdoorAction(Door $door)
	{
		$entity = new Work();
		$entity->setDoor($door);
		$entity->setPlace($door.'');
		$form   = $this->createForm(new WorkType(), $entity);
	
		return array(
				'entity' => $entity,
				'form'   => $form->createView(),
		);
	}
	
	/**
	 * Displays a form to create a new Work entity.
	 *
	 * @Route("/new", name="work_new")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function newAction()
	{
		$entity = new Work();
		$form   = $this->createForm(new WorkType(), $entity);
	
		return array(
				'entity' => $entity,
				'form'   => $form->createView(),
		);
	}
	
	/**
	 * Displays a form to create a new Work entity.
	 *
	 * @Route("/new/quote/{id}", name="work_new_quote")
	 * @Template("JLMDailyBundle:Work:new.html.twig")
	 * @Secure(roles="ROLE_USER")
	 */
	public function newquoteAction(QuoteVariant $quote)
	{
		$entity = new Work();
		$entity->setQuote($quote);
		$door = $quote->getQuote()->getDoor();
		$entity->setDoor($door);
		$entity->setPlace($quote->getQuote()->getDoorCp());
		$entity->setReason($quote->getIntro());
		$contact = $quote->getQuote()->getContact();
		if ($contact === null)
			$entity->setContactName($quote->getQuote()->getContactCp());
		else
		{
			$entity->setContactName($contact->getPerson()->getName().' ('.$contact->getRole().')');
			$mobilePhone = $contact->getPerson()->getMobilePhone();
			$fixedPhone = $contact->getPerson()->getFixedPhone();
			$email = $contact->getPerson()->getEmail();
			$phones = '';
			if ($mobilePhone != null)
				$phones .= $mobilePhone;
			if ($fixedPhone != null)
			{
				if ($phones != '')
					$phones .= chr(10);
				$phones .= $fixedPhone;
			}
			if ($email != null)
				$entity->setContactEmail($email);
			$entity->setContactPhones($phones);
		}
		$form   = $this->createForm(new WorkType(), $entity);
	
		return array(
				'entity' => $entity,
				'form'   => $form->createView(),
		);
	}
	
	/**
	 * Creates a new Work entity.
	 *
	 * @Route("/create", name="work_create")
	 * @Method("POST")
	 * @Template("JLMDailyBundle:Work:new.html.twig")
	 * @Secure(roles="ROLE_USER")
	 */
	public function createAction(Request $request)
	{
		$entity  = new Work();
		$form = $this->createForm(new WorkType(), $entity);
		$form->bind($request);
	
		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$entity->setContract($entity->getDoor()->getActualContract());
			$entity->setCreation(new \DateTime);
			$entity->setPriority(4);
	
			$em->persist($entity);
			$em->flush();
	
			return $this->redirect($this->generateUrl('work_show', array('id' => $entity->getId())));
		}
	
		return array(
				'entity' => $entity,
				'form'   => $form->createView(),
		);
	}
	
	/**
	 * Displays a form to edit an existing Work entity.
	 *
	 * @Route("/{id}/edit", name="work_edit")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function editAction(Work $entity)
	{
		$editForm = $this->createForm(new WorkEditType(), $entity);
	
		return array(
				'entity'      => $entity,
				'form'   => $editForm->createView(),
		);
	}
	
	/**
	 * Edits an existing Work entity.
	 *
	 * @Route("/{id}/update", name="work_update")
	 * @Method("POST")
	 * @Template("JLMDailyBundle:Work:edit.html.twig")
	 * @Secure(roles="ROLE_USER")
	 */
	public function updateAction(Request $request, Work $entity)
	{
		$em = $this->getDoctrine()->getManager();
			
		$editForm = $this->createForm(new WorkEditType(), $entity);
		$editForm->bind($request);
	
		if ($editForm->isValid())
		{
			$em->persist($entity);
			$em->flush();
			return $this->redirect($this->generateUrl('work_show', array('id' => $entity->getId())));
		}
	
		return array(
				'entity'      => $entity,
				'form'   => $editForm->createView(),
		);
	}
	
	/**
	 * Close an existing Work entity.
	 *
	 * @Route("/{id}/close", name="work_close")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function closeAction(Work $entity)
	{
		$form = $this->createForm(new WorkCloseType(), $entity);
	
		return array(
				'entity'      => $entity,
				'form'   => $form->createView(),
		);
	}
	
	/**
	 * Close an existing Work entity.
	 *
	 * @Route("/{id}/closeupdate", name="work_closeupdate")
	 * @Method("POST")
	 * @Template("JLMDailyBundle:Work:close.html.twig")
	 * @Secure(roles="ROLE_USER")
	 */
	public function closeupdateAction(Request $request, Work $entity)
	{
		$em = $this->getDoctrine()->getManager();
			
		$form = $this->createForm(new WorkCloseType(), $entity);
		$form->bind($request);
	
		if ($form->isValid())
		{
			$entity->setClose(new \DateTime);
			$em->persist($entity);
			$em->flush();
			return $this->redirect($this->generateUrl('work_show', array('id' => $entity->getId())));
		}
	
		return array(
				'entity'      => $entity,
				'form'   => $form->createView(),
		);
	}
}
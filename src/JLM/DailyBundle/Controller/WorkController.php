<?php

namespace JLM\DailyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\DailyBundle\Entity\Work;
use JLM\DailyBundle\Form\Type\WorkType;
use JLM\DailyBundle\Form\Type\WorkEditType;
use JLM\DailyBundle\Form\Type\WorkCloseType;
use JLM\DailyBundle\Entity\ShiftTechnician;
use JLM\DailyBundle\Form\Type\AddTechnicianType;
use JLM\DailyBundle\Form\Type\ShiftingEditType;
use JLM\DailyBundle\Form\Type\ExternalBillType;
use JLM\DailyBundle\Form\Type\InterventionCancelType;
use JLM\ModelBundle\Entity\Door;
use JLM\CommerceBundle\Entity\QuoteVariant;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use JLM\CoreBundle\Factory\MailFactory;
use JLM\CoreBundle\Form\Type\MailType;
use JLM\CoreBundle\Builder\MailSwiftMailBuilder;
use JLM\ModelBundle\JLMModelEvents;
use JLM\ModelBundle\Event\DoorEvent;

/**
 * Work controller.
 *
 */
class WorkController extends AbstractInterventionController
{
	/**
	 * List the works
	 */
	public function listAction()
	{
		$manager = $this->container->get('jlm_daily.work_manager');
		$manager->secure('ROLE_USER');
		$request = $manager->getRequest();
		$repo = $manager->getRepository();
		
		return $manager->isAjax() ? $manager->renderJson(array('entities' => $repo->getArray($request->get('q',''), $request->get('page_limit',10))))
		: $manager->renderResponse('JLMDailyBundle:Work:list.html.twig', $manager->pagination('getCountOpened', 'getOpened', 'work_list', array()));
	}
	
	/**
	 * Finds and displays a Work entity.
	 *
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function showAction(Work $entity)
	{
		return $this->show($entity);
	}
	
	/**
	 * Displays a form to create a new Work entity.
	 *
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
	 * @Template("JLMDailyBundle:Work:new.html.twig")
	 * @Secure(roles="ROLE_USER")
	 */
	public function createAction(Request $request)
	{
		$entity  = new Work();
		
		$form = $this->createForm(new WorkType(), $entity);
		$entity->setCreation(new \DateTime);
		$entity->setPriority(4);
		$form->handleRequest($request);
		$entity->setContract($entity->getDoor()->getActualContract());

		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();

	
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
	 * @Template("JLMDailyBundle:Work:edit.html.twig")
	 * @Secure(roles="ROLE_USER")
	 */
	public function updateAction(Request $request, Work $entity)
	{
		$em = $this->getDoctrine()->getManager();
			
		$editForm = $this->createForm(new WorkEditType(), $entity);
		$editForm->handleRequest($request);
	
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
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function closeupdateAction(Request $request, Work $entity)
	{	
		$form = $this->createForm(new WorkCloseType(), $entity);
		$form->handleRequest($request);
	
		if ($form->isValid())
		{
			$em = $this->getDoctrine()->getManager();
			if ($entity->getObjective()->getId() == 1)  // Mise en service
			{
				$stop = $entity->getDoor()->getLastStop();
				if ($stop !== null)
				{
					$stop->setEnd(new \DateTime);
					$em->persist($stop);
				}
				$em->persist($entity->getDoor());
			}
			$entity->setClose(new \DateTime);
			$entity->setMustBeBilled($entity->getQuote() !== null);
			$em->persist($entity);
			$em->flush();
			return $this->redirect($this->generateUrl('work_show', array('id' => $entity->getId())));
		}
	
		return array(
				'entity'      => $entity,
				'form'   => $form->createView(),
		);
	}
	
	/**
	 * Finds and displays a InterventionPlanned entity.
	 *
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function emailAction(Work $entity, $step)
	{
		$request = $this->getRequest();
		$steps = array(
				'planned' => 'JLM\DailyBundle\Builder\Email\WorkPlannedMailBuilder',
				'onsite' => 'JLM\DailyBundle\Builder\Email\WorkOnSiteMailBuilder',
				'end' => 'JLM\DailyBundle\Builder\Email\WorkEndMailBuilder',
		);
		$class = (array_key_exists($step, $steps)) ? $steps[$step] : null;
		if (null === $class)
		{
			throw new NotFoundHttpException('Page inexistante');
		}
		$mail = MailFactory::create(new $class($entity));
		$editForm = $this->createForm(new MailType(), $mail);
		$editForm->handleRequest($request);
		if ($editForm->isValid())
		{
			$this->get('mailer')->send(MailFactory::create(new MailSwiftMailBuilder($editForm->getData())));
			$this->get('event_dispatcher')->dispatch(JLMModelEvents::DOOR_SENDMAIL, new DoorEvent($entity->getDoor(), $request));
			return $this->redirect($this->generateUrl('work_show', array('id' => $entity->getId())));
		}
		return array(
				'entity' => $entity,
				'form' => $editForm->createView(),
				'step' => $step,
		);
	}
}
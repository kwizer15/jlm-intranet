<?php

namespace JLM\OfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\OfficeBundle\Entity\AskQuote;
use JLM\OfficeBundle\Form\Type\AskQuoteType;

/**
 * AskQuote controller.
 *
 * @Route("/quote/ask")
 */
class AskquoteController extends Controller
{
	/**
	 * @Route("/", name="askquote")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function indexAction()
	{
		$em = $this->getDoctrine()->getEntityManager();
		$entities = $em->getRepository('JLMOfficeBundle:AskQuote')->findAll();
		return array('entities'=>$entities);
	}
	
	/**
	 * @Route("/{id}/show", name="askquote_show")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function showAction(AskQuote $entity)
	{
		return array('entity'=>$entity);
	}
	
	/**
	 * @Route("/new", name="askquote_new")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function newAction()
	{
		$askquote = new AskQuote;
		$askquote->setCreation(new \DateTime);
		$form = $this->createForm(new AskQuoteType,$askquote);
		return array('form' => $form->createView(),'entity'=>$askquote);
	}
	
	/**
	 * @Route("/create", name="askquote_create")
	 * @Template("JLMOfficeBundle:Askquote:new.html.twig")
	 * @Secure(roles="ROLE_USER")
	 */
	public function createAction()
	{
		$entity = new AskQuote;
		$form = $this->createForm(new AskQuoteType,$entity);
		
		if ($this->getRequest()->isMethod('POST')) {
			$form->bind($this->getRequest());
			if ($form->isValid()) {
				if ($entity->getMaturity() === null)
				{
					$matu = clone $entity->getCreation();
					$entity->setMaturity($matu->add(new \DateInterval('P15D')));
				}
				$em = $this->getDoctrine()->getManager();
				$em->persist($entity);
				$em->flush();
				$this->redirect($this->generateUrl('askquote_show', array('id' => $entity->getId())));
			}
		}
		
		return array('form' => $form->createView());
	}
}
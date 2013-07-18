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
use JLM\OfficeBundle\Form\Type\AskQuoteDontTreatType;

/**
 * AskQuote controller.
 *
 * @Route("/quote/ask")
 */
class AskquoteController extends Controller
{
	/**
	 * @Route("/", name="askquote")
	 * @Route("/page/{page}", name="askquote_page")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function indexAction($page = 1)
	{
		$limit = 10;
		$em = $this->getDoctrine()->getEntityManager();
		$repo = $em->getRepository('JLMOfficeBundle:AskQuote');
		$nb = $repo->getTotal();
		$nbPages = ceil($nb/$limit);
		$nbPages = ($nbPages < 1) ? 1 : $nbPages;
		$offset = ($page-1) * $limit;
		if ($page < 1 || $page > $nbPages)
		{
			throw $this->createNotFoundException('Page insexistante (page '.$page.'/'.$nbPages.')');
		}
		$entities = $repo->getAll($limit,$offset);
		return array(
				'entities' => $entities,
				'page'     => $page,
				'nbPages'  => $nbPages,
		);
	}
	
	/**
	 * @Route("/treated", name="askquote_listtreated")
	 * @Template("JLMOfficeBundle:Askquote:index.html.twig")
	 * @Secure(roles="ROLE_USER")
	 */
	public function listtreatedAction()
	{
		$em = $this->getDoctrine()->getEntityManager();
		$entities = $em->getRepository('JLMOfficeBundle:AskQuote')->getTreated();
		return array('entities'=>$entities);
	}
	
	/**
	 * @Route("/untreated", name="askquote_listuntreated")
	 * @Template("JLMOfficeBundle:Askquote:index.html.twig")
	 * @Secure(roles="ROLE_USER")
	 */
	public function listuntreatedAction()
	{
		$em = $this->getDoctrine()->getEntityManager();
		$entities = $em->getRepository('JLMOfficeBundle:AskQuote')->getUntreated();
		return array('entities'=>$entities);
	}
	
	/**
	 * @Route("/{id}/show", name="askquote_show")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function showAction(AskQuote $entity)
	{
		$form = $this->createForm(new AskQuoteDontTreatType,$entity);
		return array('entity'=>$entity,'form_donttreat'=>$form->createView());
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
		
		if ($this->getRequest()->isMethod('POST'))
		{
			$form->bind($this->getRequest());
			if ($form->isValid())
			{
				if ($entity->getMaturity() === null)
				{
					$matu = clone $entity->getCreation();
					$entity->setMaturity($matu->add(new \DateInterval('P15D')));
				}
				$em = $this->getDoctrine()->getManager();
				$em->persist($entity);
				$em->flush();
				return $this->redirect($this->generateUrl('askquote_show', array('id' => $entity->getId())));
			}
		}
		
		return array('form' => $form->createView());
	}
	
	/**
	 * @Route("/{id}/donttreat", name="askquote_donttreat")
	 * @Secure(roles="ROLE_USER")
	 */
	public function donttreatAction(AskQuote $entity)
	{
		$form = $this->createForm(new AskQuoteDontTreatType,$entity);
		
		if ($this->getRequest()->isMethod('POST'))
		{
			$form->bind($this->getRequest());
			if ($form->isValid())
			{
				$em = $this->getDoctrine()->getManager();
				$em->persist($entity);
				$em->flush();
			}
		}
		return $this->redirect($this->generateUrl('askquote_show', array('id' => $entity->getId())));
	}
	
	/**
	 * @Route("/{id}/canceldonttreat", name="askquote_canceldonttreat")
	 * @Secure(roles="ROLE_USER")
	 */
	public function canceldonttreatAction(AskQuote $entity)
	{
		$entity->setDontTreat();
		$em = $this->getDoctrine()->getManager();
		$em->persist($entity);
		$em->flush();
		return $this->redirect($this->generateUrl('askquote_show', array('id' => $entity->getId())));
	}
	
	/**
	 * Sidebar
	 * @Route("/sidebar", name="askquote_sidebar")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function sidebarAction()
	{
		$em = $this->getDoctrine()->getEntityManager();
	
		return array(
				'all' => $em->getRepository('JLMOfficeBundle:AskQuote')->getTotal(),
				'untreated' => $em->getRepository('JLMOfficeBundle:AskQuote')->getCountUntreated(),
				'treated' => $em->getRepository('JLMOfficeBundle:AskQuote')->getCountTreated(),
		);
	}
}
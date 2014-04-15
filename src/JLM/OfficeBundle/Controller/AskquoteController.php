<?php

namespace JLM\OfficeBundle\Controller;

use JLM\DefaultBundle\Controller\PaginableController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\OfficeBundle\Entity\AskQuote;
use JLM\OfficeBundle\Form\Type\AskQuoteType;
use JLM\OfficeBundle\Form\Type\AskQuoteDontTreatType;
use JLM\DefaultBundle\Entity\Search;
use JLM\DefaultBundle\Form\Type\SearchType;

/**
 * AskQuote controller.
 *
 * @Route("/quote/ask")
 */
class AskquoteController extends PaginableController
{
	/**
	 * @Route("/", name="askquote")
	 * @Route("/page/{page}", name="askquote_page")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function indexAction($page = 1)
	{
		return $this->pagination('JLMOfficeBundle:AskQuote','All',$page,10,'askquote_page');
	}
	
	/**
	 * @Route("/treated", name="askquote_listtreated")
	 * @Route("/treated/page/{page}", name="askquote_listtreated_page")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function listtreatedAction($page = 1)
	{
		return $this->pagination('JLMOfficeBundle:AskQuote','Treated',$page,10,'askquote_listtreated_page');
	}
	
	/**
	 * @Route("/untreated", name="askquote_listuntreated")
	 * @Route("/untreated/page/{page}", name="askquote_listuntreated_page")
	 * @Template()
	 * @Secure(roles="ROLE_USER")
	 */
	public function listuntreatedAction($page = 1)
	{
		return $this->pagination('JLMOfficeBundle:AskQuote','Untreated',$page,10,'askquote_listuntreated_page');
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
	 * @Secure(roles="ROLE_USER")
	 */
	public function sidebarAction()
	{
		$em = $this->getDoctrine()->getManager();
		$repo = $em->getRepository('JLMOfficeBundle:AskQuote');
			
		// Vérification du cache
		$lastModified = $repo->getLastModified();
		$response = new Response;
		$response->setLastModified($lastModified);
		$response->setPublic();
		if ($response->isNotModified($this->getRequest()))
		{
		    return $response;
		}
		return $this->render('JLMOfficeBundle:Askquote:sidebar.html.twig',array('count' => array(
				'all' => $repo->getTotal(),
				'untreated' => $repo->getCountUntreated(),
				'treated' => $repo->getCountTreated(),
		)),$response);
	}
	
	/**
	 * Imprimer la liste des demande de devis non-traités
	 *
	 * @Route("/printlist", name="askquote_printlist")
	 * @Secure(roles="ROLE_USER")
	 */
	public function printlistAction()
	{
		$em = $this->getDoctrine()->getManager();
		$entities = $em->getRepository('JLMOfficeBundle:AskQuote')->getUntreated(1000);
		$response = new Response();
		$response->headers->set('Content-Type', 'application/pdf');
		$response->headers->set('Content-Disposition', 'inline; filename=devis-a-faire.pdf');
		$response->setContent($this->render('JLMOfficeBundle:Askquote:printlist.pdf.php',array('entities'=>$entities)));
	
		//   return array('entity'=>$entity);
		return $response;
	}
	
	/**
	 * Resultats de la barre de recherche.
	 *
	 * @Route("/search", name="askquote_search")
	 * @Method("post")
	 * @Secure(roles="ROLE_USER")
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
					'layout'=> array('form_search_query'=>$entity),
					'entities' => $em->getRepository('JLMOfficeBundle:AskQuote')->search($entity),
					'query' => $entity->getQuery(),
			);
		}
		return array('layout'=>array('form_search_query'=>$entity),'query' => $entity->getQuery(),);
	}
}
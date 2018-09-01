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
     */
    public function indexAction()
    {
        $manager = $this->container->get('jlm_office.askquote_manager');
        $manager->secure('ROLE_OFFICE');
        $request = $manager->getRequest();
        $states = [
                   'all'       => 'All',
                   'treated'   => 'Treated',
                   'untreated' => 'Untreated',
                  ];
        $state = $request->get('state');
        $state = (!array_key_exists($state, $states)) ? 'all' : $state;
        $method = $states[$state];
        $functionCount = 'getCount'.$method;
        $functionDatas = 'get'.$method;
    
        return $manager->renderResponse(
            'JLMOfficeBundle:Askquote:index.html.twig',
            $manager->pagination($functionCount, $functionDatas, 'askquote', ['state' => $state])
        );
    }
    
    /**
     * @Route("/{id}/show", name="askquote_show")
     * @Template()
     * @Secure(roles="ROLE_OFFICE")
     */
    public function showAction(AskQuote $entity)
    {
        $form = $this->createForm(new AskQuoteDontTreatType, $entity);
        return [
                'entity'         => $entity,
                'form_donttreat' => $form->createView(),
               ];
    }
    
    /**
     * @Route("/new", name="askquote_new")
     * @Template()
     * @Secure(roles="ROLE_OFFICE")
     */
    public function newAction()
    {
        $askquote = new AskQuote;
        $askquote->setCreation(new \DateTime);
        $form = $this->createForm(new AskQuoteType, $askquote);
        return [
                'form'   => $form->createView(),
                'entity' => $askquote,
               ];
    }
    
    /**
     * @Route("/create", name="askquote_create")
     * @Template("JLMOfficeBundle:Askquote:new.html.twig")
     * @Secure(roles="ROLE_OFFICE")
     */
    public function createAction()
    {
        $entity = new AskQuote;
        $form = $this->createForm(new AskQuoteType, $entity);
        
        if ($this->getRequest()->isMethod('POST')) {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                if ($entity->getMaturity() === null) {
                    $matu = clone $entity->getCreation();
                    $entity->setMaturity($matu->add(new \DateInterval('P15D')));
                }
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
                return $this->redirect($this->generateUrl('askquote_show', ['id' => $entity->getId()]));
            }
        }
        
        return ['form' => $form->createView()];
    }
    
    /**
     * @Route("/{id}/donttreat", name="askquote_donttreat")
     * @Secure(roles="ROLE_OFFICE")
     */
    public function donttreatAction(AskQuote $entity)
    {
        $form = $this->createForm(new AskQuoteDontTreatType, $entity);
        
        if ($this->getRequest()->isMethod('POST')) {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
            }
        }
        return $this->redirect($this->generateUrl('askquote_show', ['id' => $entity->getId()]));
    }
    
    /**
     * @Route("/{id}/canceldonttreat", name="askquote_canceldonttreat")
     * @Secure(roles="ROLE_OFFICE")
     */
    public function canceldonttreatAction(AskQuote $entity)
    {
        $entity->setDontTreat();
        $em = $this->getDoctrine()->getManager();
        $em->persist($entity);
        $em->flush();
        return $this->redirect($this->generateUrl('askquote_show', ['id' => $entity->getId()]));
    }
    
    /**
     * Imprimer la liste des demande de devis non-traités
     *
     * @Route("/printlist", name="askquote_printlist")
     * @Secure(roles="ROLE_OFFICE")
     */
    public function printlistAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('JLMOfficeBundle:AskQuote')->getUntreated(1000);
        $response = new Response();
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'inline; filename=devis-a-faire.pdf');
        $response->setContent($this->render('JLMOfficeBundle:Askquote:printlist.pdf.php', ['entities' => $entities]));
    
        //   return array('entity'=>$entity);
        return $response;
    }
    
    /**
     * Resultats de la barre de recherche.
     *
     * @Route("/search", name="askquote_search")
     */
    public function searchAction(Request $request)
    {
        $manager = $this->container->get('jlm_office.askquote_manager');
        $manager->secure('ROLE_OFFICE');
        $formData = $manager->getRequest()->get('jlm_core_search');
        $params = [];
        if (is_array($formData) && array_key_exists('query', $formData)) {
            $params = ['entities' => $manager->getRepository()->search($formData['query'])];
        }
        
        return $manager->renderResponse('JLMOfficeBundle:Askquote:index.html.twig', $params);
    }
}

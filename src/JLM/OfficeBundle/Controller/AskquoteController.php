<?php

namespace JLM\OfficeBundle\Controller;

use JLM\CoreBundle\Service\Pagination;
use JLM\DefaultBundle\Controller\PaginableController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\OfficeBundle\Entity\AskQuote;
use JLM\OfficeBundle\Form\Type\AskQuoteType;
use JLM\OfficeBundle\Form\Type\AskQuoteDontTreatType;
use JLM\DefaultBundle\Entity\Search;
use JLM\DefaultBundle\Form\Type\SearchType;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * AskQuote controller.
 *
 * @Route("/quote/ask")
 */
class AskquoteController extends PaginableController
{
    /**
     * @Route("/", name="askquote")
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction(Request $request): Response
    {
        $repository = $this->container->get('doctrine')->getRepository(AskQuote::class);
        $templating = $this->container->get('templating');

        $this->denyAccessUnlessGranted('ROLE_OFFICE');
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

        $paginator = new Pagination($request, $repository);
        $pagination = $paginator->paginate($functionCount, $functionDatas, 'askquote', ['state' => $state]);

        return $templating->renderResponse(
            'JLMOfficeBundle:Askquote:index.html.twig', $pagination
        );
    }
    
    /**
     * @Route("/{id}/show", name="askquote_show")
     * @Template()
     */
    public function showAction(AskQuote $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $form = $this->createForm(AskQuoteDontTreatType::class, $entity);
        return [
                'entity'         => $entity,
                'form_donttreat' => $form->createView(),
               ];
    }
    
    /**
     * @Route("/new", name="askquote_new")
     * @Template()
     */
    public function newAction()
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $askquote = new AskQuote;
        $askquote->setCreation(new \DateTime);
        $form = $this->createForm(AskQuoteType::class, $askquote);
        return [
                'form'   => $form->createView(),
                'entity' => $askquote,
               ];
    }

    /**
     * @Route("/create", name="askquote_create")
     * @Template("JLMOfficeBundle:Askquote:new.html.twig")
     *
     * @param Request $request
     *
     * @return array|RedirectResponse
     * @throws \Exception
     */
    public function createAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $entity = new AskQuote;
        $form = $this->createForm(AskQuoteType::class, $entity);
        
        if ($request->isMethod('POST')) {
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
     *
     * @param Request $request
     * @param AskQuote $entity
     *
     * @return RedirectResponse
     */
    public function donttreatAction(Request $request, AskQuote $entity): RedirectResponse
    {
        $router = $this->container->get('router');
        $formFactory = $this->container->get('form.factory');

        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $form = $formFactory->create(AskQuoteDontTreatType::class, $entity);
        
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
            }
        }

        return new RedirectResponse($router->generate('askquote_show', ['id' => $entity->getId()]));
    }
    
    /**
     * @Route("/{id}/canceldonttreat", name="askquote_canceldonttreat")
     */
    public function canceldonttreatAction(AskQuote $entity)
    {
        $router = $this->container->get('router');

        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $entity->setDontTreat();
        $em = $this->getDoctrine()->getManager();
        $em->persist($entity);
        $em->flush();

        return new RedirectResponse($router->generate('askquote_show', ['id' => $entity->getId()]));
    }
    
    /**
     * Imprimer la liste des demande de devis non-traités
     *
     * @Route("/printlist", name="askquote_printlist")
     */
    public function printlistAction()
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('JLMOfficeBundle:AskQuote')->getUntreated(1000);
        $response = new Response();
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'inline; filename=devis-a-faire.pdf');
        $response->setContent($this->render('JLMOfficeBundle:Askquote:printlist.pdf.php', ['entities' => $entities]));

        return $response;
    }

    /**
     * Resultats de la barre de recherche.
     *
     * @Route("/search", name="askquote_search")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function searchAction(Request $request): Response
    {
        $doctrine = $this->container->get('doctrine');
        $templating = $this->container->get('templating');
        $authorizationChecker = $this->container->get('security.authorization_checker');
        $repository = $doctrine->getRepository(AskQuote::class);

        if (!$authorizationChecker->isGranted('ROLE_OFFICE')) {
            throw new AccessDeniedException();
        }

        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        $formData = $request->get('jlm_core_search');
        $params = [];
        if (is_array($formData) && array_key_exists('query', $formData)) {
            $params = ['entities' => $repository->search($formData['query'])];
        }
        
        return $templating->renderResponse('JLMOfficeBundle:Askquote:index.html.twig', $params);
    }
}

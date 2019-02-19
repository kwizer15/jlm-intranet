<?php
namespace JLM\FeeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\FeeBundle\Entity\Fee;
use JLM\FeeBundle\Form\Type\FeeType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Contract controller.
 *
 * @Route("/fee")
 */
class FeeController extends Controller
{

    /**
     * Lists all Contract entities.
     *
     * @Route("/", name="fee")
     * @Template()
     */
    public function indexAction()
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('JLMFeeBundle:Fee')->findAll();
        return ['entities' => $entities];
    }
    
    /**
     * Finds and displays a Fee entity.
     *
     * @Route("/{id}/show", name="fee_show")
     * @Template()
     */
    public function showAction(Fee $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        return ['entity' => $entity];
    }
    
    /**
     * Displays a form to create a new Fee entity.
     *
     * @Route("/new", name="fee_new")
     * @Template()
     */
    public function newAction()
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $entity = new Fee();

        $form   = $this->createForm(FeeType::class, $entity);
    
        return [
                'entity' => $entity,
                'form'   => $form->createView(),
               ];
    }
    
    /**
     * Creates a new Fee entity.
     *
     * @Route("/create", name="fee_create")
     * @Method("post")
     * @Template("JLMModelBundle:Fee:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $entity  = new Fee();
        $form    = $this->createForm(FeeType::class, $entity);
        $form->handleRequest($request);
    
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
    
            return $this->redirect($this->generateUrl('fee_show', ['id' => $entity->getId()]));
        }
    
        return [
                'entity' => $entity,
                'form'   => $form->createView(),
               ];
    }
    
    /**
     * Displays a form to edit an existing Fee entity.
     *
     * @Route("/{id}/edit", name="fee_edit")
     * @Template()
     */
    public function editAction(Fee $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $editForm = $this->createForm(FeeType::class, $entity);
    
        return [
                'entity'    => $entity,
                'edit_form' => $editForm->createView(),
               ];
    }

    /**
     * Edits an existing Fee entity.
     *
     * @Route("/{id}/update", name="fee_update")
     * @Method("post")
     * @Template("JLMModelBundle:Fee:edit.html.twig")
     * @param Request $request
     * @param Fee     $entity
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function updateAction(Request $request, Fee $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $editForm   = $this->createForm(FeeType::class, $entity);
        $editForm->handleRequest($request);
    
        if ($editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
    
            return $this->redirect($this->generateUrl('fee_show', ['id' => $entity->getId()]));
        }
    
        return [
                'entity'    => $entity,
                'edit_form' => $editForm->createView(),
               ];
    }
}

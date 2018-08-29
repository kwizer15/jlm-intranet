<?php

/*
 * This file is part of the JLMModelBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ModelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\ModelBundle\Entity\Trustee;
use JLM\ModelBundle\Form\Type\TrusteeType;
use JLM\ContactBundle\Form\Type\PersonType;
use JLM\ContactBundle\Manager\ContactManager;
use JLM\ContractBundle\Excel\ListManager;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class TrusteeController extends Controller
{
    /**
     * Lists all Trustee entities.
     *
     * @Template()
     * @Secure(roles="ROLE_OFFICE")
     */
    public function indexAction($page = 1)
    {
        $limit = 15;
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('JLMModelBundle:Trustee');
        $nb = $repo->getTotal();
        $nbPages = ceil($nb/$limit);
        $nbPages = ($nbPages < 1) ? 1 : $nbPages;
        $offset = ($page-1) * $limit;
        if ($page < 1 || $page > $nbPages) {
            throw $this->createNotFoundException('Page insexistante (page '.$page.'/'.$nbPages.')');
        }

        $entities = $repo->getList($limit, $offset);

        return [
                'entities' => $entities,
                'page'     => $page,
                'nbPages'  => $nbPages,
               ];
    }

    /**
     * Finds and displays a Trustee entity.
     *
     * @Template()
     * @Secure(roles="ROLE_OFFICE")
     */
    public function showAction(Trustee $entity)
    {
        return ['entity' => $entity];
    }

    /**
     * Displays a form to create a new Trustee entity.
     *
     * @Template()
     * @Secure(roles="ROLE_OFFICE")
     */
    public function newAction()
    {
        $request = $this->getRequest();
        $contact = $request->get('contact');
        $em = $this->get('doctrine')->getManager();
        $entity = new Trustee();
        $form   = $this->createForm(new TrusteeType(), $entity);
        if ($contact) {
            $c = $em->getRepository('JLMContactBundle:Contact')->find($contact);
            if ($c) {
                $form->get('contact')->setData($c);
            }
        }

        return [
                'entity' => $entity,
                'form'   => $form->createView(),
               ];
    }

    /**
     * Creates a new Trustee entity.
     *
     * @Template("JLMModelBundle:Trustee:new.html.twig")
     * @Secure(roles="ROLE_OFFICE")
     */
    public function createAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entity  = new Trustee();
        $request = $this->getRequest();
        $form    = $this->createForm(new TrusteeType(), $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if ($entity->getBillingAddress() !== null) {
                $em->persist($entity->getBillingAddress());
            }
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('trustee_show', ['id' => $entity->getId()]));
        }
        return [
                'entity' => $entity,
                'form'   => $form->createView(),
               ];
    }

    /**
     * Displays a form to edit an existing Trustee entity.
     *
     * @Template()
     * @Secure(roles="ROLE_OFFICE")
     */
    public function editAction(Trustee $entity)
    {
        $editForm = $this->createForm(new TrusteeType(), $entity);
        $deleteForm = $this->createDeleteForm($entity);

        return [
                'entity'      => $entity,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
               ];
    }

    /**
     * Edits an existing Trustee entity.
     *
     * @Template("JLMModelBundle:Trustee:edit.html.twig")
     * @Secure(roles="ROLE_OFFICE")
     */
    public function updateAction(Trustee $entity)
    {
        $em = $this->getDoctrine()->getManager();

        $editForm   = $this->createForm(new TrusteeType(), $entity);
        $deleteForm = $this->createDeleteForm($entity);

        $request = $this->getRequest();

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity->getAddress());
            if ($entity->getBillingAddress() !== null) {
                $em->persist($entity->getBillingAddress());
            }
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('trustee_show', ['id' => $entity->getId()]));
        }

        return [
                'entity'      => $entity,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
               ];
    }

    /**
     * Deletes a Trustee entity.
     *
     * @Secure(roles="ROLE_OFFICE")
     */
    public function deleteAction(Trustee $entity)
    {
        $form = $this->createDeleteForm($entity);
        $request = $this->getRequest();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('trustee'));
    }

    private function createDeleteForm(Trustee $entity)
    {
        return $this->createFormBuilder(['id' => $entity->getId()])
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
    /**
     * Formulaire d'ajout d'un contact au syndic.
     *
     * @Template()
     * @Secure(roles="ROLE_OFFICE")
     */
    public function contactnewAction(Trustee $trustee)
    {
        $entity = ContactManager::create('Person');
        $form   = $this->createForm(new PersonType(), $entity);
        
        return [
                'trustee' => $trustee,
                'entity'  => $entity,
                'form'    => $form->createView(),
               ];
    }
    
    /**
     * Creates a new Trustee entity.
     *
     * @Template("JLMModelBundle:Trustee:contactnew.html.twig")
     * @Secure(roles="ROLE_OFFICE")
     */
    public function contactcreateAction(Trustee $trustee)
    {
        $em = $this->getDoctrine()->getManager();
        $entity  = ContactManager::create('Person');
        $request = $this->getRequest();
        $form    = $this->createForm(new PersonType(), $entity);
        $form->handleRequest($request);
    
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $trustee->addContact($entity);
            $em->persist($entity);
            $em->persist($trustee);
            $em->flush();
    
            return $this->redirect($this->generateUrl('trustee_show', ['id' => $trustee->getId()]));
        }
    
        return [
                'trustee' => $trustee,
                'entity'  => $entity,
                'form'    => $form->createView(),
               ];
    }
    
    /**
     * City json
     *
     * @Secure(roles="ROLE_OFFICE")
     */
    public function searchAction(Request $request)
    {
        $term = $request->get('q');
        $page_limit = $request->get('page_limit');
    
        $em = $this->getDoctrine()->getManager();
    
        $entities = $em->getRepository('JLMModelBundle:Trustee')->getArray($term, $page_limit);
        
        return new JsonResponse(['entities' => $entities]);
    }
    
    /**
     * City json
     *
     * @Secure(roles="ROLE_OFFICE")
     */
    public function jsonAction(Request $request)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('JLMModelBundle:Trustee')->getByIdToArray($id);
    
        return new JsonResponse($entity);
    }
    

    /**
     *
     * @param Request $request
     * @return multitype:unknown
     * @Secure(roles="ROLE_OFFICE")
     */
    public function listExcelAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $list = $em->getRepository('JLMContractBundle:Contract')->getForRDV();
         
        $excelBuilder = new ListManager($this->get('phpexcel'));
        
        return $excelBuilder->createList($list)->getResponse();
    }
}

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

use JLM\ContactBundle\Entity\Person;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\ModelBundle\Entity\Trustee;
use JLM\ModelBundle\Form\Type\TrusteeType;
use JLM\ContactBundle\Form\Type\PersonType;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class TrusteeController extends Controller
{
    /**
     * Lists all Trustee entities.
     *
     * @Template()
     */
    public function indexAction($page = 1)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $limit = 15;
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('JLMModelBundle:Trustee');
        $nb = $repo->getTotal();
        $nbPages = ceil($nb / $limit);
        $nbPages = ($nbPages < 1) ? 1 : $nbPages;
        $offset = ($page - 1) * $limit;
        if ($page < 1 || $page > $nbPages) {
            throw $this->createNotFoundException('Page insexistante (page ' . $page . '/' . $nbPages . ')');
        }

        $entities = $repo->getList($limit, $offset);

        return [
            'entities' => $entities,
            'page' => $page,
            'nbPages' => $nbPages,
        ];
    }

    /**
     * Finds and displays a Trustee entity.
     *
     * @Template()
     */
    public function showAction(Trustee $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        return ['entity' => $entity];
    }

    /**
     * Displays a form to create a new Trustee entity.
     *
     * @Template()
     */
    public function newAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $contact = $request->get('contact');
        $em = $this->get('doctrine')->getManager();
        $entity = new Trustee();
        $form = $this->createForm(TrusteeType::class, $entity);
        if ($contact) {
            $c = $em->getRepository('JLMContactBundle:Contact')->find($contact);
            if ($c) {
                $form->get('contact')->setData($c);
            }
        }

        return [
            'entity' => $entity,
            'form' => $form->createView(),
        ];
    }

    /**
     * Creates a new Trustee entity.
     *
     * @Template("JLMModelBundle:Trustee:new.html.twig")
     */
    public function createAction()
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $entity = new Trustee();
        $request = $this->getRequest();
        $form = $this->createForm(TrusteeType::class, $entity);
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
            'form' => $form->createView(),
        ];
    }

    /**
     * Displays a form to edit an existing Trustee entity.
     *
     * @Template()
     */
    public function editAction(Trustee $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $editForm = $this->createForm(TrusteeType::class, $entity);
        $deleteForm = $this->createDeleteForm($entity);

        return [
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ];
    }

    /**
     * Edits an existing Trustee entity.
     *
     * @Template("JLMModelBundle:Trustee:edit.html.twig")
     */
    public function updateAction(Trustee $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $em = $this->getDoctrine()->getManager();

        $editForm = $this->createForm(TrusteeType::class, $entity);
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
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ];
    }

    /**
     * Deletes a Trustee entity.
     */
    public function deleteAction(Trustee $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

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
            ->add('id', HiddenType::class)
            ->getForm()
            ;
    }

    /**
     * Formulaire d'ajout d'un contact au syndic.
     *
     * @Template()
     */
    public function contactnewAction(Trustee $trustee)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $entity = new Person();
        $form = $this->createForm(PersonType::class, $entity);

        return [
            'trustee' => $trustee,
            'entity' => $entity,
            'form' => $form->createView(),
        ];
    }

    /**
     * Creates a new Trustee entity.
     *
     * @Template("JLMModelBundle:Trustee:contactnew.html.twig")
     * @param Request $request
     * @param Trustee $trustee
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function contactcreateAction(Request $request, Trustee $trustee)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $entity = new Person();
        $form = $this->createForm(PersonType::class, $entity);
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
            'entity' => $entity,
            'form' => $form->createView(),
        ];
    }

    /**
     * City json
     */
    public function searchAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $term = $request->get('q');
        $page_limit = $request->get('page_limit');

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('JLMModelBundle:Trustee')->getArray($term, $page_limit);

        return new JsonResponse(['entities' => $entities]);
    }

    /**
     * City json
     */
    public function jsonAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('JLMModelBundle:Trustee')->getByIdToArray($id);

        return new JsonResponse($entity);
    }


    /**
     *
     * @param Request $request
     *
     * @return multitype:unknown
     */
    public function listExcelAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $em = $this->getDoctrine()->getManager();
        $list = $em->getRepository('JLMContractBundle:Contract')->getForRDV();

        $excelBuilder = new ListManager($this->get('phpexcel'));

        return $excelBuilder->createList($list)->getResponse();
    }
}

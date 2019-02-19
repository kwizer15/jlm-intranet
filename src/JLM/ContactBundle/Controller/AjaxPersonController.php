<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ContactBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\ContactBundle\Manager\ContactManager;
use JLM\ContactBundle\Form\Type\PersonType;
use JLM\ContactBundle\Entity\Person;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Person controller.
 */
class AjaxPersonController extends Controller
{
    /**
     * Finds and displays a Person entity.
     *
     * @Template()
     */
    public function showajaxAction(Person $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        return ['entity' => $entity];
    }

    /**
     * Displays a form to create a new Person entity.
     *
     * @Template()
     */
    public function newajaxAction()
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        $manager = $this->container->get('jlm_contact.contact_manager');
        $entity = $manager->getEntity('person');
        $form = $manager->createForm('POST', $entity);


        return [
            'entity' => $entity,
            'form' => $form->createView(),
        ];
    }

    /**
     * Creates a new Person entity.
     * @Template()
     */
    public function createajaxAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');
        $entity = ContactManager::create('Person');
        $form = $this->createForm(new PersonType(), $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if ($entity->getAddress() !== null) {
                $em->persist($entity->getAddress());
            }
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('jlm_contact_ajax_person_show', ['id' => $entity->getId()]));
        }

        return [
            'entity' => $entity,
            'form' => $form->createView(),
        ];
    }

    /**
     * Return JSON list of Person entity.
     */
    public function autocompleteAction()
    {
        $request = $this->get('request');
        $query = $request->request->get('term');

        $em = $this->getDoctrine()->getManager();
        $results = $em->getRepository('JLMContactBundle:Person')->searchResult($query);
        $json = json_encode($results);
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent($json);
        return $response;
    }

    /**
     * Person json
     */
    public function searchAction()
    {
        $request = $this->get('request');
        $term = $request->get('q');
        $page_limit = $request->get('page_limit');
        $em = $this->getDoctrine()->getManager();
        $persons = $em->getRepository('JLMContactBundle:Person')->getArray($term, $page_limit);

        return new JsonResponse(['persons' => $persons]);
    }

    /**
     * Person json
     */
    public function jsonAction()
    {
        $request = $this->get('request');
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $person = $em->getRepository('JLMContactBundle:Person')->getByIdToArray($id);

        return new JsonResponse($person);
    }
}

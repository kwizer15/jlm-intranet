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
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\ModelBundle\Entity\Site;
use JLM\ModelBundle\Entity\Door;
use JLM\ContractBundle\Entity\Contract;
use JLM\ModelBundle\Form\Type\DoorType;
use JLM\ContractBundle\Form\Type\ContractType;
use JLM\ContractBundle\Form\Type\ContractStopType;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class DoorController extends Controller
{
    /**
     * Lists all Door entities.
     *
     * @Template()
     */
    public function indexAction()
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('JLMModelBundle:Door')->findAll();

        return ['entities' => $entities];
    }

    /**
     * Finds and displays a Door entity.
     *
     * @Template()
     */
    public function showAction(Door $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $em = $this->getDoctrine()->getManager();

        $contracts = $em->getRepository('JLMContractBundle:Contract')->findByDoor($entity, ['begin' => 'DESC']);

        // Modal nouveau contrat
        $contractNew = new Contract();
        $contractNew->setDoor($entity);
        $contractNew->setTrustee($entity->getAdministrator()->getTrustee());
        $contractNew->setBegin(new \DateTime());
        $form_contractNew = $this->createForm(new ContractType(), $contractNew);

        // Formulaires d'edition des contrat
        $form_contractEdits = $form_contractStops = [];
        foreach ($contracts as $contract) {
            $form_contractEdits[] = $this->get('form.factory')->createNamed(
                'contractEdit' . $contract->getId(),
                new ContractType(),
                $contract
            )->createView()
            ;
            $form_contractStops[] = $this->get('form.factory')->createNamed(
                'contractStop' . $contract->getId(),
                new ContractStopType(),
                $contract
            )->createView()
            ;
        }

        return [
            'entity' => $entity,
            'contracts' => $contracts,
            'form_contractNew' => $form_contractNew->createView(),
            'form_contractEdits' => $form_contractEdits,
            'form_contractStops' => $form_contractStops,
        ];
    }

    /**
     * Displays a form to create a new Door entity.
     *
     * @Template()
     */
    public function newAction(Site $site = null)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $entity = new Door();
        if ($site) {
            $entity->setAdministrator($site);
            $entity->setStreet($site->getAddress()->getStreet());
        }
        $form = $this->createForm(new DoorType(), $entity);

        return [
            'site' => $site,
            'entity' => $entity,
            'form' => $form->createView(),
        ];
    }

    /**
     * Creates a new Door entity.
     *
     * @Template("JLMModelBundle:Door:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $entity = new Door();
        $form = $this->createForm(new DoorType(), $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('door_show', ['id' => $entity->getId()]));
        }

        return [
            'entity' => $entity,
            'form' => $form->createView(),
        ];
    }

    /**
     * Displays a form to edit an existing Door entity.
     *
     * @Template()
     */
    public function editAction(Door $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $editForm = $this->createForm(DoorType::class, $entity);
        $deleteForm = $this->createDeleteForm($entity->getId());

        return [
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ];
    }


    /**
     * Edits an existing Door entity.
     *
     * @Template("JLMModelBundle:Door:edit.html.twig")
     */
    public function updateAction(Request $request, Door $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $em = $this->getDoctrine()->getManager();

        $editForm = $this->createForm(new DoorType(), $entity);
        $deleteForm = $this->createDeleteForm($entity->getId());
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('door_show', ['id' => $entity->getId()]));
        }

        return [
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ];
    }

    /**
     * Edits an existing Door entity.
     */
    public function updateCodeAction(Request $request, Door $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $codeForm = $this->createCodeForm($entity);
        $codeForm->handleRequest($request);

        if ($codeForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $code = $entity->getCode();
            $doublon = $em->getRepository('JLMModelBundle:Door')->findByCode($code);
            if (sizeof($doublon) > 0) {
                return $this->redirect($this->getRequest()->headers->get('referer'));
            }
            $em->persist($entity);
            $em->flush();
        }

        return $this->redirect($this->getRequest()->headers->get('referer'));
    }

    private function createCodeForm(Door $door)
    {
        $form = $this->createForm(
            new \JLM\ModelBundle\Form\Type\DoorTagType(),
            $door,
            [
                'action' => $this->generateUrl('model_door_update_code', ['id' => $door->getId()]),
                'method' => 'POST',
            ]
        );

        return $form;
    }

    /**
     * Deletes a Door entity.
     */
    public function deleteAction(Door $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $form = $this->createDeleteForm($entity->getId());
        $request = $this->getRequest();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('door'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(['id' => $id])
            ->add('id', HiddenType::class)
            ->getForm()
            ;
    }

    /**
     * Lists all Door entities.
     *
     * @Template()
     */
    public function geocodeAction()
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('JLMModelBundle:Door')->findBy(['latitude' => null]);
        $count = 0;
        $logs = [];
        foreach ($entities as $entity) {
            if ($entity->getLatitude() === null) {
                $em->persist($entity);
                $count++;
            }
        }
        $em->flush();

        return [
            'count' => $count,
            'logs' => $logs,
        ];
    }

    /**
     * Maps Door entities.
     *
     * @Template()
     */
    public function mapAction()
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $latMin = $lonMin = 40000;
        $latMax = $lonMax = -40000;
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('JLMModelBundle:Door')->findAll();
        foreach ($entities as $key => $entity) {
            if ($entity->getNextMaintenance() !== null && $entity->getActualContract() != null
                && $entity->getLatitude()
                !== null
                && $entity->getLongitude() !== null) {
                $latMin = min($latMin, $entity->getLatitude());
                $latMax = max($latMax, $entity->getLatitude());
                $lonMin = min($lonMin, $entity->getLongitude());
                $lonMax = max($lonMax, $entity->getLongitude());
            } else {
                unset($entities[$key]);
            }
        }
        $latCentre = ($latMin + $latMax) / 2;
        $lonCentre = ($lonMin + $lonMax) / 2;
        return [
            'entities' => $entities,
            'latCenter' => $latCentre,
            'lngCenter' => $lonCentre,
        ];
    }
}

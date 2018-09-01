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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\ContractBundle\Entity\Contract;
use JLM\ModelBundle\Entity\Door;
use JLM\FeeBundle\Entity\Fee;
use JLM\ContractBundle\Form\Type\ContractType;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class ContractController extends Controller
{
    /**
     * Lists all Contract entities.
     *
     * @Template()
     * @Secure(roles="ROLE_OFFICE")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('JLMContractBundle:Contract')->findAll();

        return ['entities' => $entities];
    }

    /**
     * Finds and displays a Contract entity.
     *
     * @Template()
     * @Secure(roles="ROLE_OFFICE")
     */
    public function showAction(Contract $entity)
    {
        return ['entity' => $entity];
    }

    /**
     * Displays a form to create a new Contract entity.
     *
     * @Template()
     * @Secure(roles="ROLE_OFFICE")
     */
    public function newAction(Door $door)
    {
        $entity = new Contract();
        if (!empty($door)) {
            $entity->setDoor($door);
            $entity->setTrustee($door->getAdministrator()->getTrustee());
        }

        $entity->setBegin(new \DateTime());
        $form = $this->createForm(new ContractType(), $entity);

        return [
            'entity' => $entity,
            'form' => $form->createView(),
        ];
    }

    /**
     * Creates a new Contract entity.
     *
     * @Template("JLMModelBundle:Contract:new.html.twig")
     * @Secure(roles="ROLE_OFFICE")
     */
    public function createAction()
    {
        $entity = new Contract();
        $request = $this->getRequest();
        $form = $this->createForm(new ContractType(), $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);

            // Temporaire : se fera jour par jour
            // ***********************************
            if ($entity->getInProgress()) {
                $fee = new Fee();
                $fee->addContract($entity);
                $fee->setTrustee($entity->getManager());
                $fee->setAddress($entity->getDoor()->getSite()->getAddress()->toString());
                $fee->setPrelabel($entity->getDoor()->getSite()->getBillingPrelabel());
                $fee->setVat($entity->getDoor()->getSite()->getVat());
                $em->persist($fee);
            }
            //***************************************

            $em->flush();

            return $this->redirect($this->generateUrl('door_show', ['id' => $entity->getDoor()->getId()]));
        }

        return [
            'entity' => $entity,
            'form' => $form->createView(),
        ];
    }

    /**
     * Stop a contract
     *
     * @Template("JLMModelBundle:Contract:stop.html.twig")
     * @Secure(roles="ROLE_OFFICE")
     */
    public function stopupdateAction(Contract $entity)
    {
        $editForm = $this->get('form.factory')->createNamed(
            'contractStop' . $entity->getId(),
            new ContractStopType(),
            $entity
        )
        ;
        $request = $this->getRequest();
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('door_show', ['id' => $entity->getDoor()->getId()]));
        }

        return [
            'entity' => $entity,
            'form' => $editForm->createView(),
        ];
    }

    /**
     * Stop a contract
     *
     * @Template()
     * @Secure(roles="ROLE_OFFICE")
     */
    public function stopAction(Contract $entity)
    {
        $form = $this->get('form.factory')->createNamed(
            'contractStop' . $entity->getId(),
            new ContractStopType(),
            $entity
        )
        ;
        return [
            'entity' => $entity,
            'form' => $form->createView(),
        ];
    }

    /**
     * Displays a form to edit an existing Contract entity.
     *
     * @Template()
     * @Secure(roles="ROLE_OFFICE")
     */
    public function editAction(Contract $entity)
    {
        $editForm = $this->get('form.factory')->createNamed(
            'contractEdit' . $entity->getId(),
            new ContractType(),
            $entity
        )
        ;
        return [
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        ];
    }

    /**
     * Edits an existing Contract entity.
     *
     * @Template("JLMModelBundle:Contract:edit.old.html.twig")
     * @Secure(roles="ROLE_OFFICE")
     */
    public function updateAction(Request $request, Contract $entity)
    {
        $editForm = $this->get('form.factory')->createNamed(
            'contractEdit' . $entity->getId(),
            new ContractType(),
            $entity
        )
        ;
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('door_show', ['id' => $entity->getDoor()->getId()]));
        }

        return [
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        ];
    }
}

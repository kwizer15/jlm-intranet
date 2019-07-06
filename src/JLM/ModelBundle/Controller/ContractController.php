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
     */
    public function indexAction()
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('JLMContractBundle:Contract')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Contract entity.
     *
     * @Template()
     */
    public function showAction(Contract $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        return array(
            'entity'      => $entity,
        );
    }
    
    /**
     * Displays a form to create a new Contract entity.
     *
     * @Template()
     */
    public function newAction(Door $door)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $entity = new Contract();
        if (!empty($door))
        {
        	$entity->setDoor($door);
        	$entity->setTrustee($door->getAdministrator()->getTrustee());
        }
  
        $entity->setBegin(new \DateTime);
        $form   = $this->createForm(new ContractType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Contract entity.
     *
     * @Template("JLMModelBundle:Contract:new.html.twig")
     */
    public function createAction()
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $entity  = new Contract();
        $request = $this->getRequest();
        $form    = $this->createForm(new ContractType(), $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            
            // Temporaire : se fera jour par jour
            // ***********************************
            if ($entity->getInProgress())
            {
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

            return $this->redirect($this->generateUrl('door_show', array('id' => $entity->getDoor()->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Stop a contract
     * 
     * @Template("JLMModelBundle:Contract:stop.html.twig")
     */
    public function stopupdateAction(Contract $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

    	$editForm   = $this->get('form.factory')->createNamed('contractStop'.$entity->getId(),new ContractStopType(), $entity);
        $request = $this->getRequest();
        $editForm->handleRequest($request);

        if ($editForm->isValid())
        {
        	$em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('door_show', array('id' => $entity->getDoor()->getId())));
        }

        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
        );
    }
    
    /**
     * Stop a contract
     *
     * @Template()
     */
    public function stopAction(Contract $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

    	$form = $this->get('form.factory')->createNamed('contractStop'.$entity->getId(),new ContractStopType(), $entity);
    	return array(
    			'entity'      => $entity,
    			'form'   => $form->createView(),
    	);
    }
    
    /**
     * Displays a form to edit an existing Contract entity.
     * 
     * @Template()
     */
    public function editAction(Contract $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $editForm    = $this->get('form.factory')->createNamed('contractEdit'.$entity->getId(),new ContractType(), $entity);
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Contract entity.
     *
     * @Template("JLMModelBundle:Contract:edit.old.html.twig")
     */
    public function updateAction(Request $request, Contract $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $editForm   = $this->get('form.factory')->createNamed('contractEdit'.$entity->getId(),new ContractType(), $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid())
        {
        	$em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('door_show', array('id' => $entity->getDoor()->getId())));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }
}

<?php

/*
 * This file is part of the JLMContractBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ContractBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\ContractBundle\Entity\Contract;
use JLM\ModelBundle\Entity\Door;
use JLM\FeeBundle\Entity\Fee;
use JLM\ContractBundle\Form\Type\ContractType;
use JLM\ContractBundle\Form\Type\ContractStopType;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class ContractController extends Controller
{
    /**
     * Lists all Contract entities.
     *
     * @Template()
     * @deprecated not used
     * @Secure(roles="ROLE_USER")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('JLMContractBundle:Contract')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Contract entity.
     *
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function showAction(Contract $entity)
    {
        return array(
            'entity'      => $entity,
        );
    }
    
    /**
     * Displays a form to create a new Contract entity.
     *
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function newAction(Door $door)
    {
        $entity = new Contract();
        if (!empty($door))
        {
        	$entity->setDoor($door);
        	$entity->setTrustee($door->getSite()->getTrustee());
        }
  
        $entity->setBegin(new \DateTime);
        $form   = $this->createNewForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Contract entity.
     *
     * @Template("JLMContractBundle:Contract:new.html.twig")
     * @Secure(roles="ROLE_USER")
     */
    public function createAction(Request $request)
    {
        $entity  = new Contract();
        $form    = $this->createNewForm($entity);
        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            
            // Temporaire : se fera jour par jour
            // ***********************************
            if ($entity->getInProgress())
            {
            	$fee = new Fee();
            	$fee->addContract($entity);
            	$fee->setTrustee($entity->getTrustee());
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
     * @Template("JLMContractBundle:Contract:stop.html.twig")
     * @Secure(roles="ROLE_USER")
     */
    public function stopupdateAction(Contract $entity)
    {
    	$editForm   = $this->createStopForm($entity);
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
     * @Secure(roles="ROLE_USER")
     */
    public function stopAction(Contract $entity)
    {
    	$form = $this->createStopForm($entity);
    	
    	return array(
    			'entity'      => $entity,
    			'form'   => $form->createView(),
    	);
    }
    
    /**
     * Displays a form to edit an existing Contract entity.
     *
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function editAction(Contract $entity)
    {
        $editForm    = $this->createEditForm($entity);
        
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Contract entity.
     *
     * @Template("JLMContractBundle:Contract:edit.old.html.twig")
     * @Secure(roles="ROLE_USER")
     */
    public function updateAction(Request $request, Contract $entity)
    {
        $editForm = $this->createEditForm($entity);
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
    
    /**
     * Create an edit form
     * @param Contract $entity
     * @return \Symfony\Component\Form\Form
     */
    private function createEditForm(Contract $entity)
    {
        return $this->get('form.factory')->createNamed('contractEdit'.$entity->getId(),new ContractType(), $entity,
            array(
                'action' => $this->generateUrl('jlm_contract_contract_update', array('id'=>$entity->getId())),
                'method' => 'POST',
            )
        );
    }
    
    /**
     * Create a stop form
     * @param Contract $entity
     * @return \Symfony\Component\Form\Form
     */
    private function createStopForm(Contract $entity)
    {
        return $this->get('form.factory')->createNamed('contractStop'.$entity->getId(),new ContractStopType(), $entity,
            array(
                'action' => $this->generateUrl('jlm_contract_contract_stopupdate', array('id'=>$entity->getId())),
                'method' => 'POST',
            )
        );
    }
    
    /**
     * Create a new form
     * @param Contract $entity
     * @return \Symfony\Component\Form\Form
     */
    private function createNewForm(Contract $entity)
    {
        return $this->createForm(new ContractType(), $entity,
            array(
                'action' => $this->generateUrl('jlm_contract_contract_create', array('id'=>$entity->getId())),
                'method' => 'POST',
            )
        );
    }
    
}

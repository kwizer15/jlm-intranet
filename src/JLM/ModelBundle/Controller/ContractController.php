<?php

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
 * Contract controller.
 *
 * Route("/contract")
 */
class ContractController extends Controller
{
    /**
     * Lists all Contract entities.
     *
     * Route("/", name="contract")
     * @Template()
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
     * Route("/{id}/show", name="contract_show")
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
     * Route("/new/{id}", name="contract_new")
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
        $form   = $this->createForm(new ContractType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Contract entity.
     *
     * Route("/create", name="contract_create")
     * Method("post")
     * @Template("JLMModelBundle:Contract:new.html.twig")
     * @Secure(roles="ROLE_USER")
     */
    public function createAction()
    {
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
     * Route("/{id}/stopupdate", name="contract_stopupdate")
     * @Template("JLMModelBundle:Contract:stop.html.twig")
     * @Secure(roles="ROLE_USER")
     */
    public function stopupdateAction(Contract $entity)
    {
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
     * Route("/{id}/stop", name="contract_stop")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function stopAction(Contract $entity)
    {
    	$form = $this->get('form.factory')->createNamed('contractStop'.$entity->getId(),new ContractStopType(), $entity);
    	return array(
    			'entity'      => $entity,
    			'form'   => $form->createView(),
    	);
    }
    
    /**
     * Displays a form to edit an existing Contract entity.
     *
     * @Route("/{id}/edit", name="contract_edit")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function editAction(Contract $entity)
    {
        $editForm    = $this->get('form.factory')->createNamed('contractEdit'.$entity->getId(),new ContractType(), $entity);
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Contract entity.
     *
     * Route("/{id}/update", name="contract_update")
     * Method("post")
     * @Template("JLMModelBundle:Contract:edit.old.html.twig")
     * @Secure(roles="ROLE_USER")
     */
    public function updateAction(Request $request, Contract $entity)
    {
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

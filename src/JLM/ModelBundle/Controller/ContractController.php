<?php

namespace JLM\ModelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\ModelBundle\Entity\Contract;
use JLM\ModelBundle\Entity\Door;
use JLM\ModelBundle\Form\Type\ContractType;
use JLM\ModelBundle\Form\Type\ContractStopType;

/**
 * Contract controller.
 *
 * @Route("/contract")
 */
class ContractController extends Controller
{
    /**
     * Lists all Contract entities.
     *
     * @Route("/", name="contract")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('JLMModelBundle:Contract')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Contract entity.
     *
     * @Route("/{id}/show", name="contract_show")
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
     * @Route("/new/{id}", name="contract_new")
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
     * @Route("/create", name="contract_create")
     * @Method("post")
     * @Template("JLMModelBundle:Contract:new.html.twig")
     * @Secure(roles="ROLE_USER")
     */
    public function createAction()
    {
        $entity  = new Contract();
        $request = $this->getRequest();
        $form    = $this->get('form.factory')->createNamed('contractEdit'.$entity->getId(),new ContractType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
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
     * @Route("/{id}/stopupdate", name="contract_stopupdate")
     * @Template("JLMModelBundle:Contract:stop.html.twig")
     * @Secure(roles="ROLE_USER")
     */
    public function stopupdateAction(Contract $entity)
    {
    	$editform   = $this->get('form.factory')->createNamed('contractStop'.$entity->getId(),new ContractStopType(), $entity);
        $request = $this->getRequest();
        $editForm->bindRequest($request);

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
     * @Route("/{id}/stop", name="contract_stop")
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
     * @Route("/{id}/update", name="contract_update")
     * @Method("post")
     * @Template("JLMModelBundle:Contract:edit.html.twig")
     * @Secure(roles="ROLE_USER")
     */
    public function updateAction(Contract $entity)
    {
        $editForm   = $this->createForm(new ContractType(), $entity);
        $request = $this->getRequest();
        $editForm->bindRequest($request);

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

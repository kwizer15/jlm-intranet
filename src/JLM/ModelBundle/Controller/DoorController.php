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

        return array('entities' => $entities);
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
		
        $contracts = $em->getRepository('JLMContractBundle:Contract')->findByDoor($entity,array('begin'=>'DESC'));

        // Modal nouveau contrat
        $contractNew = new Contract();
        $contractNew->setDoor($entity);
        $contractNew->setTrustee($entity->getAdministrator()->getTrustee());
        $contractNew->setBegin(new \DateTime);
        $form_contractNew   = $this->createForm(new ContractType(), $contractNew);

        // Formulaires d'edition des contrat
        $form_contractEdits = $form_contractStops = array();
        foreach ($contracts as $contract)
        {
        	$form_contractEdits[] = $this->get('form.factory')->createNamed('contractEdit'.$contract->getId(),new ContractType(), $contract)->createView();
        	$form_contractStops[] = $this->get('form.factory')->createNamed('contractStop'.$contract->getId(),new ContractStopType(), $contract)->createView();
        }
        
        return array(
            'entity'      => $entity,
        	'contracts'	  => $contracts,
        	'form_contractNew'   => $form_contractNew->createView(),
        	'form_contractEdits' => $form_contractEdits,
        	'form_contractStops' => $form_contractStops,
        );
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
        if ($site)
        {
        	$entity->setAdministrator($site);
        	$entity->setStreet($site->getAddress()->getStreet());
        }
        $form   = $this->createForm(new DoorType(), $entity);

        return array(
        	'site'   => $site,
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Door entity.
     *
     * @Template("JLMModelBundle:Door:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $entity  = new Door();
        $form    = $this->createForm(new DoorType(), $entity);
        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('door_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Door entity.
     *
     * @Template()
     */
    public function editAction(Door $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');

        $editForm = $this->createForm(new DoorType(), $entity);
        $deleteForm = $this->createDeleteForm($entity->getId());

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
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
        
        $editForm   = $this->createForm(new DoorType(), $entity);
        $deleteForm = $this->createDeleteForm($entity->getId());
        $editForm->handleRequest($request);

        if ($editForm->isValid())
        {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('door_show', array('id' => $entity->getId())));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    
    /**
     * Edits an existing Door entity.
     */
    public function updateCodeAction(Request $request, Door $entity)
    {
        $this->denyAccessUnlessGranted('ROLE_OFFICE');
 
        $codeForm = $this->_createCodeForm($entity);
        $codeForm->handleRequest($request);
    
        if ($codeForm->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $code = $entity->getCode();
            $doublon = $em->getRepository('JLMModelBundle:Door')->findByCode($code);
            if (sizeof($doublon) > 0)
            {
                return $this->redirect($this->getRequest()->headers->get('referer'));
            }
            $em->persist($entity);
            $em->flush();
        }
    
        return $this->redirect($this->getRequest()->headers->get('referer'));
    }

    private function _createCodeForm(Door $door)
	{
		$form = $this->createForm(new \JLM\ModelBundle\Form\Type\DoorTagType(), $door,
		array('action'=>$this->generateUrl('model_door_update_code',array('id'=>$door->getId())),
		    'method'=>'POST'));
                    
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

        if ($form->isValid())
        {
        	$em = $this->getDoctrine()->getManager();
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('door'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
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
    
    	$entities = $em->getRepository('JLMModelBundle:Door')->findBy(array('latitude'=>null));
    	$count = 0;
    	$logs = array();
    	foreach ($entities as $entity)
    	{
    		if ($entity->getLatitude() === null)
    		{
    			$em->persist($entity);
//	    		$address = str_replace(array(' - ',' ',chr(10)),'+',$entity->getAddress()->toString());
//	    		$url = 'http://maps.googleapis.com/maps/api/geocode/json?sensor=false&address='.$address;
//	    		$string = file_get_contents($url);
//	    		$json = json_decode($string);
//	    	//	var_dump($json); exit;
//	    	
//	    		if ($json->status == "OK")
//	    		{
//	    			if (sizeof($json->results) > 1)
//	    			{
//	    				$logs[] = 'multi : '.$address.'<br>';
//	    			}
//	    			else
//	    			{
	    				$count++;
//		    			foreach ($json->results as $result)
//		    			{
//		    				$lat = $result->geometry->location->lat;
//		    				$lng = $result->geometry->location->lng;
//		    				$entity->setLatitude($lat);
//		    				$entity->setLongitude($lng);
//		    				$em->persist($entity);
//		    			}
//	    			}
//	    		}
//	    		else
//	    		{
//	    			$logs[] = $json->status.' : '.$address.'<br>';
//	    		}
    		}
		}
    	$em->flush();
    	
    	return array('count' => $count,'logs' => $logs);
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
    	foreach ($entities as $key => $entity)
    	{
    		if ($entity->getNextMaintenance() !== null && $entity->getActualContract() != null && $entity->getLatitude() !== null && $entity->getLongitude() !== null)
    		{
    			$latMin = min($latMin,$entity->getLatitude());
    			$latMax = max($latMax,$entity->getLatitude());
    			$lonMin = min($lonMin,$entity->getLongitude());
    			$lonMax = max($lonMax,$entity->getLongitude());
    		}
    		else {unset($entities[$key]);}
    	}
    	$latCentre = ($latMin + $latMax)/2;
    	$lonCentre = ($lonMin + $lonMax)/2;
    	return array('entities'=>$entities,
    			'latCenter' => $latCentre, 'lngCenter' => $lonCentre,);
    }
}

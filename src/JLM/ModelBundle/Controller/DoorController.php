<?php

namespace JLM\ModelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\ModelBundle\Entity\Site;
use JLM\ModelBundle\Entity\Door;
use JLM\ModelBundle\Entity\Contract;
use JLM\ModelBundle\Form\Type\DoorType;
use JLM\ModelBundle\Form\Type\ContractType;
use JLM\ModelBundle\Form\Type\ContractStopType;

/**
 * Door controller.
 *
 * @Route("/door")
 */
class DoorController extends Controller
{
    /**
     * Lists all Door entities.
     *
     * @Route("/", name="door")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('JLMModelBundle:Door')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Door entity.
     *
     * @Route("/{id}/show", name="door_show")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function showAction(Door $entity)
    {
        $em = $this->getDoctrine()->getManager();
		
        $contracts = $em->getRepository('JLMModelBundle:Contract')->findByDoor($entity,array('begin'=>'DESC'));

        // Modal nouveau contrat
        $contractNew = new Contract();
        $contractNew->setDoor($entity);
        $contractNew->setTrustee($entity->getSite()->getTrustee());
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
     * @Route("/new", name="door_new")
     * @Route("/new/{id}", name="door_new_id")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function newAction(Site $site = null)
    {
        $entity = new Door();
        if ($site)
        {
        	$entity->setSite($site);
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
     * @Route("/create", name="door_create")
     * @Method("post")
     * @Template("JLMModelBundle:Door:new.html.twig")
     * @Secure(roles="ROLE_USER")
     */
    public function createAction()
    {
        $entity  = new Door();
        $request = $this->getRequest();
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
     * @Route("/{id}/edit", name="door_edit")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function editAction(Door $entity)
    {
        $em = $this->getDoctrine()->getManager();

        $editForm = $this->createForm(new DoorType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    
    

    /**
     * Edits an existing Door entity.
     *
     * @Route("/{id}/update", name="door_update")
     * @Method("post")
     * @Template("JLMModelBundle:Door:edit.html.twig")
     * @Secure(roles="ROLE_USER")
     */
    public function updateAction(Door $entity)
    {
        $em = $this->getDoctrine()->getManager();
        
        $editForm   = $this->createForm(new DoorType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('door_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    
    /**
     * Edits an existing Door entity.
     *
     * @Route("/{id}/updatecode", name="model_door_update_code")
     * @Method("PUT")
     * @Secure(roles="ROLE_USER")
     */
    public function updateCodeAction(Door $entity)
    {
        $em = $this->getDoctrine()->getManager();
    
        $codeForm   = $this->_createCodeForm($entity);
    
        $codeForm->handleRequest($this->getRequest());
    
        if ($codeForm->isValid()) {
            $em->persist($entity);
            $em->flush();
    
            
        }
    
        return $this->redirect($this->getRequest()->headers->get('referer'));
    }

    private function _createCodeForm(Door $door)
	{
		$form = $this->createForm(new \JLM\ModelBundle\Form\Type\DoorTagType(), $door,
		array('action'=>$this->generateUrl('model_door_update_code',array('id'=>$door->getId())),
		    'method'=>'PUT'));
                    
		return $form;
	}
    
    /**
     * Deletes a Door entity.
     *
     * @Route("/{id}/delete", name="door_delete")
     * @Method("post")
     * @Secure(roles="ROLE_USER")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('JLMModelBundle:Door')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Door entity.');
            }

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
     * @Route("/geocode", name="door_geocode")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function geocodeAction()
    {
    	$em = $this->getDoctrine()->getManager();
    
    	$entities = $em->getRepository('JLMModelBundle:Door')->findAll();
    	$count = 0;
    	$logs = array();
    	foreach ($entities as $entity)
    	{
    		if ($entity->getLatitude() === null)
    		{
	    		$address = str_replace(array(' - ',' ',chr(10)),'+',$entity->getAddress()->toString());
	    		$url = 'http://maps.googleapis.com/maps/api/geocode/json?sensor=false&address='.$address;
	    		$string = file_get_contents($url);
	    		$json = json_decode($string);
	    	//	var_dump($json); exit;
	    	
	    		if ($json->status == "OK")
	    		{
	    			if (sizeof($json->results) > 1)
	    				$logs[] = 'multi : '.$address.'<br>';
	
	    			else
	    			{
	    				$count++;
		    			foreach ($json->results as $result)
		    			{
		    				$lat = $result->geometry->location->lat;
		    				$lng = $result->geometry->location->lng;
		    				$entity->setLatitude($lat);
		    				$entity->setLongitude($lng);
		    				$em->persist($entity);
		    			}
	    			}
	    		}
	    		else 
	    			$logs[] = $json->status.' : '.$address.'<br>';
    		}
		}
    	$em->flush();
    	return array('count' => $count,'logs' => $logs);
    }
    
    /**
     * Maps Door entities.
     *
     * @Route("/map", name="door_map")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function mapAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$entities = $em->getRepository('JLMModelBundle:Door')->findAll();
    	$url = 'http://maps.googleapis.com/maps/api/staticmap?center=Paris&zoom=10&size=1800x1800&sensor=false';
    	$i = 0;
    	foreach ($entities as $entity)
    	{
    		if ($i > 46)
    		return array('url'=>$url);
    		if ($entity->getActualContract() !== null)
    		{
    			$url .= '&markers=color:blue%7C'.$entity->getCoordinates();
    			$i++;
    		}
    	}
    	return array('url'=>$url);
    }
}

<?php

namespace JLM\TransmitterBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JLM\DefaultBundle\Entity\Search;
use JLM\DefaultBundle\Form\Type\SearchType;

class DefaultController extends Controller
{
    /**
     * @Route("/search",name="transmitter_search")
     * @Method("POST")
     * @Template()
     */
    public function searchAction(Request $request)
    {
    	$entity = new Search;
    	$form = $this->createForm(new SearchType(), $entity);
    	$form->handleRequest($request);
    	if ($form->isValid())
    	{
    		$em = $this->getDoctrine()->getManager();
    		return array(
    				'layout'=>array('form_search_query'=>$entity),
    				'transmitters' => $em->getRepository('JLMTransmitterBundle:Transmitter')->search($entity),
    		//		'attributions' => $em->getRepository('JLMTransmitterBundle:Attribution')->search($entity),
    				'asks'          => $em->getRepository('JLMTransmitterBundle:Ask')->search($entity),
    		);
    	}
        return array('layout'=>array('form_search_query'=>$entity->getQuery()),);
    }
}

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
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\ContactBundle\Manager\ContactManager;
use JLM\ContactBundle\Form\Type\PersonType;
use JLM\ContactBundle\Entity\Person;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Person controller.
 */
class AjaxCorporationController extends Controller
{
    /**
     * Person json
     */
    public function searchAction()
    {
    	$request = $this->get('request');
    	$term = $request->get('q');
    	$page_limit = $request->get('page_limit');
    	$em = $this->getDoctrine()->getManager();
    	$contacts = $em->getRepository('JLMContactBundle:Corporation')->getArray($term, $page_limit);
    	
    	return new JsonResponse(array('corporations' => $contacts));
    }
    
    /**
     * Person json
     */
    public function jsonAction()
    {
    	$request = $this->get('request');
    	$id = $request->get('id');
    	$em = $this->getDoctrine()->getManager();
    	$contact = $em->getRepository('JLMContactBundle:Corporation')->getByIdToArray($id);
    
    	return new JsonResponse($contact);
    }
}
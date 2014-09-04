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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class CityController extends Controller
{
	/**
	 * City json
	 *
	 * @Method("get")
	 */
	public function searchAction(Request $request)
	{
		$term = $request->get('q');
		$page_limit = $request->get('page_limit');
		
		$em = $this->getDoctrine()->getManager();
		
		$cities = $em->getRepository('JLMContactBundle:City')->getArray($term, $page_limit);
		return new JsonResponse(array('cities' => $cities));
	}
	
	/**
	 * City json
	 *
	 * @Method("get")
	 */
	public function jsonAction(Request $request)
	{
		$id = $request->get('id');
		$em = $this->getDoctrine()->getManager();
		$city = $em->getRepository('JLMContactBundle:City')->getByIdToArray($id);
		
		return new JsonResponse($city);
	}
}
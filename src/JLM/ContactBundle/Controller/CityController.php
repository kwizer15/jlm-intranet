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

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class CityController extends Controller
{
	/**
	 * City json
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
	 */
	public function jsonAction(Request $request)
	{
		$id = $request->get('id');
		$em = $this->getDoctrine()->getManager();
		$city = $em->getRepository('JLMContactBundle:City')->getByIdToArray($id);
		
		return new JsonResponse($city);
	}
}
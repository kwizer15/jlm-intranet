<?php
namespace JLM\ModelBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\ModelBundle\Entity\City;

class CityController extends Controller
{
	/**
	 * City json
	 *
	 * @Route("/cities.json", name="jlm_model_citysearch_json")
	 * @Method("get")
	 * @Secure(roles="ROLE_USER")
	 */
	public function searchAction(Request $request)
	{
		$term = $request->get('q');
		$page_limit = $request->get('page_limit');
		
		$em = $this->getDoctrine()->getManager();
		
		$cities = $em->getRepository('JLMModelBundle:City')->getArray($term, $page_limit);
		return new JsonResponse(array('cities' => $cities));
	}
	
	/**
	 * City json
	 *
	 * @Route("/city.json", name="jlm_model_city_json")
	 * @Method("get")
	 * @Secure(roles="ROLE_USER")
	 */
	public function jsonAction(Request $request)
	{
		$id = $request->get('id');
		$em = $this->getDoctrine()->getManager();
		$city = $em->getRepository('JLMModelBundle:City')->getByIdToArray($id);
		
		return new JsonResponse($city);
	}
}
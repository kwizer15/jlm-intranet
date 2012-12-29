<?php

namespace JLM\ModelBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;

class DefaultController extends Controller
{
    /**
     * Resultats de la barre de recherche.
     *
     * @Route("/search", name="model_search")
     * @Method("post")
     * @Secure(roles="ROLE_USER")
     * @Template()
     */
    public function searchAction(Request $request)
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	$query = $request->request->get('query');
    	$doors = $em->getRepository('JLMModelBundle:Door')->search($query);
    	$sites = $em->getRepository('JLMModelBundle:Site')->search($query);
    	$trustees = $em->getRepository('JLMModelBundle:Trustee')->search($query);
    	$suppliers = $em->getRepository('JLMModelBundle:Supplier')->search($query);
//    	$productcategories = $em->getRepository('JLMModelBundle:ProductCategory')->search($query);
    	$products = $em->getRepository('JLMModelBundle:Product')->search($query);
    	return array(
    			'query'   => $query,
    			'doors'   => $doors,
    			'sites'   => $sites,
    			'trustees'=> $trustees,
    			'suppliers'=> $suppliers,
//    			'productcategories' => $productcategories,
    			'products' => $products,
    			
    	);
    }
}

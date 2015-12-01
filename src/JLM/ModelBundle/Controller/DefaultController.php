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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use JLM\CoreBundle\Entity\Search;
use JLM\CoreBundle\Form\Type\SearchType;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class DefaultController extends Controller
{
    /**
     * Resultats de la barre de recherche.
     *
     * @Secure(roles="ROLE_OFFICE")
     * @Template()
     */
    public function searchAction(Request $request)
    {
    	$formData = $request->get('jlm_core_search');

    	if (is_array($formData) && array_key_exists('query', $formData))
    	{
    		$em = $this->getDoctrine()->getManager();
    		$query = $formData['query'];
    		return array(
    				'query' => $query,
    				'contacts' => $em->getRepository('JLMContactBundle:Contact')->search($query),
    				'doors'   => $em->getRepository('JLMModelBundle:Door')->search($query),
    				'sites'   => $em->getRepository('JLMModelBundle:Site')->search($query),
    				'trustees'=> $em->getRepository('JLMModelBundle:Trustee')->search($query),
    				'suppliers'=> $em->getRepository('JLMProductBundle:Supplier')->search($query),
    				'products' => $em->getRepository('JLMProductBundle:Product')->search($query),
    		);
    	}
    	return array();
    }
    
    /**
     * Upgrade contacts
     * 
     * @Template()
     */
    public function upgradeAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$repo = $em->getRepository('JLMModelBundle:SiteContact');
    	$contacts = $repo->findAll();
    	foreach ($contacts as $contact)
    	{
    		$role = $contact->getOldRole();
    		$person = $contact->getPerson();
    		$person->setRole($role);
    		$em->persist($person);
    	}
    	$quotes = $em->getRepository('JLMCommerceBundle:Quote')->findAll();
    	foreach ($quotes as $quote)
    	{
    		$contact = $quote->getContact();
    		if ($contact !== null)
    			$quote->setContactPerson($contact->getPerson());
    		$em->persist($quote);
    	}
    	$em->flush();
    	return array();
    }
}

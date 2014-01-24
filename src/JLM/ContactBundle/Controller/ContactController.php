<?php

/*
 * This file is part of the JLM package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ContactBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Doctrine\ORM\EntityManager;

/**
 * Person controller.
 *
 * @Route("/contact")
 */
class ContactController extends Controller
{
    /**
     * Redirect to the Contact edit controller
     *
     * @Route("/{id}/edit", name="jlm_contact_contact_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $entity = $this->getEntity($id);
        $c = get_class($entity);
        $c = str_replace('JLM\\ContactBundle\\Entity\\','',$c);
 //      $d = $this->generateUrl('jlm_contact_'.strtolower($c).'_edit',array('id' => $id));
        $c = 'JLMContactBundle:'.$c.':edit';
        
 //       return $this->redirect($d);
        return $this->forward($c,array('id' => $id));
    }
    
    /**
     * Get entity with id
     * @param int $id
     * @return Contact
     */
    private function getEntity($id, EntityManager $em = null)
    {
    	if (null === $em)
    	{
    		$em = $this->getDoctrine()->getManager();
    	}
    	
    	$entity = $em->getRepository('JLMContactBundle:Contact')->find($id);
    	if (!$entity)
    	{
    		throw $this->createNotFoundException('Unable to find Contact entity.');
    	}
    	
    	return $entity;
    }
}

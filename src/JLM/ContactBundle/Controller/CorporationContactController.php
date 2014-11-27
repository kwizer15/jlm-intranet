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

use JLM\CoreBundle\Form\Handler\DoctrineHandler;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Form\Exception\LogicException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use JLM\ContactBundle\Form\Type\CorporationContactType;
use JLM\ContactBundle\Entity\CorporationContact;

/**
 * Person controller.
 */
class CorporationContactController extends Controller
{
	/**
	 * Edit or add a contact
	 * @param int|string $id The entity identifier or typeof new entity
	 */
	public function editAction($id = 0)
	{
		$request = $this->container->get('request');
		if ($id)
		{
			$entity = $this->getEntity($id);
			$method = 'PUT';
		}
		else {
			$entity = $this->getNewEntity();
			$method = 'POST';
			$corpoId = $request->get('corporation_id');
			if ($corpoId)
			{
				$em = $this->get('doctrine')->getManager();
				$corpo = $em->getRepository('JLMContactBundle:Corporation')->find($corpoId);
				$entity->setCorporation($corpo);
			}
		}
		$form = $this->createContactForm($method, $entity);
		
		$em = $this->container->get('doctrine')->getManager();
		$handler = new DoctrineHandler($form, $request, $em);
	
		if ($request->isXmlHttpRequest())
		{
			if ($handler->process($method))
			{
				return new Response('form valid');
			}
			
			return $this->render('JLMContactBundle:CorporationContact:modal_new.html.twig', array('form'=>$form->createView()));
		}
		
		if ($handler->process($method))
		{
			$router = $this->container->get('router');
			$url = $router->generate('jlm_contact_contact_show', array('id' => $entity->getCorporation()->getId()));
			 
			return new RedirectResponse($url);
		}
	
		return $this->render('JLMContactBundle:CorporationContact:new.html.twig', array('form'=>$form->createView()));
	}
	
	private function createContactForm($method, CorporationContact $entity)
	{
		$url = '';
		switch ($method)
		{
			case 'POST':
				$url = $this->generateUrl('jlm_contact_corporationcontact_new');
				break;
			case 'PUT':
				$url = $this->generateUrl('jlm_contact_corporationcontact_edit', array('id' => $entity->getId()));
				break;
			default:
				throw new LogicException('HTTP request method must be POST or PUT only');
		}
		 
		$form = $this->container->get('form.factory')->create($this->getFormType(), $entity,
				array(
						'action' => $url,
						'method' => $method,
				)
		);
		$form->add('submit','submit',array('label'=>'Enregistrer'));
	
		return $form;
	}
    
    private function getEntity($id)
    {
        $em = $this->container->get('doctrine')->getManager();
        $entity = $em->getRepository('JLMContactBundle:CorporationContact')->find($id);
        if (!$entity)
        {
            throw $this->createNotFoundException('Unable to find CorporationContact entity.');
        }
    
        return $entity;
    }
    
    /**
     * @return \JLM\ContactBundle\Form\Type\CorporationContactType| null
     */
    private function getFormType()
    {
    	return new CorporationContactType();
    }
    
    /**
     * 
     * @return CorporationContact
     */
    private function getNewEntity()
    {
    	return new CorporationContact();
    }
}
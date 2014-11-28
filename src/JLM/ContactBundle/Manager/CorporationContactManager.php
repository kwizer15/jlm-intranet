<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ContactBundle\Manager;

use JLM\ContactBundle\Entity\CorporationContact;
use JLM\ContactBundle\Form\Type\CorporationContactType;
use Symfony\Component\DependencyInjection\Exception\LogicException;
use JLM\CoreBundle\Form\Handler\DoctrineHandler;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class CorporationContactManager extends ContainerAware
{
	protected $class;
	
	protected $form;
	
	protected $handler;
	
	protected $router;
	
	protected $formFactory;
	
	protected $request;
	
	protected $om;
	
	public function __construct($class)
	{
		$this->class = $class;
	}
	
	public function setServices()
	{
		$this->om = $this->container->get('doctrine')->getManager();
		$this->formFactory = $this->container->get('form.factory');
		$this->request = $this->container->get('request');
		$this->router = $this->container->get('router');
	}
	
	public function getRepository()
	{
		return $this->om->getRepository('JLMContactBundle:CorporationContact');
	}
	
	public function renderResponse($view, array $parameters = array(), Response $response = null)
	{
		return $this->container->get('templating')->renderResponse($view, $parameters, $response);
	}
	
	public function getEntity($id = null)
	{
		$entity = $this->getRepository()->find($id);
		if (!$entity)
		{
			$class = $this->class;
			
			$entity = new $class();
			if ($corpo = $this->setterFromRequest('corporation_id', 'JLMContactBundle:Corporation'))
			{
				$entity->setCorporation($corpo);
			}
			if ($person = $this->setterFromRequest('person_id', 'JLMContactBundle:Person'))
			{
				$entity->setContact($person);
			}
		}
		
		return $entity;
	}
	
	private function setterFromRequest($param, $repoName)
	{
		$id = $this->request->get($param);
		if ($id)
		{
			$entity = $this->om->getRepository($repoName)->find($id);
	
			return $entity;
		}
	
		return null;
	}
	
	public function createNewForm($entity)
	{
		return $this->createForm('POST', $entity);
	}
	
	public function createEditForm($entity)
	{
		return $this->createForm('PUT', $entity);
	}
	
	public function createDeleteForm($entity)
	{
		return $this->createForm('DELETE', $entity);
	}
	
	public function createForm($method, $entity)
	{
		$id = $entity->getId();
		$url = '';
		$label = '';
		$type = null;
		switch ($method)
		{
			case 'POST':
				$url = $this->router->generate('jlm_contact_corporationcontact_create');
				$label = 'Créer';
				$type = $this->getFormType();
				break;
			case 'PUT':
				$url = $this->router->generate('jlm_contact_corporationcontact_update', array('id' => $id));
				$label = 'Modifier';
				$type = $this->getFormType();
				break;
			case 'DELETE':
				$url = $this->router->generate('jlm_contact_corporationcontact_delete', array('id' => $id));
				$label = 'Supprimer';
				$type = 'form';
				break;
			default:
				throw new LogicException('HTTP request method must be POST, PUT or DELETE only');
		}
		$form = $this->formFactory->create($type, $entity,
				array(
						'action' => $url,
						'method' => $method,
				)
		);
		$form->add('submit','submit', array('label' => $label));

		return $form;
	}
	
	public function getEditUrl($id)
	{
		return $this->router->generate('jlm_contact_corporationcontact_edit', array('id' => $id));
	}
	
	public function redirectReferer()
	{
		return new RedirectResponse($this->request->headers->get('referer'));
	}
	
	public function getFormType()
	{
		return new CorporationContactType();
	}
	
	public function getRouter()
	{
		return $this->router;
	}
	
	public function getObjectManager()
	{
		return $this->doctrine;
	}
	
	public function getFormFactory()
	{
		return $this->formFactory;
	}
	
	public function getRequest()
	{
		return $this->request;
	}
	
	public function getForm()
	{
		return $this->form;
	}
	
	public function getHandler($form, $entity)
	{
		return new DoctrineHandler($form, $this->request, $this->om, $entity);
	}
}
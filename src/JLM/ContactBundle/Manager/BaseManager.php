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
abstract class BaseManager extends ContainerAware
{
	protected $class;

	protected $request;

	protected $om;
	
	protected $router;

	public function __construct($class)
	{
		$this->class = $class;
	}

	public function setServices()
	{
		$this->om = $this->container->get('doctrine')->getManager();
		$this->request = $this->container->get('request');
		$this->router = $this->container->get('router');
	}

	public function getRepository()
	{
		return $this->om->getRepository($this->class);	// A tester
	}

	public function renderResponse($view, array $parameters = array(), Response $response = null)
	{
		return $this->container->get('templating')->renderResponse($view, $parameters, $response);
	}

	abstract public function getEntity($id = null);

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

	public function createForm($method, $entity)
	{
		$datas = $this->getFormParam($entity);
		if (array_key_exists($method, $datas))
		{
			$param = $datas[$method];
			$form = $this->getFormFactory()->create($param['type'], $entity,
					array(
							'action' => $param['url'],
							'method' => $method,
					)
			);
			$form->add('submit','submit', array('label' => $param['label']));
			
			return $form;
		}
		
		throw new LogicException('HTTP request method must be POST, PUT or DELETE only');
	}
	
	abstract function getFormParam($entity);
	
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

	public function redirectReferer()
	{
		return new RedirectResponse($this->request->headers->get('referer'));
	}
	
	public function redirect($url, $status = 302)
	{
		return new RedirectResponse($url, $status);
	}
	
	abstract public function getFormType($type = null);

	public function redirect($url, $status = 302)
    {
    	return new RedirectResponse($url, $status);
    }

	public function getObjectManager()
	{
		return $this->om;
	}

	public function getFormFactory()
	{
		return $this->container->get('form.factory');
	}

	public function getRequest()
	{
		return $this->request;
	}

	public function getSession()
    {
    	return $this->container->get('session');
    }

	public function getHandler($form, $entity)
	{
		return new DoctrineHandler($form, $this->request, $this->om, $entity);
	}
}
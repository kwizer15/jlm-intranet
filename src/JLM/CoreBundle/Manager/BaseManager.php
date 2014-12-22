<?php

/*
 * This file is part of the JLMCoreBundle package.
*
* (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace JLM\CoreBundle\Manager;

use JLM\CoreBundle\Form\Handler\DoctrineHandler;
use Symfony\Component\DependencyInjection\Exception\LogicException;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\EventDispatcher\Event;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class BaseManager extends ContainerAware implements ManagerInterface
{
	protected $class;

	protected $request;

	protected $om;
	
	protected $router;

	public function secure($role)
	{
		if (false === $this->container->get('security.context')->isGranted($role))
		{
			throw new AccessDeniedException();
		}
	}
	
	
	public function getEntity($id = null)
	{
		if ($id === null)
		{
			return null;
		}
		
		return $this->getRepository()->find($id);
	}
	
	protected function getFormParam($name, $options = array())
	{
		return null;
	}
	
	protected function getFormType($type = null)
	{
		return 'form';
	}

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
		return $this->om->getRepository($this->class);
	}

	public function renderResponse($view, array $parameters = array(), Response $response = null)
	{
		return $this->container->get('templating')->renderResponse($view, $parameters, $response);
	}

	protected function setterFromRequest($param, $repoName)
	{
		if ($id = $this->request->get($param))
		{
			return $this->om->getRepository($repoName)->find($id);
		}

		return null;
	}

	public function createForm($name, $options = array())
	{
		$param = $this->getFormParam($name, $options);
		if ($param !== null)
		{
			$form = $this->getFormFactory()->create($param['type'], $param['entity'],
					array(
							'action' => $this->router->generate($param['route'], $param['params']),
							'method' => $param['method'],
					)
			);
			$form->add('submit','submit', array('label' => $param['label']));

			return $this->populateForm($form);
		}
		
		throw new LogicException('HTTP request method must be POST, PUT or DELETE only');
	}
	
	public function populateForm($form)
	{
		return $form;
	}

	public function createNotFoundException($message = 'Not Found', \Exception $previous = null)
	{
		return new NotFoundHttpException($message, $previous);
	}

	public function redirectReferer()
	{
		return new RedirectResponse($this->request->headers->get('referer'));
	}
	
	public function redirect($route, $params, $status = 302)
	{
		$url = $this->getRouter()->generate($route, $params);
		return new RedirectResponse($url, $status);
	}
	
	public function renderJson($data = null, $status = 200, $headers = array())
	{
		return new JsonResponse($data, $status, $headers);
	}
	
	public function renderPdf($filename, $view, array $parameters = array())
	{
		$response = new Response();
		$response->headers->set('Content-Type', 'application/pdf');
		$response->headers->set('Content-Disposition', 'inline; filename='.$filename.'.pdf');
		$response->setContent($this->render($view , $parameters));
		
		return $response;
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
	
	public function getRouter()
	{
		return $this->router;
	}

	public function getSession()
    {
    	return $this->container->get('session');
    }
    
    public function disptach($eventName, Event $event = null)
    {
    	return $this->container->get('dispatcher')->dispatch($eventName, $event);
    }

	public function getHandler($form, $entity)
	{
		return new DoctrineHandler($form, $this->request, $this->om, $entity);
	}

	/**
	 * Pagination
	 */
	public function pagination($functionCount = 'getCountAll', $functionDatas = 'getAll', $route = null, $params = array())
	{
		$request = $this->getRequest();
		$page = $request->get('page', 1);
		$limit = $request->get('limit', 10);
		$params = ($limit != 10) ? array_merge($params, array('limit' => $limit)) : $params;
		$repo = $this->getRepository();
		if (!method_exists($repo,$functionCount))
		{
			throw $this->createNotFoundException('Page insexistante (La méthode '.get_class($repo).'#'.$functionCount.' n\'existe pas)');
		}
		if (!method_exists($repo,$functionDatas))
		{
			throw $this->createNotFoundException('Page insexistante (La méthode '.get_class($repo).'#'.$functionDatas.' n\'existe pas)');
		}
		$nb = $repo->$functionCount();
		$nbPages = ceil($nb/$limit);
		$nbPages = ($nbPages < 1) ? 1 : $nbPages;
		$offset = ($page-1) * $limit;
		if ($page < 1 || $page > $nbPages)
		{
			throw $this->createNotFoundException('Page insexistante (page '.$page.'/'.$nbPages.')');
		}
	
		return array(
				'entities' => $repo->$functionDatas($limit,$offset),
				'pagination' => array(
						'total' => $nbPages,
						'current' => $page,
						'limit' => $limit,
						'route' => $route,
						'params' => $params,
				)
		);
	}
}
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

use Doctrine\Common\Persistence\ObjectManager;
use JLM\CoreBundle\Form\Handler\DoctrineHandler;
use JLM\CoreBundle\Repository\SearchRepositoryInterface;
use FOS\UserBundle\Model\UserInterface;
use JLM\CoreBundle\Service\Pagination;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\Exception\LogicException;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;
use JLM\CoreBundle\Model\Repository\PaginableInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class BaseManager implements ContainerAwareInterface, ManagerInterface
{
    use ContainerAwareTrait;

    /**
     * @var string
     */
    protected $class;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var ObjectManager
     */
    protected $om;

    /**
     * @var RouterInterface
     */
    protected $router;

    public function getUser()
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        return $user;
    }

    public function getEntity($id = null)
    {
        if ($id === null) {
            return null;
        }

        return $this->getRepository()->find($id);
    }

    /**
     * @param string $name
     * @param array $options
     *
     * @return array
     */
    protected function getFormParam(string $name, array $options = []): array
    {
        return [];
    }

    protected function getFormType($type = null)
    {
        return 'form';
    }

    public function __construct($class)
    {
        $this->class = $class;
    }

    public function setServices(): void
    {
        $this->om = $this->container->get('doctrine')->getManager();
        $this->request = $this->container->get('request');
        $this->router = $this->container->get('router');
    }

    public function getRepository()
    {
        return $this->om->getRepository($this->class);
    }

    public function renderResponse($view, array $parameters = [], Response $response = null)
    {
        return $this->container->get('templating')->renderResponse($view, $parameters, $response);
    }

    protected function setterFromRequest($param, $repoName)
    {
        if ($id = $this->request->get($param)) {
            return $this->om->getRepository($repoName)->find($id);
        }

        return null;
    }

    public function createForm($name, Request $request, $options = [])
    {
        $param = $this->getFormParam($name, $options);
        if ($param !== null) {
            // TODO: Temporaire, mauvaise gestion des methodes en prod
            if ($param['method'] !== 'GET') {
                $param['method'] = 'POST';
            }
            $form = $this->getFormFactory()->create(
                $param['type'],
                $param['entity'],
                [
                    'action' => $this->router->generate($param['route'], $param['params']),
                    'method' => $param['method'],
                ]
            );
            $form->add('submit', SubmitType::class, ['label' => $param['label']]);

            return $this->populateForm($form, $request);
        }

        throw new LogicException('HTTP request method must be POST, PUT or DELETE only');
    }

    public function populateForm($form, Request $request)
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

    public function redirect($route, $params = [], $status = 302)
    {
        $url = $this->getRouter()->generate($route, $params);
        return new RedirectResponse($url, $status);
    }

    public function renderJson($data = null, $status = 200, $headers = [])
    {
        return new JsonResponse($data, $status, $headers);
    }

    public function renderPdf($filename, $view, array $parameters = [])
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'inline; filename=' . $filename . '.pdf');
        $response->setContent($this->renderResponse($view, $parameters));

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

    public function getMailer()
    {
        return $this->container->get('mailer');
    }

    public function getRouter()
    {
        return $this->router;
    }

    public function getSession()
    {
        return $this->container->get('session');
    }

    public function dispatch($eventName, Event $event = null)
    {
        return $this->container->get('event_dispatcher')->dispatch($eventName, $event);
    }

    public function getHandler($form, $entity = null)
    {
        return new DoctrineHandler($form, $this->request, $this->om, $entity);
    }

    /**
     * Pagination
     *
     * @param Request $request
     * @param string $functionCount
     * @param string $functionDatas
     * @param null $route
     * @param array $params
     *
     * @return array
     */
    public function pagination(Request $request, $functionCount = 'getCountAll', $functionDatas = 'getAll', $route = null, $params = []): array
    {
        $paginator = new Pagination($request, $this->getRepository());
        return $paginator->paginate($functionCount, $functionDatas, $route, $params);
    }

    public function paginator($entityClass, Request $request, array $defaultParams = [])
    {
        $repo = $this->getObjectManager()->getRepository($entityClass);
        if (!$repo instanceof PaginableInterface) {
            throw new \Exception(
                get_class($repo) . ' doesn\'t implement JLM\CoreBundle\Model\Repository\PaginableInterface interface.'
            );
        }
        $route_params = [];
        $db_params = array_merge(
            [
                'page' => 1,
                'resultsByPage' => 10,
            ],
            $defaultParams
        );
        foreach ($db_params as $param => $defaultValue) {
            $db_params[$param] = $request->get($param, $defaultValue);
            if ($db_params[$param] != $defaultValue) {
                $route_params[$param] = $db_params[$param];
            }
        }

        $entities = $repo->getPaginable($db_params['page'], $db_params['resultsByPage'], $db_params);

        return [
            'entities' => $entities,
            'pagination' => [
                'page' => $db_params['page'],
                'route' => $request->attributes->get('_route'),
                'pages_count' => ceil(count($entities) / $db_params['resultsByPage']),
                'route_params' => $route_params,
            ],
        ];
    }
}

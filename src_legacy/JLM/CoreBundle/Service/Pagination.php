<?php

namespace JLM\CoreBundle\Service;

use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Pagination
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var ObjectRepository
     */
    private $objectRepository;

    /**
     * @param Request $request
     * @param ObjectRepository $objectRepository
     */
    public function __construct(Request $request, ObjectRepository $objectRepository)
    {
        $this->request = $request;
        $this->objectRepository = $objectRepository;
    }
    
    /**
     * Pagination
     *
     * @param string $functionCount
     * @param string $functionDatas
     * @param null $route
     * @param array $params
     *
     * @return array
     */
    public function paginate($functionCount = 'getCountAll', $functionDatas = 'getAll', $route = null, $params = []): array
    {
        if (!method_exists($this->objectRepository, $functionCount)) {
            throw new NotFoundHttpException(
                'Page inexistante (La méthode ' . \get_class($this->objectRepository) . '::' . $functionCount . ' n\'existe pas)'
            );
        }
        if (!method_exists($this->objectRepository, $functionDatas)) {
            throw new NotFoundHttpException(
                'Page inexistante (La méthode ' . \get_class($this->objectRepository) . '::' . $functionDatas . ' n\'existe pas)'
            );
        }

        $page = $this->request->get('page', 1);
        $limit = (int) $this->request->get('limit', 10);
        $nb = $this->objectRepository->$functionCount();
        $nbPages = ceil($nb / $limit);
        $nbPages = ($nbPages < 1) ? 1 : $nbPages;
        $offset = ($page - 1) * $limit;
        if ($page < 1 || $page > $nbPages) {
            throw new NotFoundHttpException('Page inexistante (page ' . $page . '/' . $nbPages . ')');
        }

        $params = ($limit !== 10) ? array_merge($params, ['limit' => $limit]) : $params;

        return [
            'entities' => $this->objectRepository->$functionDatas($limit, $offset),
            'pagination' => [
                'total' => $nbPages,
                'current' => $page,
                'limit' => $limit,
                'route' => $route,
                'params' => $params,
            ],
        ];
    }
}

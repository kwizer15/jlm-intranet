<?php
namespace JLM\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JLM\DefaultBundle\Entity\PaginableRepository;

abstract class PaginableController extends Controller
{
	/**
	 * Pagination
	 */
	protected function pagination($repository, $functiondata = 'All', $page = 1, $limit = 10)
	{
		$em = $this->getDoctrine()->getEntityManager();
		$repo = $em->getRepository($repository);
		$functionCount = 'getCount'.$functiondata;
		$functionDatas = 'get'.$functiondata;
		if (!method_exists($repo,$functionCount))
			throw $this->createNotFoundException('Page insexistante (La méthode '.$repository.'#'.$functionCount.' n\'existe pas)');
		if (!method_exists($repo,$functionDatas))
			throw $this->createNotFoundException('Page insexistante (La méthode '.$repository.'#'.$functionDatas.' n\'existe pas)');
		$nb = $repo->$functionCount();
		$nbPages = ceil($nb/$limit);
		$nbPages = ($nbPages < 1) ? 1 : $nbPages;
		$offset = ($page-1) * $limit;
		if ($page < 1 || $page > $nbPages)
		{
			throw $this->createNotFoundException('Page insexistante (page '.$page.'/'.$nbPages.')');
		}
		return array('entities'=>$repo->$functionDatas($limit,$offset),'nbPages'=>$nbPages);
	}
}
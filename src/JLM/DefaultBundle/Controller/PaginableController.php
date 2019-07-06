<?php
namespace JLM\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

abstract class PaginableController extends Controller
{
	/**
	 * Pagination
	 */
	protected function pagination($repository, $functiondata = 'All', $page = 1, $limit = 10, $route = null)
	{
		$em = $this->getDoctrine()->getManager();
		$repo = $em->getRepository($repository);
		$functionCount = 'getCount'.$functiondata;
		$functionDatas = 'get'.$functiondata;
		if (!method_exists($repo,$functionCount))
			throw $this->createNotFoundException('Page insexistante (La méthode '.$repository.'Repository#'.$functionCount.' n\'existe pas)');
		if (!method_exists($repo,$functionDatas))
			throw $this->createNotFoundException('Page insexistante (La méthode '.$repository.'Repository#'.$functionDatas.' n\'existe pas)');
		$nb = $repo->$functionCount();
		$nbPages = ceil($nb/$limit);
		$nbPages = ($nbPages < 1) ? 1 : $nbPages;
		$offset = ($page-1) * $limit;
		if ($page < 1 || $page > $nbPages)
			throw $this->createNotFoundException('Page insexistante (page '.$page.'/'.$nbPages.')');
		//echo 'page = '.$page.'<br>nbPages = '.$nbPages.'<br>nbEntities = '.$limit.'<br>offset='.$offset.'<br>Fonction : '.$functionDatas; exit;
		return array('entities'=>$repo->$functionDatas($limit,$offset),'pageTotal'=>$nbPages,'page'=>$page,'pageRoute'=>$route);
	}
}
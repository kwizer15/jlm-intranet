<?php

namespace JLM\DefaultBundle\Entity;

use Doctrine\ORM\EntityRepository;
use JLM\DefaultBundle\Entity\Search;

class SearchRepository extends EntityRepository
{
	/**
	 * 
	 * @param Search $search
	 * @return array|null
	 */
	public function search(Search $search)
	{
		$keywords = $search->getKeywords();
		if (empty($keywords))
			return array();
		$qb = $this->getSearchQb();
		if ($qb === null)
			return null;
		$params = $this->getSearchParams();
	
		foreach ($keywords as $key=>$keyword)
		{
			foreach ($params as $param)
				$wheres[$param][] = $param . ' LIKE ?'.$key;
			$qb->setParameter($key,'%'.$keyword.'%');
		}
		foreach ($params as $param)
			$qb->orWhere(implode(' AND ',$wheres[$param]));
			
		return $qb->getQuery()->getResult();
	}
	
	/**
	 * @return QueryBuilder|null
	 */
	protected function getSearchQb()
	{
		return null;
	}
	
	/**
	 * @return array
	 */
	protected function getSearchParams()
	{
		return array();
	}
}
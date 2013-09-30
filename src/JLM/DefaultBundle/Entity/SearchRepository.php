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
	public function search($search)
	{
		if ($search instanceof Search)
			$keywords = $search->getKeywords();
		/* Rétro compatibilité */
		else
			$keywords = $search;
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
		$orderBys = $this->getSearchOrderBy();
		foreach ($orderBys as $champ=>$order)
		{
			/* Vérifier $order = 'asc' ou 'desc' */
			$qb->addOrderBy($champ,$order);
		}
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
	
	/**
	 * @return array
	 */
	protected function getSearchOrderBy()
	{
		return array();
	}
}
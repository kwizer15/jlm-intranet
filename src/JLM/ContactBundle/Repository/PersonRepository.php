<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ContactBundle\Repository;

use JLM\DefaultBundle\Entity\SearchRepository;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class PersonRepository extends SearchRepository
{
	/**
	 * {@inheritdoc}
	 */
	protected function getSearchQb()
	{
		return $this->createQueryBuilder('a');
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function getSearchParams()
	{
		return array('a.firstName','a.lastName');
	}
	
	/**
	 * @deprecated
	 * @param unknown $query
	 * @return Ambigous <multitype:, NULL, \Doctrine\ORM\mixed, \Doctrine\ORM\Internal\Hydration\mixed, \Doctrine\DBAL\Driver\Statement, \Doctrine\Common\Cache\mixed>
	 */
	public function match($query)
	{
		return $this->search($query);
	}
	
	/**
	 * @deprecated
	 * @param unknown $query
	 * @param number $limit
	 * @return multitype:multitype:string
	 */
	public function searchResult($query, $limit = 8)
	{
		$res = $this->search($query);
		$r2 = array();
		foreach ($res as $r)
		{
			$r2[] = array(
					'id'=>''.$r->getId(),
					'label'=>''.$r,
			);
		}
		return $r2;
	}
	
	/**
	 *
	 * @param string $query
	 * @param int $limit
	 * @return array
	 */
	public function getArray($query, $limit = 8)
	{
		$qb = $this->createQueryBuilder('c')
		->where('c.name LIKE :query')
		->setParameter('query', '%'.$query.'%')
		;
		$res = $qb->getQuery()->getArrayResult();
	
		return $res;
	}
	
	/**
	 *
	 * @param int $id
	 * @return array|null
	 */
	public function getByIdToArray($id)
	{
		$qb = $this->createQueryBuilder('c')
		->where('c.id = :id')
		->setParameter('id', $id)
		;
		$res = $qb->getQuery()->getArrayResult();
	
		if (isset($res[0]))
		{
			return $res[0];
		}
	
		return array();
	}
}
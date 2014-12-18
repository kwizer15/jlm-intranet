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

use Doctrine\ORM\EntityRepository;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class ContactRepository extends EntityRepository
{
	private function getQueryBuilder()
	{
		return $this->createQueryBuilder('a')
			->select('a,b,c')
			->leftJoin('a.phones','b')
			->leftJoin('b.phone','c')
		;
	}
	
	/**
	 *
	 * @param string $query
	 * @param int $limit
	 * @return array
	 */
	public function getArray($query, $limit = 8)
	{
		$qb = $this->getQueryBuilder()
			->where('a.name LIKE :query')
			->orderBy('a.name','ASC')
			->setParameter('query', '%'.$query.'%')
		;
		$res = $qb->getQuery()->getArrayResult();
	
		return $res;
	}
	
	public function getAll($limit = 8, $offset = 0)
	{
		$qb = $this->getQueryBuilder();
		$res = $qb->getQuery()->getResult();
		
		return $res;
	}

	/**
	 *
	 * @param int $id
	 * @return array|null
	 */
	public function getByIdToArray($id)
	{
		$qb = $this->getQueryBuilder()
			->where('a.id = :id')
			->setParameter('id', $id)
		;
		$res = $qb->getQuery()->getArrayResult();

		return $res[0];
	}
}
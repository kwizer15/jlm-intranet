<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\DBAL\LockMode;

/**
 * TrusteeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TrusteeRepository extends EntityRepository
{
	public function getList($limit,$offset)
	{
		$qb = $this->createQueryBuilder('a')
			->select('a,b,c')
			->leftJoin('a.address','b')
			->leftJoin('b.city','c')
			->orderBy('a.name','ASC')
			->setFirstResult($offset)
			->setMaxResults($limit);
		return $qb->getQuery()->getResult();
	}
	
	public function find($id, $lockMode = LockMode::NONE, $lockVersion = null)
	{
		$qb = $this->createQueryBuilder('a')
		->select('a,b,c,d,e,f,g')
		->leftJoin('a.address','b')
		->leftJoin('b.city','c')
		->leftJoin('a.sites','d')
		->leftJoin('d.address','e')
		->leftJoin('e.city','f')
		->leftJoin('d.doors','g')
		->where('a.id = ?1')
		->setParameter(1,$id);
		return $qb->getQuery()->getSingleResult();
	}
	
	public function search($query)
	{
		$qb = $this->createQueryBuilder('a')
			->where('a.name LIKE :query')
			->setParameter('query', '%'.$query.'%')
		;
		return $qb->getQuery()->getResult();
		
	}
	
	public function searchResult($query, $limit = 8)
	{

		$res = $this->search($query);
		$r2 = array();

		foreach ($res as $r)
		{
			$r2[] = array(
					'trustee'       => ''.$r->getId(),
					'label'         => ''.$r,
					'trusteeAddress'=> ''.$r->getAddress(),
					'accountNumber' => $r->getAccountNumber(),
			);
		}
		return $r2;
	}
	
	public function getTotal()
	{
		$qb = $this->createQueryBuilder('s')
		->select('COUNT(s)');
	
		return (int) $qb->getQuery()
		->getSingleScalarResult();
	}
}
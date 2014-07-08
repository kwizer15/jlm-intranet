<?php

namespace JLM\ModelBundle\Entity;

use JLM\DefaultBundle\Entity\SearchRepository;
use Doctrine\DBAL\LockMode;

/**
 * TrusteeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TrusteeRepository extends SearchRepository
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
		return array('a.name');
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
					'trusteeBillingLabel'   => ''.$r->getBillingLabel(),
					'trusteeBillingAddress'   => ''.$r->getAddressForBill()->toString(),
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
	
	public function getArray($query, $limit = 8)
	{
	    $qb = $this->createQueryBuilder('c')
	    ->where('c.name LIKE :query')
	    ->setParameter('query', '%'.$query.'%')
	    ;
	    $res = $qb->getQuery()->getArrayResult();
	
	    return $res;
	}
	
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
	
	    return null;
	}
}
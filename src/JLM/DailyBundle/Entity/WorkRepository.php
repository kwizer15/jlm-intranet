<?php

namespace JLM\DailyBundle\Entity;

/**
 * WorkRepository
 */
class WorkRepository extends InterventionRepository
{
	protected function leftJoins()
	{
		return parent::leftJoins();
			
	}
	
	public function getToday()
	{
		$today = new \DateTime;
		$todaystring =  $today->format('Y-m-d');
		// Interventions en cours
		$qb = $this->createQueryBuilder('a')
			->select('a,b,k,l,o,p,c,e,f,g,h,i,j,m,n,r')
			->leftJoin('a.shiftTechnicians','b')
			->leftJoin('a.askQuote','k')
			->leftJoin('a.work','l')
			->leftJoin('a.quote','o')
			->leftJoin('o.quote','r')
			->leftJoin('a.intervention','p')
			->leftJoin('a.door','c')
			//->leftJoin('c.interventions','d')
			->leftJoin('c.site','e')
			->leftJoin('e.address','f')
			->leftJoin('f.city','g')
			->leftJoin('e.bills','h')
			->leftJoin('c.stops','i')
			->leftJoin('c.contracts','j')
			->leftJoin('j.trustee','m')
			->leftJoin('c.type','n')
			//->leftJoin('d.shiftTechnicians','q')
			->where('b.begin = ?1')
//			->orWhere('b is null')
//			->orWhere('a.close is null')
//			->orWhere('a.report is null')
			->orWhere('a.mustBeBilled is null and b is not null')
			->orWhere('l is null and k is null and a.contactCustomer is null and a.rest is not null and b is not null')
			->orderBy('a.creation','asc')
			->setParameter(1,$todaystring)
			;
		return $qb->getQuery()->getResult();
	}
	
	public function getOrderTodo()
	{
		$qb = $this->createQueryBuilder('a')
			->select('a,b,c,d,e,g,h,i,j,k,l,m,n,o,p,q,r,s,z')
			->leftJoin('a.shiftTechnicians','b')
			->leftJoin('a.door','c')
			->leftJoin('c.site','d')
			->leftJoin('c.type','e')
			->leftJoin('c.contracts','g')
			->leftJoin('d.trustee','h')
			->leftJoin('d.address','i')
			->leftJoin('i.city','j')
			->leftJoin('a.askQuote','k')
			->leftJoin('a.work','l')
			->leftJoin('a.bill','m')
			->leftJoin('l.order','n')
			->leftJoin('a.quote','o')
			->leftJoin('a.order','p')
			->leftJoin('a.objective','q')
			->leftJoin('a.category','r')
			->leftJoin('a.intervention','s')
			->leftJoin('c.interventions','z')
			->where('a.order is null')
			->andWhere('a.close is null')
			->orderBy('a.creation','asc')
		;
		return $qb->getQuery()->getResult();
	}
	
	public function getCountOrderTodo()
	{
		$qb = $this->createQueryBuilder('a')
				->select('COUNT(a)')
				->where('a.order is null')
				->andWhere('a.close is null')
				->orderBy('a.creation','asc')
		;
		return $qb->getQuery()->getSingleScalarResult();
	}
	
	/**
	 *
	 * @param string $query
	 * @param int $limit
	 * @return array
	 * @todo Corrections for work entity
	 */
	public function getArray($query, $limit = 8)
	{
		$qb = $this->createQueryBuilder('a')
		    ->leftJoin('a.door','b')
		    ->leftJoin('b.site','c')
		    ->leftJoin('c.address','d')
		    ->leftJoin('d.city','e')
		    ->leftJoin('a.quote','f')
		    ->leftJoin('f.quote','g')
			->where('b.street LIKE :query')
			->where('c.street LIKE :query')
			->orWhere('e.name LIKE :query')
			->orWhere('g.number LIKE :query')
			->orWhere('a.reason LIKE :query')
			->orderBy('a.name','ASC')
			->setParameter('query', '%'.$query.'%')
		;
		$res = $qb->getQuery()->getArrayResult();
	
		return $res;
	}
	
	/**
	 *
	 * @param int $id
	 * @return array|null
	 * @todo Corrections for work entity
	 */
	public function getByIdToArray($id)
	{
		$qb = $this->createQueryBuilder('a')
		->where('a.id = :id')
		->setParameter('id', $id)
		;
		$res = $qb->getQuery()->getArrayResult();
	
		return $res[0];
	}
}

<?php

namespace JLM\DailyBundle\Entity;

/**
 * FixingRepository
 */
class FixingRepository extends InterventionRepository
{
	public function getToGive()
	{
		$today = new \DateTime;
		$todaystring =  $today->format('Y-m-d');
		// Interventions en cours
		$qb = $this->createQueryBuilder('a')
			->select('a,b,c,d,e,g,h,i,j,k,l,m')
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
			->where('b is null')
			->orderBy('a.creation','asc')
			;
		return $qb->getQuery()->getResult();
	}
	
	public function getToday()
	{
		$today = new \DateTime;
		$todaystring =  $today->format('Y-m-d');
		// Interventions en cours
		$qb = $this->createQueryBuilder('a')
		->select('a,b,c,d,e,g,h,i,j,k,l,m,n,o,p,q,z')
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
		->leftJoin('l.quote','q')
		->leftJoin('a.done','o')
		->leftJoin('a.due','p')
		->leftJoin('c.interventions','z')
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
}

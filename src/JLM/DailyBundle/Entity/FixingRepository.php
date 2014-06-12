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
			->select('a,b,c,d,e,g,h,i,j,w,x,z')
			->leftJoin('a.shiftTechnicians','b')
			->leftJoin('a.door','c')
			->leftJoin('c.site','d')
			->leftJoin('c.type','e')
			->leftJoin('c.contracts','g')
			->leftJoin('d.trustee','h')
			->leftJoin('d.address','i')
			->leftJoin('i.city','j')
			->leftJoin('c.interventions','z')
			->leftJoin('c.stops','w')
			->leftJoin('d.bills','x')
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
    		->select('a,b,c,d,e,g,h,i,j,k,l,n,q,w,x,z')
    		->leftJoin('a.shiftTechnicians','b')
    		->leftJoin('a.askQuote','k')
    		->leftJoin('a.work','l')
    		->leftJoin('l.order','n')
    		->leftJoin('l.quote','q')
    		->leftJoin('c.interventions','z')
    		->leftJoin('c.stops','w')
    		->leftJoin('d.bills','x')
    		->where('b.begin = ?1')
    		->orWhere('a.mustBeBilled is null and b is not null')
    		->orWhere('l is null and k is null and a.contactCustomer is null and a.rest is not null and b is not null')
    		->orderBy('a.creation','asc')
    		->setParameter(1,$todaystring)
		;
		return $qb->getQuery()->getResult();
	}
}

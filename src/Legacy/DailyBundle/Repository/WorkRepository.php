<?php

/*
 * This file is part of the JLMDailyBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\DailyBundle\Repository;

/**
 * WorkRepository
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
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
}

<?php

/*
 * This file is part of the JLMCommerceBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CommerceBundle\Repository;

use Doctrine\ORM\EntityRepository;
use JLM\CommerceBundle\Model\BillInterface;
use JLM\CommerceBundle\Model\BillBoostInterface;

/**
 * BillBoostRepository
 * 
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class BillBoostRepository extends EntityRepository
{
	/**
	 * Get bill boosts by a bill
	 * @param BillInterface $bill
	 * @param string $inversed
	 * @param string $maxResult
	 * @return array
	 */
	public function getBoostsByBill(BillInterface $bill, $inversed = true, $maxResult = null)
	{
		return $this->_getBoostsByBillQuery($bill, $inversed, $maxResult)->getResult();
	}
	
	/**
	 * Get the last bill boost for bill
	 * @param BillInterface $bill
	 * @return BillBoostInterface
	 */
	public function getLastBoostsByBill(BillInterface $bill)
	{
		return $this->_getBoostsByBillQuery($bill, true, 1)->getSingleResult();
	}
	
	/**
	 * Count the number a bill boost for a bill
	 * @param BillInterface $bill
	 * @return int
	 */
	public function getCountBoostsByBill(BillInterface $bill)
	{
		$qb = $this->createQueryBuilder('a')
		->select('COUNT(a)')
		->where('a.bill = ?1')
		->setParameter(1, $bill)
		;
			
		return $qb->getQuery()->getSingleScalarResult();
	}
	
	/**
	 * Get the query for bill boosts by a bill
	 * @param BillInterface $bill
	 * @param string $inversed
	 * @param string $maxResult
	 * @return \Doctrine\ORM\Query
	 */
	protected function _getBoostsByBillQuery(BillInterface $bill, $inversed = true, $maxResult = null)
	{
		$qb = $this->createQueryBuilder('a')
			->select('a,b')
				->leftJoin('a.method','b')
			->where('a.bill = ?1')
			->orderBy('a.date', $inversed ? 'DESC' : 'ASC')
			->setMaxResults($maxResult)
			->setParameter(1, $bill)
		;
			
		return $qb->getQuery();
	}
}
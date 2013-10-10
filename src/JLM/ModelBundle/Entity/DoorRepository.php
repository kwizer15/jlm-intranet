<?php

namespace JLM\ModelBundle\Entity;

use JLM\DefaultBundle\Entity\SearchRepository;

/**
 * SiteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DoorRepository extends SearchRepository
{
	
	public function getStopped($limit = null, $offset = null)
	{
		$qb = $this->createQueryBuilder('a')
			->select('a,b,c,d,e,f,g,h,i,j')
			->leftJoin('a.site','b')
			->leftJoin('b.address','c')
			->leftJoin('c.city','d')
			->leftJoin('a.interventions','e')
			->leftJoin('e.shiftTechnicians','f')
			->leftJoin('a.contracts','g')
			->leftJoin('g.trustee','h')
			->leftJoin('a.type','i')
			->leftJoin('a.stops','j')
			->where('j.end is null AND j.begin is not null')
			->orWhere('a.stopped = 1');
		if ($limit !== null)
			$qb->setMaxResults($limit);
		if ($offset !== null)
			$qb->setFirstResult($offset);
		return $qb->getQuery()->getResult();
	}
	
	public function getCountStopped()
	{
		$qb = $this->createQueryBuilder('a')
			->select('COUNT(a)')
			->leftJoin('a.stops','j')
			->where('j.end is null AND j.begin is not null')
			->orWhere('a.stopped = 1');
		return $qb->getQuery()->getSingleScalarResult();
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function getSearchQb()
	{
		return $this->createQueryBuilder('a')
		->leftJoin('a.site','b')
		->leftJoin('b.address','c')
		->leftJoin('c.city','d');
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function getSearchParams()
	{
		return array('c.street','a.street','d.name');
	}
	
	public function searchResult($query, $limit = 8)
	{
		
		$res = $this->search($query);
		
		// Structure
		// array(IdPorte,Affaire,IdSyndic,Syndic,Adresse de facturation)
		$r2 = array();
		foreach ($res as $r)
		{
			$trustee = $r->getSite()->getTrustee();
			$reference = '';
			if ($r->getSite()->getGroupNumber())
				$reference .= 'Groupe : '.$r->getSite()->getGroupNumber();
			$r2[] = array(
						'door'          => ''.$r->getId(),
						'label'        => ''.$r,
						'doorCp'		=> ''.$r->toString(),
						'vat'			=> $r->getSite()->getVat()->getRate(),
						'trustee'       => ''.$trustee->getId(),
						'trusteeName'   => ''.$trustee,
						'trusteeAddress'=> ''.$trustee->getAddress()->toString(),
						'trusteeBillingAddress'=> ''.$trustee->getAddressForBill()->toString(),
						'accountNumber'=> $trustee->getAccountNumber(),
						'doorDetails' => $r->getType().' - '.$r->getLocation(),
						'siteCp'=> $r->getSite()->toString(),
						'prelabel'=> $r->getBillingPrelabel(),
						'reference'=>$reference,
					);
		}
		return $r2;
	}
	
	public function getTotal()
	{
		$qb = $this->createQueryBuilder('d')
		->select('COUNT(d)');
		return $qb->getQuery()->getSingleScalarResult();
	}
}
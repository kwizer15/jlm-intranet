<?php

namespace JLM\ModelBundle\Repository;

use JLM\DefaultBundle\Entity\SearchRepository;
use Doctrine\DBAL\LockMode;

/**
 * SiteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SiteRepository extends SearchRepository
{
	public function find($id, $lockMode = LockMode::NONE, $lockVersion = null)
	{
		$qb = $this->createQueryBuilder('a')
		->select('a,b,c,d,e,f,g,h,i,j,k')
		->leftJoin('a.address','b')
		->leftJoin('b.city','c')
		->leftJoin('c.country','j')
		->leftJoin('a.doors','d')
		->leftJoin('d.type','k')
		->leftJoin('d.interventions','e')
		->leftJoin('e.shiftTechnicians','f')
		->leftJoin('d.contracts','g')
		->leftJoin('a.contacts','h')
		->leftJoin('h.person','i')
		->where('a.id = ?1')
		->setParameter(1,$id);
		return $qb->getQuery()->getSingleResult();
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function getSearchQb()
	{
		return $this->createQueryBuilder('a')
			->select('a,b,c,d')
			->leftJoin('a.address','b')
			->leftJoin('b.city','c')
			->leftJoin('a.trustee','d')
			->leftJoin('d.contact','e');
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function getSearchParams()
	{
		return array('b.street','c.name','e.name');
	}
	
	public function searchResult($query, $limit = 8)
	{
		$res = $this->search($query);
		
		$r2 = array();
		foreach ($res as $r)
		{
			$reference = '';
			if ($r->getGroupNumber())
			{
				$reference .= 'Groupe : '.$r->getGroupNumber();
			}
			foreach ($r->getDoors() as $d)
			{
				$doorDetails = $d->getType().' - '.$d->getLocation().chr(10);
			}
			$r2[] = array(
					'id'=>''.$r->getId(),
					'label'=>''.$r,
					'siteCp'=>''.$r->toString(),
					'trustee'=>''.$r->getTrustee()->getId(),
					'trusteeName'=>''.$r->getTrustee()->getName(),
					'trusteeBillingLabel'   => ''.$r->getTrustee()->getBillingLabel(),
					'trusteeAddress'=>''.$r->getTrustee()->getAddress()->toString(),
					'trusteeBillingAddress'=>''.$r->getTrustee()->getAddressForBill()->toString(),
					'accountNumber'=>$r->getTrustee()->getAccountNumber(),
					'prelabel'=>$r->getBillingPrelabel(),
					'vat'=>$r->getVat()->getRate(),
					'vatid'=>$r->getVat()->getId(),
					'doorDetails'=>$doorDetails,
					'reference'=>$reference,
				);
		}
		
		return $r2;
	}
	
	public function match($string)
	{
		if (preg_match('#^([\w\-\/",.\'âêîôûéèçà\s]+)\s([0-9AB]{5}( CEDEX)?) - (.+)$#',$string,$matches))
		{
			$qb = $this->createQueryBuilder('s')
				->leftJoin('s.address','a')
				->leftJoin('a.city','c')
				->where('a.street LIKE :querystreet')
				->andwhere('c.zip = :queryzip')
				->andWhere('c.name = :querycity')
				->setParameter('querystreet', trim($matches[1]).'%')
				->setParameter('queryzip', $matches[2])
				->setParameter('querycity', $matches[4])
				;
				
			$res = $qb->getQuery()->getResult();
			
			if ($res)
				return $res[0];
		}
		else
		{
			return null;
		}
			
	}
}
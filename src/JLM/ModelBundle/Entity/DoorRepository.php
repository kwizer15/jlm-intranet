<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * SiteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DoorRepository extends EntityRepository
{
	public function searchResult($query, $limit = 8)
	{
		
		$qb = $this->createQueryBuilder('d')
			   ->leftJoin('d.site','s')
			   ->leftJoin('s.address','a')
			   ->leftJoin('a.city','c')
			   ->where('a.street LIKE :querystreet')
			   ->orWhere('d.street LIKE :querystreet')
			   ->orWhere('c.name LIKE :querycity')
			   ->setParameter('querystreet', '%'.$query.'%')
			   ->setParameter('querycity', $query.'%')
		;

		$res = $qb->getQuery()->getResult();
		
		// Structure
		// array(IdPorte,Affaire,IdSyndic,Syndic,Adresse de facturation)
		$r2 = array();
		foreach ($res as $r)
		{
			$r2[] = array(
						'door'          => ''.$r->getId(),
						'label'        => ''.$r,
						'trustee'       => ''.$r->getSite()->getTrustee()->getId(),
						'trusteeName'   => ''.$r->getSite()->getTrustee(),
						'trusteeAddress'=> ($r->getSite()->getTrustee()->getBillingAddress() === null) ? ''.$r->getSite()->getTrustee()->getAddress() : ''.$r->getSite()->getTrustee()->getBillingAddress(),
					);
		}
		return $r2;
	}
}
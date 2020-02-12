<?php

namespace JLM\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;
use JLM\ContactBundle\Model\ContactInterface;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository
{
    public function getByContact(ContactInterface $contact)
    {
        $qb = $this->createQueryBuilder('a')
            ->select('a,b')
            ->leftJoin('a.contact', 'b')
            ->where('b = ?1')
            ->setParameter(1, $contact)
        ;
        
        return $qb->getQuery()->getSingleResult();
    }
}
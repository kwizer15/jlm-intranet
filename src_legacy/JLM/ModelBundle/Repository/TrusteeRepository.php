<?php

namespace JLM\ModelBundle\Repository;

use JLM\DefaultBundle\Entity\SearchRepository;
use Doctrine\DBAL\LockMode;
use JLM\UserBundle\Entity\User;
use Doctrine\ORM\NoResultException;
use JLM\UserBundle\Repository\UserRepositoryInterface;

/**
 * TrusteeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TrusteeRepository extends SearchRepository implements UserRepositoryInterface
{
    public function getList($limit, $offset)
    {
        $qb = $this->createQueryBuilder('a')
            ->select('a,b,c,d')
            ->leftJoin('a.contact', 'b')
            ->leftJoin('b.address', 'c')
            ->leftJoin('c.city', 'd')
            ->orderBy('b.name', 'ASC')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
        ;
        return $qb->getQuery()->getResult();
    }

    public function find($id, $lockMode = LockMode::NONE, $lockVersion = null)
    {
        $qb = $this->createQueryBuilder('z')
            ->select('z,a,b,c,d,e,f,g')
            ->leftJoin('z.contact', 'a')
            ->leftJoin('a.address', 'b')
            ->leftJoin('b.city', 'c')
            ->leftJoin('z.sites', 'd')
            ->leftJoin('d.address', 'e')
            ->leftJoin('e.city', 'f')
            ->leftJoin('d.doors', 'g')
            ->where('z.id = ?1')
            ->setParameter(1, $id)
        ;
        return $qb->getQuery()->getSingleResult();
    }

    /**
     * {@inheritdoc}
     */
    protected function getSearchQb()
    {
        return $this->createQueryBuilder('a')
            ->select('a,b,c,d,e,f,g,h,i')
            ->leftJoin('a.contact', 'b')
            ->leftJoin('b.phones', 'c')
            ->leftJoin('c.phone', 'd')
            ->leftJoin('b.address', 'h')
            ->leftJoin('h.city', 'i')
            ->leftJoin('a.sites', 'e')
            ->leftJoin('e.address', 'f')
            ->leftJoin('f.city', 'g')
            ;
    }

    /**
     * {@inheritdoc}
     */
    protected function getSearchParams()
    {
        return ['b.name'];
    }

    public function searchResult($query, $limit = 8)
    {

        $res = $this->search($query);
        $r2 = [];

        foreach ($res as $r) {
            $r2[] = [
                'trustee' => '' . $r->getId(),
                'label' => '' . $r,
                'trusteeBillingLabel' => '' . $r->getBillLabel(),
                'trusteeBillingAddress' => '' . $r->getBillAddress()->toString(),
                'trusteeAddress' => '' . $r->getAddress(),
                'accountNumber' => $r->getAccountNumber(),
            ];
        }
        return $r2;
    }

    public function getTotal()
    {
        $qb = $this->createQueryBuilder('s')
            ->select('COUNT(s)')
        ;

        return (int) $qb->getQuery()
            ->getSingleScalarResult()
            ;
    }

    public function getArray($query, $limit = 8)
    {
        $qb = $this->createQueryBuilder('a')
            ->select('a,b')
            ->leftJoin('a.contact', 'b')
            ->where('b.name LIKE :query')
            ->setParameter('query', '%' . $query . '%')
        ;
        $res = $qb->getQuery()->getArrayResult();

        return $res;
    }

    public function getByIdToArray($id)
    {
        $qb = $this->createQueryBuilder('a')
            ->select('a,b')
            ->leftJoin('a.contact', 'b')
            ->where('a.id = :id')
            ->setParameter('id', $id)
        ;
        $res = $qb->getQuery()->getArrayResult();

        if (isset($res[0])) {
            return $res[0];
        }

        return ['error' => 'Not found for id ' . $id];
    }

    public function getByUser(User $user)
    {
        if (($contact = $user->getContact()) === null) {
            throw new NoResultException('Pas de contact lié à l\'utilisateur');
        }

        $qb = $this->createQueryBuilder('a')
            ->select('a,b')
            ->leftJoin('a.contact', 'b')
            ->where('b = ?1')
            ->setParameter(1, $contact)
        ;

        return $qb->getQuery()->getSingleResult();
    }
}
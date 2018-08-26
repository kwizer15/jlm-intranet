<?php

namespace JLM\OfficeBundle\Repository;

use JLM\DefaultBundle\Entity\SearchRepository;

/**
 * TaskRepository
 */
class OrderRepository extends SearchRepository
{
    public function getTotal()
    {
        return $this->getCount();
    }
    
    public function getCount($state = null)
    {
        if (!isset($this->count)) {
            $qb = $this->createQueryBuilder('a')
                    ->select('a.state, COUNT(a) as c')
                    ->orderBy('a.state', 'ASC')
                    ->groupBy('a.state')
            ;
            $results = $qb->getQuery()->getResult();
            $this->count = [0,0,0];
            $this->total = 0;
            foreach ($results as $result) {
                $this->total += $result['c'];
                $this->count[$result['state']] = $result['c'];
            }
        }
        if ($state === null) {
            return $this->total;
        }
        return $this->count[$state];
    }
    
    public function getByState($state = null, $limit = 10, $offset = 0)
    {
        $qb = $this->createQueryBuilder('t');
        if ($state !== null) {
            $qb->where('t.state = ?1')
            ->setParameter(1, $state)
            ;
        }
        $qb->orderBy('t.creation', 'asc')
            ->setFirstResult($offset)
            ->setMaxResults($limit);
        return $qb->getQuery()->getResult();
    }
    
    /**
     * {@inheritdoc}
     */
    protected function getSearchQb()
    {
        return $this->createQueryBuilder('a')
        ->select('a')
        ->leftJoin('a.work', 'c')
        ->leftJoin('c.door', 'd')
        ->leftJoin('d.site', 'e')
        ->leftJoin('e.address', 'f')
        ->leftJoin('f.city', 'g')
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    protected function getSearchParams()
    {
        return ['d.street','f.street','g.name'];
    }
}

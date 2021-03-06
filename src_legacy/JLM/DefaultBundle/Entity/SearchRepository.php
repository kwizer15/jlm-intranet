<?php

namespace JLM\DefaultBundle\Entity;

use Doctrine\ORM\EntityRepository;
use JLM\CoreBundle\Entity\Search;
use JLM\CoreBundle\Repository\SearchRepositoryInterface;

class SearchRepository extends EntityRepository implements SearchRepositoryInterface
{
    /**
     *
     * @param Search $search
     * @return array|null
     */
    public function search($search)
    {
        if (!$search instanceof Search) {
            $s = new Search;
            $s->setQuery($search);
            $keywords = $s->getKeywords();
        }
        
        if (empty($keywords)) {
            return [];
        }
        $qb = $this->getSearchQb();
        if ($qb === null) {
            return null;
        }
        $params = $this->getSearchParams();
        $wheres = [];
        foreach ($keywords as $key => $keyword) {
            foreach ($params as $param) {
                $wheres[$param][] = $param . ' LIKE ?'.$key;
            }
            $qb->setParameter($key, '%'.$keyword.'%');
            //$qb->orWhere($param . ' LIKE ?'.$key);
        }
        
        foreach ($params as $param) {
            $qb->orWhere(implode(' OR ', $wheres[$param]));
        }
        
        $orderBys = $this->getSearchOrderBy();
        foreach ($orderBys as $champ => $order) {
            /* Vérifier $order = 'asc' ou 'desc' */
            $qb->addOrderBy($champ, $order);
        }
        
        return $qb->getQuery()->getResult();
    }
    
    /**
     * @return QueryBuilder|null
     */
    protected function getSearchQb()
    {
        return null;
    }
    
    /**
     * @return array
     */
    protected function getSearchParams()
    {
        return [];
    }
    
    /**
     * @return array
     */
    protected function getSearchOrderBy()
    {
        return [];
    }
}

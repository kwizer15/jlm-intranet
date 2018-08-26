<?php

/*
 * This file is part of the JLMCoreBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CoreBundle\Entity;

use JLM\CoreBundle\Model\SearchInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class Search implements SearchInterface
{
    /**
     * Requete de recherche
     * @var string
     */
    private $query = '';
    
    /**
     * Get requete de recherche
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }
    
    /**
     *
     * @param string $query
     * @return self
     */
    public function setQuery($query)
    {
        $this->query = (string)$query;
        
        return $this;
    }
    
    /**
     * Retourne un tableau de mots clés d'après la requète
     * @return array
     */
    public function getKeywords()
    {
        $words = str_replace([' ',',','.','\'','"','-'], '+', $this->getQuery());
        $words = stripslashes(trim($words));
        $words = explode('+', $words);
        
        $nosearchs = ['de','du','le','la','des','rue','av','avenue','bd','boulevard','place','pl'];
        foreach ($words as $key => $word) {
            $word = strtolower($word);
            if (strlen($word) < 2 || in_array($word, $nosearchs)) {
                unset($words[$key]);
            }
        }
        
        return $words;
    }
    
    /**
     * Retourne la requète
     * @return string
     */
    public function __toString()
    {
        return $this->getQuery();
    }
}

<?php
namespace JLM\DefaultBundle\Entity;

class Search
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
	 * @return \JLM\DefaultBundle\Entity\Search
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
		$words = str_replace(array(' ',',','.','\'','"'),'+',$this->getQuery());
		$words = stripslashes(trim($words));
		$words = explode('+',$words);
		
		$nosearchs = array('de','du','le','la','des','rue','av','avenue','bd','boulevard','place','pl');
		foreach ($words as $key => $word)
		{
			$word = strtolower($word);
			if (strlen($word) < 2 || in_array($word,$nosearchs))
				unset($words[$key]);
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
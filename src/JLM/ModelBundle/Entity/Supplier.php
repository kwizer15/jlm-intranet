<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JLM\ModelBundle\Entity\Company
 *
 * @ORM\Table(name="suppliers")
 * @ORM\Entity
 */
class Supplier extends Company
{
	/**
	 * @var string $website
	 * 
	 * @ORM\Column(name="website",type="string",length=255, nullable=true)
	 */
	private $website;

	
	/**
	 * Get website
	 * @return string
	 */
	public function getWebsite()
	{
		return $this->website;
	}
	
	/**
	 * Set website
	 * @param string $url
	 */
	public function setWebsite($url)
	{
		$this->website = $url;
	}

}
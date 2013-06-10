<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * JLM\ModelBundle\Entity\Supplier
 *
 * @ORM\Table(name="suppliers")
 * @ORM\Entity(repositoryClass="JLM\ModelBundle\Entity\SupplierRepository")
 */
class Supplier extends Company
{
	/**
	 * @var string $website
	 * 
	 * @ORM\Column(name="website",type="string",length=255, nullable=true)
	 * @Assert\Url
	 */
	private $website;
	
	/**
	 * @var string $shortName
	 *
	 * ORM\Column(name="short_name",type="string",length=255)
	 */
//	private $shortName;
	
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

	/**
	 * Get shortName
	 * @return string
	 */
	public function getShortName()
	{
		return $this->getName();
//		return $this->shortName;
	}
	
	/**
	 * Set shortName
	 * @param string $name
	 */
	public function setShortName($name)
	{
//		$this->shortName = $name;
		return $this;
	}
}
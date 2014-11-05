<?php

/*
 * This file is part of the JLMProductBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ProductBundle\Entity;

use JLM\ContactBundle\Entity\Company;
use JLM\ProductBundle\Model\SupplierInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class Supplier extends Company implements SupplierInterface
{
	/**
	 * @var string $website
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
	 * @return self
	 */
	public function setWebsite($url)
	{
		$this->website = $url;
		
		return $this;
	}

	/**
	 * Get shortName
	 * @deprecated
	 * @return string
	 */
	public function getShortName()
	{
		return $this->getName();
	}
	
	/**
	 * Set shortName
	 * @deprecated
	 * @param string $name
	 */
	public function setShortName($name)
	{
		return $this;
	}
}
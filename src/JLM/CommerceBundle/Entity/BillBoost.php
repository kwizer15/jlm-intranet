<?php

/*
 * This file is part of the JLMCommerceBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CommerceBundle\Entity;

use JLM\CommerceBundle\Model\BillBoostInterface;
use JLM\CommerceBundle\Model\BillInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class BillBoost extends BoostAbstract implements BillBoostInterface
{
	/**
	 * @var int
	 */
	private $id;
	
	/**
	 * @var BillInterface
	 */
	private $bill;
	
	/**
	 * Get the id
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}
	
	/**
	 * Set the bill
	 * @param BillInterface $bill
	 * @return self
	 */
	public function setBill(BillInterface $bill)
	{
		$this->bill = $bill;
		
		return $this;
	}
	
	/**
	 * Get the bill
	 * @return BillInterface
	 */
	public function getBill()
	{
		return $this->bill;
	}
}
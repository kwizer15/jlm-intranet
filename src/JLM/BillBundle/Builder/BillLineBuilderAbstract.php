<?php

/*
 * This file is part of the BillBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\BillBundle\Builder;

use JLM\OfficeBundle\Entity\BillLine;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
abstract class BillLineBuilderAbstract implements BillLineBuilderInterface
{
	/**
	 * 
	 * @var BillLineInterface $line
	 */
	private $line;
	
	/**
	 * {@inheritdoc}
	 */
	public function create()
	{
		$this->line = new BillLine;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function buildQuantity()
	{
		$this->line->setQuantity(1);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function buildPrice()
	{
		$this->line->setUnitPrice(0);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getLine()
	{
		return $this->line;
	}
}
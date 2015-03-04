<?php

/*
 * This file is part of the JLMOfficeBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\OfficeBundle\Builder;

use JLM\OfficeBundle\Entity\OrderLine;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
abstract class OrderLineBuilderAbstract implements OrderLineBuilderInterface
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
		$this->line = new OrderLine();
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
	public function buildReference()
	{
		$this->line->setReference('');
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getLine()
	{
		return $this->line;
	}
}
<?php

/*
 * This file is part of the JLMContractBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ContractBundle\Model;

use JLM\ModelBundle\Entity\Trustee;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
interface ContractInterface
{
	/**
	 * Get number
	 *
	 * @return string
	 */
	public function getNumber();
	
	/**
	 * Get door
	 *
	 * @return JLM\ModelBundle\Entity\Door
	 */
	public function getDoor();
	
	/**
	 * Get fee
	 *
	 * @return float
	 */
	public function getFee();
	
	/**
	 * Get trustee
	 * 
	 * @return Trustee
	 */
	public function getTrustee();
	
	/**
	 * To String
	 * @return string
	 */
	public function __toString();
}
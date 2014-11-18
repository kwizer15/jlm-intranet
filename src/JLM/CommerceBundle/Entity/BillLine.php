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

use JLM\CommerceBundle\Model\BillLineInterface;
use JLM\CommerceBundle\Entity\CommercialPartLineProduct;
use JLM\CommerceBundle\Model\BillInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class BillLine extends CommercialPartLineProduct implements BillLineInterface
{
	/**
	 * @var integer $id
	 */
	private $id;
	
	/**
	 * @var BillInterface $bill
	 */
	private $bill;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set bill
     *
     * @param BillInterface $bill
     * @return self
     */
    public function setBill(BillInterface $bill = null)
    {
        $this->bill = $bill;
    
        return $this;
    }

    /**
     * Get bill
     *
     * @return BillInterface
     */
    public function getBill()
    {
        return $this->bill;
    }
}
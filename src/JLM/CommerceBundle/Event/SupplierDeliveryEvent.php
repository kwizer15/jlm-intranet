<?php

/*
 * This file is part of the JLMCommerceBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CommerceBundle\Event;

use Symfony\Component\HttpFoundation\Request;
use JLM\CommerceBundle\Model\BillInterface;
use JLM\CoreBundle\Event\RequestEvent;

class SupplierDeliveryEvent extends RequestEvent
{
	/**
	 * @var BillInterface
	 */
    private $supplierDelivery;

    /**
     * @param FormInterface $form
     * @param Request $request
     */
    public function __construct(SupplierDeliveryInterface $supplierDelivery, Request $request)
    {
    	$this->supplierDelivery = $supplierDelivery;
    	parent::__construct($request);
    }
    
    public function getSupplierDelivery()
    {
    	return $this->supplierDelivery;
    }
}
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

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;
use JLM\CommerceBundle\Model\BillInterface;

class BillEvent extends Event
{
	/**
	 * @var BillInterface
	 */
    private $bill;
    
    /**
     * @var Request
     */
    private $request;

    /**
     * @param FormInterface $form
     * @param Request $request
     */
    public function __construct(BillInterface $bill, Request $request)
    {
    	$this->bill = $bill;
    	$this->request = $request;
    }
    
    public function getBill()
    {
    	return $this->bill;
    }
    
    /**
     * @return string
     */
    public function getParam($param, $deep = false)
    {
    	return $this->request->get($param, null, $deep);
    }
}
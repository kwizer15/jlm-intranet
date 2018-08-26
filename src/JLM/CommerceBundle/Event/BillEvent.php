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

class BillEvent extends RequestEvent
{
    /**
     * @var BillInterface
     */
    private $bill;

    /**
     * @param FormInterface $form
     * @param Request $request
     */
    public function __construct(BillInterface $bill, Request $request)
    {
        $this->bill = $bill;
        parent::__construct($request);
    }
    
    public function getBill()
    {
        return $this->bill;
    }
}

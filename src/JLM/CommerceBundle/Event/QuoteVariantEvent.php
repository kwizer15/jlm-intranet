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
use JLM\CommerceBundle\Model\QuoteInterface;
use JLM\CoreBundle\Event\RequestEvent;
use JLM\CommerceBundle\Model\QuoteVariantInterface;

class QuoteVariantEvent extends RequestEvent
{
	/**
	 * @var QuoteVariantInterface
	 */
    private $quote;

    /**
     * @param FormInterface $form
     * @param Request $request
     */
    public function __construct(QuoteVariantInterface $quote, Request $request)
    {
    	$this->quote = $quote;
    	parent::__construct($request);
    }
    
    public function getQuoteVariant()
    {
    	return $this->quote;
    }
}

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

use JLM\CommerceBundle\Model\AskPriceInterface;
use JLM\CommerceBundle\Model\AskPriceLineInterface;
use JLM\CoreBundle\Model\UploadDocumentInterface;
use JLM\CommerceBundle\Model\SupplierInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class AskPrice extends DocumentAbstract implements AskPriceInterface
{
	/**
	 * 
	 * @var SupplierInterface
	 */
	private $supplier;

}
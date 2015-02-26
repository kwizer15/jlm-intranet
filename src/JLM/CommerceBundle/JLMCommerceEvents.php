<?php

/*
 * This file is part of the JLMCommerceBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CommerceBundle;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
final class JLMCommerceEvents
{
	const QUOTE_PREPERSIST = "jlm_commerce.quote_prepersist";
	const QUOTE_PREUPDATE = "jlm_commerce.quote_preupdate";
	const QUOTE_FORM_POPULATE = "jlm_commerce.quote_form_populate";
	const QUOTE_AFTER_PERSIST = "jlm_commerce.quote_after_persist";
	
	const QUOTEVARIANT_FORM_POPULATE = "jlm_commerce.quotevariant_form_populate";
	const QUOTEVARIANT_PREPERSIST = "jlm_commerce.quotevariant_prepersist";
	const QUOTEVARIANT_GIVEN = "jlm_commerce.quotevariant_given";
	
	const BILL_FORM_POPULATE = "jlm_commerce.bill_form_populate";
	const BILL_AFTER_PERSIST = "jlm_commerce.bill_after_persist";
}
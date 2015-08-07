<?php

/*
 * This file is part of the JLMCommerceBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CoreBundle;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
final class JLMCoreEvents
{
	const EMAIL_PRE_SET_DATA = 'jlm_core.email_pre_set_data';
	const EMAIL_PRESEND = 'jlm_core.email_presend';
	const EMAIL_POSTSEND = 'jlm_core.email_postsend';
}
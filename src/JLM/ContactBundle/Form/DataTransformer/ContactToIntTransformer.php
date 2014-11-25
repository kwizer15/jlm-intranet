<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ContactBundle\Form\DataTransformer;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class ContactToIntTransformer extends ObjectToIntTransformer
{
    /**
     * {@inheritdoc}
     */
	protected function _getClass()
	{
		return 'JLMContactBundle:Contact';
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function _getErrorMessage()
	{
		return 'A contact with id "%s" does not exist!';
	}
}
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

use JLM\ContactBundle\Form\DataTransformer\ObjectToIntTransformer;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class PersonToIntTransformer extends ObjectToIntTransformer
{
    /**
     * {@inheritdoc}
     */
	public function _getClass()
	{
		return 'JLMContactBundle:Person';
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function _getErrorMessage()
	{
		return 'A person with id "%s" does not exist!';
	}
}
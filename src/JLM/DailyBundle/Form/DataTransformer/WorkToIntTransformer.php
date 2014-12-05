<?php

/*
 * This file is part of the JLMDailyBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\DailyBundle\Form\DataTransformer;

use JLM\CoreBundle\Form\DataTransformer\ObjectToIntTransformer;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class WorkToIntTransformer extends ObjectToIntTransformer
{
    /**
     * {@inheritdoc}
     */
	protected function _getClass()
	{
		return 'JLMDailyBundle:Work';
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function _getErrorMessage()
	{
		return 'A work with id "%s" does not exist!';
	}
}
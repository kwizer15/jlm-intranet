<?php

/*
 * This file is part of the JLMDailyBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\DailyBundle\Form\Type;

use JLM\CoreBundle\Form\Type\AbstractSelectType;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class WorkSelectType extends AbstractSelectType
{
    protected function getTransformerClass()
    {
    	return '\JLM\DailyBundle\Form\DataTransformer\WorkToIntTransformer';
    }
    
    protected function getTypeName()
    {
    	return 'jlm_daily_work';
    }
}

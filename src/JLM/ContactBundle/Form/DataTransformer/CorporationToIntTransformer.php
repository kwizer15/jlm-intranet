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

use JLM\CoreBundle\Form\DataTransformer\ObjectToIntTransformer;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class CorporationToIntTransformer extends ObjectToIntTransformer
{
    /**
     * {@inheritdoc}
     */
    protected function _getClass()
    {
        return 'JLMContactBundle:Corporation';
    }
    
    /**
     * {@inheritdoc}
     */
    protected function _getErrorMessage()
    {
        return 'A corporation with id "%s" does not exist!';
    }
}

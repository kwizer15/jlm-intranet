<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ContactBundle\Form\Type;

use JLM\ContactBundle\Form\DataTransformer\CityToIntTransformer;
use JLM\CoreBundle\Form\Type\AbstractSelectType;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class CitySelectType extends AbstractSelectType
{
    /**
     * {@inheritdoc}
     */
    protected function getTransformerClass()
    {
        return CityToIntTransformer::class;
    }
}

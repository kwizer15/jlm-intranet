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

use JLM\ContactBundle\Form\DataTransformer\ContactToIntTransformer;
use JLM\CoreBundle\Form\Type\AbstractSelectType;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class ContactSelectType extends AbstractSelectType
{
    protected function getTransformerClass()
    {
        return ContactToIntTransformer::class;
    }
}

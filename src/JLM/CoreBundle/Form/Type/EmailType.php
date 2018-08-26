<?php

/*
 * This file is part of the JLMCoreBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class EmailType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'email';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'jlm_core_email';
    }
}

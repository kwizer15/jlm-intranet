<?php

/*
 * This file is part of the JLMCoreBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CoreBundle\Factory;

use JLM\CoreBundle\Builder\MailBuilderInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class MailFactory
{
    /**
     *
     * @param MailBuilderInterface $builder
     * @return mixed
     */
    public static function create(MailBuilderInterface $builder)
    {
        $builder->create();
        $builder->buildSubject();
        $builder->buildFrom();
        $builder->buildTo();
        $builder->buildCc();
        $builder->buildBcc();
        $builder->buildBody();
        $builder->buildPreAttachements();
        $builder->buildAttachements();
        
        return $builder->getMail();
    }
}

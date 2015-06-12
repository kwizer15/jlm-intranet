<?php

/*
 * This file is part of the JLMDailyBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\DailyBundle\Builder;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
interface MailBuilderInterface
{
    public function getMail();

    public function create();
    
    public function buildSubject();
    
    public function buildFrom();
    
    public function buildTo();
    
    public function buildCc();
    
    public function buildBcc();
    
    public function buildBody();
    
    public function buildAttachements();
}
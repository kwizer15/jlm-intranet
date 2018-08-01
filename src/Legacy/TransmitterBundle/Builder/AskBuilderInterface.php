<?php

/*
 * This file is part of the JLMTransmitterBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\TransmitterBundle\Builder;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
interface AskBuilderInterface
{
    /**
     * @return AskInterface
     */
    public function getAsk();

    public function create();
    
    public function buildCreation();
    
    public function buildTrustee();
    
    public function buildSite();
    
    public function buildMethod();
    
    public function buildMaturity();
    
    public function buildPerson();
    
    public function buildAsk();
}
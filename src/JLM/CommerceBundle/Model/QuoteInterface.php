<?php

/*
 * This file is part of the JLMCommerceBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CommerceBundle\Model;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
interface QuoteInterface
{
    /**
     * @return int
     */
    public function getNumber();
    
    /**
     * @return Door
     */
    public function getDoor();

    /**
     * @return AskInterface
     */
    public function getAsk();
}

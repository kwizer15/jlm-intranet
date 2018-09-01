<?php

/*
 * This file is part of the JLMTransmitterBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\TransmitterBundle\Factory;

use JLM\TransmitterBundle\Builder\AskBuilderInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class AskFactory
{
    /**
     *
     * @param AskBuilderInterface $bill
     *
     * @return AskInterface
     */
    public static function create(AskBuilderInterface $builder)
    {
        $builder->create();
        $builder->buildCreation();
        $builder->buildTrustee();
        $builder->buildMethod();
        $builder->buildMaturity();
        $builder->buildPerson();
        $builder->buildAsk();
        
        return $builder->getAsk();
    }
}

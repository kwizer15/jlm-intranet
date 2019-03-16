<?php

/*
 * This file is part of the JLMContractBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ContractBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use JLM\ContractBundle\Entity\Contract;

class ContractEvent extends Event
{
    /** @var string */
    protected $contract = null;

    public function __construct(Contract $contract)
    {
        $this->contract = $contract;
    }

    public function getContract()
    {
        return $this->contract;
    }
}

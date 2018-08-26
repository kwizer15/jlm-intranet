<?php

/*
 * This file is part of the JLMModelBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ModelBundle\Builder;

use JLM\ModelBundle\Entity\Door;
use JLM\ContractBundle\Model\ContractInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
abstract class DoorBillBuilderAbstract extends SiteBillBuilderAbstract
{
    protected $door;
    
    public function __construct(Door $door, $options = [])
    {
        $this->door = $door;
        parent::__construct($this->door->getAdministrator(), $options);
        $contract = $this->door->getActualContract();
        $this->trustee = ($contract instanceof ContractInterface) ? $contract->getManager() : $this->trustee ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildDetails()
    {
        $this->getBill()->setDetails($this->door->getType().' - '.$this->door->getLocation());
    }
}

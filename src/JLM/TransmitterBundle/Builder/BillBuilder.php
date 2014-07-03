<?php

/*
 * This file is part of the  package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\TransmitterBundle\Builder;

use JLM\BillBundle\Builder\BillBuilderAbstract;
use JLM\TransmitterBundle\Model\AttributionInterface;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class AttributionBillBuilder extends BillBuilderAbstract
{
    public function __construct(AttributionInterface $attribution)
    {
        $this->attribution = $attribution;
    }
    
    
}
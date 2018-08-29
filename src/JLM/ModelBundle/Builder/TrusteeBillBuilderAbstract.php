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

use JLM\CommerceBundle\Builder\BillBuilderAbstract;
use JLM\ModelBundle\Entity\Trustee;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
abstract class TrusteeBillBuilderAbstract extends BillBuilderAbstract
{
    /**
     * @var Trustee
     */
    protected $trustee;

    public function __construct(Trustee $trustee, $options = [])
    {
        $this->trustee = $trustee;
        parent::__construct($options);
    }

    /**
     * {@inheritdoc}
     */
    public function buildCustomer()
    {
        $this->bill->setTrustee($this->trustee);
        $this->bill->setTrusteeName($this->trustee->getBillLabel());
        $this->bill->setTrusteeAddress($this->trustee->getBillAddress()->toString());
        $this->bill->setAccountNumber(
            ($this->trustee->getAccountNumber() == null) ? '411000' : $this->trustee->getAccountNumber()
        );
    }
}

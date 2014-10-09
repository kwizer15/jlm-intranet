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

use JLM\BillBundle\Builder\BillBuilderAbstract;
use JLM\ModelBundle\Entity\Site;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
abstract class SiteBillBuilderAbstract extends BillBuilderAbstract
{
    abstract protected function _getSite();
    
    protected function _getTrustee()
    {
        return $this->_getSite()->getTrustee();
    }
   
    /**
     * {@inheritdoc}
     */
    public function buildBusiness()
    {
        $site = $this->_getSite();
        if ($site instanceof Site)
        {
            $this->getBill()->setSite($site->toString());
            $this->getBill()->setSiteObject($site);
            $this->getBill()->setPrelabel($site->getBillingPrelabel());
            $this->getBill()->setVat($site->getVat()->getRate());
        }
        else
        {
            $this->getBill()->setSite('');
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildCustomer()
    {
        $trustee = $this->_getTrustee();
        $this->getBill()->setTrustee($trustee);
        $this->getBill()->setTrusteeName($trustee->getBillingLabel());
        $this->getBill()->setTrusteeAddress($trustee->getAddressForBill()->toString());
        $this->getBill()->setAccountNumber(($trustee->getAccountNumber() == null) ? '411000' : $trustee->getAccountNumber());
    }
}
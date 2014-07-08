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
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
abstract class DoorBillBuilderAbstract extends BillBuilderAbstract
{
    abstract protected function _getDoor();
    
    protected function _getSite()
    {
        return $this->_getDoor()->getSite();
    }
    
    protected function _getTrustee()
    {
        $contract = $this->_getDoor()->getActualContract();
        return (empty($contract)) ? $this->_getDoor()->getSite()->getTrustee() : $contract->getTrustee();
    }
   
    /**
     * {@inheritdoc}
     */
    public function buildBusiness()
    {
        $site = $this->_getSite();
        $this->getBill()->setSite($site->toString());
        $this->getBill()->setSiteObject($site);
        $this->getBill()->setPrelabel($site->getBillingPrelabel());
        $this->getBill()->setVat($site->getVat()->getRate());
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildDetails()
    {
        $door = $this->_getDoor();
        $this->getBill()->setDetails($door->getType().' - '.$door->getLocation());
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
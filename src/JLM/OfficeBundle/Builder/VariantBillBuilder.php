<?php

/*
 * This file is part of the JLMOfficeBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\OfficeBundle\Builder;

use JLM\BillBundle\Builder\BillBuilderAbstract;
use JLM\OfficeBundle\Entity\QuoteVariant;
use JLM\BillBundle\Builder\BillLineFactory;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class VariantBillBuilder extends BillBuilderAbstract
{
    private $variant;
    
    public function __construct(QuoteVariant $variant)
    {
        $this->variant = $variant;
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildLines()
    {
        $lines = $this->variant->getLines();
        foreach ($lines as $line)
        {
            $l = BillLineFactory::create(new VariantBillLineBuilder($line));
            $l->setBill($this);
            $l->setPosition($line->getPosition());
            $this->addLine($l);
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildCustomer()
    {
        $door = $this->variant->getQuote()->getDoor();
        $contract = $door->getActualContract();
        $trustee = (empty($contract)) ? $door->getSite()->getTrustee() : $contract->getTrustee();

        $this->getBill()->setTrustee($trustee);
        $this->getBill()->setTrusteeName($trustee->getBillingLabel());
        $this->getBill()->setTrusteeAddress($trustee->getAddressForBill()->toString());
        $this->getBill()->setAccountNumber(($trustee->getAccountNumber() == null) ? '411000' : $trustee->getAccountNumber());
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildBusiness()
    {
        $site = $this->variant->getQuote()->getDoor()->getSite();
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
        $door = $this->variant->getQuote()->getDoor();
        $this->getBill()->setDetails($door->getType().' - '.$door->getLocation());
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildReference()
    {
        $this->getBill()->setReference('Selon votre accord sur notre devis n°'.$this->variant->getNumber());
    }
}
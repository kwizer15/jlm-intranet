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
    /**
     * 
     * @var AttributionInterface
     */
    private $attribution;
    
    /**
     * 
     * @var array
     */    
    private $options;
    
    /**
     * 
     * @param AttributionInterface $attribution
     * @param array $options
     */
    public function __construct(AttributionInterface $attribution, $options = array())
    {
        $this->attribution = $attribution;
        $this->options = $options;
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildLines()
    {
        $transmitters = $this->attribution->getTransmitters();
        $models = array();
        foreach ($transmitters as $transmitter)
        {
            $key = $transmitter->getModel()->getId();
            if (!isset($models[$key]))
            {
                $models[$key]['quantity'] = 0;
                $models[$key]['product'] = $transmitter->getModel()->getProduct();
                $models[$key]['numbers'] = array();
            }
            $models[$key]['quantity']++;
            $models[$key]['numbers'][] = $transmitter->getNumber();
        }
        $position = 0;
        
        // Description des numéros d'émetteurs
        foreach ($models as $key=>$values)
        {
            asort($values['numbers']);
             
            $description = '';
            $n1 = $temp = $values['numbers'][0];
            $i = 1;
            $size = sizeof($values['numbers']);
            if ($size > 1) {
                do {
                    if ($values['numbers'][$i] != $temp + 1) {
                        $n2 = $temp;
                        if ($n1 == $n2) {
                            $description .= 'n°'.$n1;
                        }
                        else {
                            $description .= 'du n°'.$n1.' au n°'.$n2;
                        }
                        $description .= chr(10);
                        $n1 = $models[$key]['numbers'][$i];
                    }
                    $temp = $values['numbers'][$i];
                    $i++;
                } while ($i < $size);
                
                if ($temp == $n1) {
                    $description .= 'n°'.$n1;
                }
                else {
                    $description .= 'du n°'.$n1.' au n°'.$temp;
                }
            }
            else {
                $description .= 'n°'.$n1;
            }
            
            //$line = BillLineFactory::create(AttributionBillLineBuilder())
        /********************* Attribution::poulateBillLines ************************/
             
            $line = new BillLine;
            $line->setPosition($position);
            $line->setDesignation($values['product']->getDesignation());
            $line->setIsTransmitter(true);
            $line->setProduct($values['product']);
            $line->setQuantity($values['quantity']);
            $line->setReference($values['product']->getReference());
            $line->setShowDescription(true);
            $line->setDescription($description);
            $line->setUnitPrice($values['product']->getUnitPrice($values['quantity'])); // Ajouter prix unitaire quantitatif
            $line->setVat($vat);
            $line->setBill($bill);
            $bill->addLine($line);
            $position++;
        }
        
        $port = (isset($this->options['port'])) ? $this->options['port'] : null; // Modif
        if ($port !== null)
        {
            $line = new BillLine;
            $line->setPosition($position);
            $line->setDesignation($port->getDesignation());
            $line->setIsTransmitter(true);
            $line->setProduct($port);
            $line->setQuantity(1);
            $line->setReference($port->getReference());
            $line->setUnitPrice($port->getUnitPrice(sizeof($transmitters)));
            $line->setVat($vat);
            $line->setBill($bill);
            $bill->addLine($line);
            $position++;
        }
        return $bill;
        /***************************** Fin ******************************************/
        
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildCustomer()
    {
        $trustee = $this->attribution->getAsk()->getTrustee();
        $this->getBill()->setTrustee($trustee);
        $this->getBill()->setTrusteeName($trustee->getBillingLabel());
        $this->getBill()->setTrusteeAddress($trustee->getAddressForBill()->toString());
        $accountNumber = ($trustee->getAccountNumber() == null) ? '411000' : $trustee->getAccountNumber();
        $this->getBill()->setAccountNumber($accountNumber);
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildBusiness()
    {
        $site = $this->attribution->getSite();
        $this->getBill()->setSiteObject($site);
        $this->getBill()->setSite($site->toString());
        $this->getBill()->setPrelabel($site->getBillingPrelabel());
        $this->setVat($site->getVat()->getRate());
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildReference()
    {
        $this->getBill()->setReference('Selon OS');
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildConditions()
    {
        foreach ($options as $key => $value)
        {
            switch ($key)
            {
            	case 'earlyPayment':
            	    $this->getBill()->setEarlyPayment($value);
            	    break;
            	case 'penalty':
            	    $this->getBill()->setPenalty($value);
            	    break;
            	case 'property':
            	    $this->getBill()->setProperty($value);
            	    break;
            	case 'vat':
            	    $this->getBill()->setVatTransmitter($vat);
            	    break;
            }
        }
    }
    
}
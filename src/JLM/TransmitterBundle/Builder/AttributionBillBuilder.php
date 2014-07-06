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
use JLM\ModelBundle\Builder\ProductBillLineBuilder;
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
    public function __construct(AttributionInterface $attribution, $vat, $options = array())
    {
        $this->attribution = $attribution;
        $this->vat = $vat;
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
            	$models[$key] = array(
            		'quantity' => 0,
            		'product' => $transmitter->getModel()->getProduct(),
            		'numbers' => array(),
            	);
            }
            $models[$key]['quantity']++;
            $models[$key]['numbers'][] = $transmitter->getNumber();
        }
        //$position = 0;
        
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
                        $add = ($n1 == $temp) ? 'n°'.$n1 : 'du n°'.$n1.' au n°'.$temp;
                        $description .= $add.chr(10);
                        $n1 = $models[$key]['numbers'][$i];
                    }
                    $temp = $values['numbers'][$i];
                    $i++;
                } while ($i < $size);
                $add = ($n1 == $temp) ? 'n°'.$n1 : 'du n°'.$n1.' au n°'.$temp;
                $description .= $add;
            }
            else {
                $description .= 'n°'.$n1;
            }
            
            $line = BillLineFactory::create(ProductBillLineBuilder($value['product'], $this->vat, $value['quantity'],array('description' => $description)));
            $bill->addLine($line);
        }
        
        $port = (isset($this->options['port'])) ? $this->options['port'] : null; // Modif
        if ($port !== null)
        {
            $line = BillLineFactory::create(ProductBillLineBuilder($port, $this->vat, sizeof($transmitters)));
            $line->setQuantity(1);
            $bill->addLine($line);
        }
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
            }
        }
        $this->getBill()->setVatTransmitter($this->vat);
    }
    
}
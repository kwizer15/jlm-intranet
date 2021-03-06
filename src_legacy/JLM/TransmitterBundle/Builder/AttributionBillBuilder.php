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

use JLM\CommerceBundle\Builder\BillBuilderAbstract;
use JLM\TransmitterBundle\Model\AttributionInterface;
use JLM\ModelBundle\Builder\ProductBillLineBuilder;
use JLM\CommerceBundle\Factory\BillLineFactory;

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
     * @var float
     */
    private $vat;

    /**
     *
     * @param AttributionInterface $attribution
     * @param array                $options
     */
    public function __construct(AttributionInterface $attribution, $vat, $options = [])
    {
        $this->attribution = $attribution;
        $this->vat = $vat;
        parent::__construct($options);
    }

    /**
     * {@inheritdoc}
     */
    public function buildLines()
    {
        $transmitters = $this->attribution->getTransmitters();
        $models = [];
        foreach ($transmitters as $transmitter) {
            $key = $transmitter->getModel()->getId();
            if (!isset($models[$key])) {
                $models[$key] = [
                    'quantity' => 0,
                    'product' => $transmitter->getModel()->getProduct(),
                    'numbers' => [],
                ];
            }
            $models[$key]['quantity']++;
            $models[$key]['numbers'][] = $transmitter->getNumber();
        }
        //$position = 0;

        // Description des numéros d'émetteurs
        foreach ($models as $key => $values) {
            asort($values['numbers']);

            $description = '';
            $n1 = $temp = $values['numbers'][0];
            $i = 1;
            $size = sizeof($values['numbers']);
            if ($size > 1) {
                do {
                    if ($values['numbers'][$i] != $temp + 1) {
                        $add = ($n1 == $temp) ? 'n°' . $n1 : 'du n°' . $n1 . ' au n°' . $temp;
                        $description .= $add . chr(10);
                        $n1 = $models[$key]['numbers'][$i];
                    }
                    $temp = $values['numbers'][$i];
                    $i++;
                } while ($i < $size);
                $add = ($n1 == $temp) ? 'n°' . $n1 : 'du n°' . $n1 . ' au n°' . $temp;
                $description .= $add;
            } else {
                $description .= 'n°' . $n1;
            }

            $line = BillLineFactory::create(
                new ProductBillLineBuilder(
                    $values['product'],
                    $this->vat,
                    $values['quantity'],
                    ['description' => $description]
                )
            );
            $this->getBill()->addLine($line);
        }

        if (null !== $this->getOption('port')) {
            $line = BillLineFactory::create(
                new ProductBillLineBuilder($this->getOption('port'), $this->vat, sizeof($transmitters))
            );
            $line->setQuantity(1);
            $this->getBill()->addLine($line);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function buildCustomer()
    {
        $trustee = $this->attribution->getAsk()->getTrustee();
        $this->getBill()->setTrustee($trustee);
        $this->getBill()->setTrusteeName($trustee->getBillLabel());
        $this->getBill()->setTrusteeAddress($trustee->getBillAddress()->toString());
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
        $this->getBill()->setVat($site->getVat()->getRate());
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
        parent::buildConditions();
        $this->getBill()->setVatTransmitter($this->vat);
    }
}

<?php

/*
 * This file is part of the JLMFeeBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\FeeBundle\Builder;

use JLM\ModelBundle\Builder\SiteBillBuilderAbstract;
use JLM\FeeBundle\Entity\Fee;
use JLM\BillBundle\Builder\BillLineFactory;
use JLM\ModelBundle\Builder\ProductBillLineBuilder;
use JLM\FeeBundle\Entity\FeesFollower;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class FeeBillBuilder extends SiteBillBuilderAbstract
{
    private $fee;
    private $follower;
    
    /**
     * 
     * @param Fee $fee
     * @param FeesFollower $follower
     * @param array $options
     */
    public function __construct(Fee $fee, FeesFollower $follower, $options = array())
    {
        $this->fee = $fee;
        $this->follower = $follower;
        parent::__construct($options);
    }
    
    /**
     * {@inheritdoc}
     */
    protected function _getTrustee()
    {
        return $this->fee->getTrustee();
    }
    
    /**
     * {@inheritdoc}
     */
    protected function _getSite()
    {
        $contrats = $this->fee->getContracts();
        if (empty($contrats))
        {
            return new Site();
        }
        
        return $contrats[0]->getDoor()->getSite();
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildCustomer()
    {
        parent::buildCustomer();
        $this->getBill()->setTrusteeAddress($this->fee->getBillingAddress()->toString());
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildBusiness()
    {
        parent::buildBusiness();
        $this->getBill()->setSite($this->fee->getAddress());
        $this->getBill()->setPrelabel($this->fee->getPrelabel());
        $this->getBill()->setVat($this->fee->getVat()->getRate());
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildDetails()
    {
        $this->getBill()->setDetails(implode(chr(10), $this->fee->getDoorDescription()));
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildReference()
    {
        $group = ($this->fee->getGroup() != '') ? 'Groupe : '.$this->fee->getGroup().chr(10) : '';
        $contrat = 'Contrat';
        $s = (count($this->fee->getContractNumbers()) > 1) ? 's' : '';
        $ref = $group.$contrat.$s.' n°'.implode(', n°', $this->fee->getContractNumbers());
        $this->getBill()->setReference($ref);
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildCreation()
    {
        $creation = $this->follower->getActivation();
        $this->getBill()->setCreation($creation);
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildConditions()
    {
        parent::buildConditions();
        if ($this->getOption('number') !== null)
        {
            $this->getBill()->setNumber($this->getOption('number'));
        }
        $this->getBill()->setFee($this->fee);
    	$this->getBill()->setFeesFollower($this->follower);
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildLines()
    {
        $periods = array('1'=>'P1Y','2'=>'P6M','4'=>'P3M');
        foreach ($this->fee->getContracts() as $key=>$contract)
        {
            $begin = clone $this->follower->getActivation();
            $endContract = $contract->getEnd();
            $end = clone $this->follower->getActivation();
            $end->add(new \DateInterval($periods[$this->fee->getFrequence()]));
            $end->sub(new \DateInterval('P1D'));
            $frequenceString = ' '.$this->fee->getFrequenceString();
            if ($endContract !== null)
            {
                if ($endContract < $end)
                {
                    $end = $endContract;
                    $frequenceString = '';
                }
            }
            $product = $this->getOption('product');
            $rapport = ($end->diff($begin)->format('%m') + 1) / 12;
            $fee = $contract->getFee() * $rapport;
            $line = BillLineFactory::create(new ProductBillLineBuilder($product, $this->fee->getVat()->getRate(), 1, array(
                'price' => $fee,
                'designation' => $product->getDesignation().$frequenceString.' du '.$begin->format('d/m/Y').' au '.$end->format('d/m/Y'),
                'description' => $contract->getDoor()->getType().' / '.$contract->getDoor()->getLocation(),
            )));
            $line->setPosition($key);
            $line->setBill($this->getBill());
            $this->getBill()->addLine($line);
        }
    }
}
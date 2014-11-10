<?php

/*
 * This file is part of the JLMCommerceBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\OfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JLM\DailyBundle\Entity\Work;
use JLM\CommerceBundle\Model\QuoteVariantInterface;
use JLM\CommerceBundle\Model\QuoteInterface;
use JLM\CommerceBundle\Model\QuoteLineInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class QuoteVariant implements QuoteVariantInterface
{
	/**
	 * @var int $id
	 */
	private $id;
	
	/**
	 * Quote
	 * @var QuoteInterface $quote
	 */
	private $quote;
	
	/**
	 * Création
	 * @var \DateTime
	 */
	private $creation;
	
	/**
	 * Variant number
	 * @var int $variantNumber
	 */
	private $variantNumber;
	
	/**
	 * Texte d'intro
	 * @var string $intro
	 */
	private $intro;
	
	/**
	 * @var string $paymentRules
	 */
	private $paymentRules;
	
	/**
	 * @var string $deliveryRules
	 */
	private $deliveryRules;
	
	/**
	 * Remise générale
	 * @var float $discount
	 */
	private $discount = 0;

	/**
	 * Etat
	 * -1 = annulé
	 * 0 = en saisie
	 * 1 = près à envoyer
	 * 2 = imprimer
	 * 3 = envoyé (en attente de l'accusé)
	 * 4 = envoyé (accusé reçu)
	 * 5 = accordé
	 * @var int $state
	 */
	private $state = 0;
	
	/**
	 * Lignes
	 * @var ArrayCollection $lines
	 */
	private $lines;
	
	/**
	 * Work
	 * Ligne Travaux suite au devis
	 */
	private $work;
	
	/**
	 * Construteur
	 *
	 */
	public function __construct()
	{
		$this->lines = new ArrayCollection;
	}
	
	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId()
	{
		return $this->id;
	}
	
	/**
	 * Set quote
	 *
	 * @return self
	 */
	public function setQuote(QuoteInterface $quote)
	{
		$this->quote = $quote;
		
		return $this;
	}
	
	/**
	 * Get quote
	 * 
	 * @return QuoteInterface
	 */
	public function getQuote()
	{
		return $this->quote;
	}
	
	/**
	 * Set variantNumber
	 *
	 * @param string $variantNumber
	 * @return self
	 */
	public function setVariantNumber($variantNumber)
	{
		$this->variantNumber = $variantNumber;
		
		return $this;
	}
	
	/**
	 * Get variantNumber
	 *
	 * @return string
	 */
	public function getVariantNumber()
	{
		return $this->variantNumber;
	}
	
	/**
	 * Set creation
	 *
	 * @param \DateTime $creation
	 * @return self
	 */
	public function setCreation(\DateTime $creation)
	{
		$this->creation = $creation;
	
		return $this;
	}
	
	/**
	 * Get creation
	 *
	 * @return \DateTime
	 */
	public function getCreation()
	{
		return $this->creation;
	}
	
	/**
	 * Get number
	 *
	 * @return string
	 */
	public function getNumber()
	{
		if ($this->getVariantNumber() == 0)
		{
			return $this->getQuote()->getNumber();
		}
		return $this->getQuote()->getNumber().'-'.$this->getVariantNumber();
	}
	
	/**
	 * Get intro
	 * 
	 * @return string
	 */
	public function getIntro()
	{
		return $this->intro;
	}
	
	/**
	 * Set intro
	 * 
	 * return self
	 */
	public function setIntro($intro)
	{
		$this->intro = $intro;
		
		return $this;
	}
	
	/**
	 * Set paymentRules
	 *
	 * @param string $paymentRules
	 * @return self
	 */
	public function setPaymentRules($paymentRules)
	{
		$this->paymentRules = $paymentRules;
	
		return $this;
	}
	
	/**
	 * Get paymentRules
	 *
	 * @return string
	 */
	public function getPaymentRules()
	{
		return $this->paymentRules;
	}
	
	/**
	 * Set deliveryRules
	 *
	 * @param string $deliveryRules
	 * @return self
	 */
	public function setDeliveryRules($deliveryRules)
	{
		$this->deliveryRules = $deliveryRules;
	
		return $this;
	}
	
	/**
	 * Get deliveryRules
	 *
	 * @return string
	 */
	public function getDeliveryRules()
	{
		return $this->deliveryRules;
	}
	
	/**
	 * Set state
	 *
	 * @param int $state
	 * @return self
	 */
	public function setState($state)
	{
		$this->state = $state;
		
		return $this;
	}
	
	/**
	 * Get state
	 *
	 * @return int
	 */
	public function getState()
	{
		return $this->state;
	}
	
	/**
	 * Set discount
	 *
	 * @param float $discount
	 * @return self
	 */
	public function setDiscount($discount)
	{
		$this->discount = $discount;
	
		return $this;
	}
	
	/**
	 * Get discount
	 *
	 * @return float
	 */
	public function getDiscount()
	{
		return $this->discount;
	}
	
	/**
	 * Add lines
	 *
	 * @param QuoteLineInterface $line
	 * @return bool
	 */
	public function addLine(QuoteLineInterface $line)
	{
		$line->setVariant($this);
		$this->lines[] = $line;
		 
		return $this;
	}
	
	/**
	 * Remove lines
	 *
	 * @param QuoteLineInterface $line
	 */
	public function removeLine(QuoteLineInterface $line)
	{
		$line->setVariant();
		
		return $this->lines->removeElement($line);
	}
	
	/**
	 * Get lines
	 *
	 * @return Doctrine\Common\Collections\Collection
	 */
	public function getLines()
	{
		return $this->lines;
	}
	
	/**
	 * Get Total HT
	 * @return float
	 */
	public function getTotalPrice()
	{
		$total = 0;
		foreach ($this->getLines() as $line)
		{
			$total += $line->getPrice();
		}
		$total *= (1-$this->getDiscount());
		
		return $total;
	}
	
	/**
	 * Get Total TVA
	 * @return float
	 */
	public function getTotalVat()
	{
		$total = 0;
		foreach ($this->getLines() as $line)
		{
			$total += $line->getVatValue();
		}
		$total *= (1 - $this->getDiscount());
		
		return $total;
	}
	
	/**
	 * Get Total TTC
	 */
	public function getTotalPriceAti()
	{
		$total = 0;
		foreach ($this->getLines() as $line)
		{
			$total += $line->getPriceAti();
		}
		$total *= (1 - $this->getDiscount());
		
		return $total;
	}
	
	/**
	 * Get TotalPurchase
	 */
	public function getTotalPurchase()
	{
		$total = 0;
		foreach ($this->getLines() as $line)
		{
			$total += $line->getTotalPurchasePrice();
		}
		
		return $total;
	}
	
	/**
	 * Get totalMargin
	 * 
	 * @return float
	 */
	public function getTotalMargin()
	{
		return $this->getTotalPrice() - $this->getTotalPurchase();
	}

    /**
     * Set work
     *
     * @param Work $work
     * @return QuoteVariant
     */
    public function setWork(Work $work = null)
    {
        $this->work = $work;
    
        return $this;
    }

    /**
     * Get work
     *
     * @return Work 
     */
    public function getWork()
    {
        return $this->work;
    }
}
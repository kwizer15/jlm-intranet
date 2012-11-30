<?php

namespace JLM\OfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * JLM\OfficeBundle\Entity\QuoteVariant
 *
 * @ORM\Table(name="quote_variant")
 * @ORM\Entity
 */
class QuoteVariant
{
	/**
	 * @var int $id
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;
	
	/**
	 * Quote
	 * @var Quote $quote
	 * 
	 * @ORM\ManyToOne(targetEntity="Quote",inversedBy="quote")
	 */
	private $quote;
	
	/**
	 * Création
	 * @var \DateTime
	 * 
	 * @ORM\Column(name="creation", type="datetime")
	 */
	private $creation;
	
	/**
	 * Variant number
	 * @var int $variantNumber
	 * 
	 * @ORM\Column(name="variant_number",type="smallint")
	 */
	private $variantNumber;
	
	/**
	 * Texte d'intro
	 * @var string $intro
	 *
	 * @ORM\Column(name="intro",type="text")
	 */
	private $intro;
	
	/**
	 * @var string $paymentRules
	 *
	 * @ORM\Column(name="payment_rules", type="string", length=255)
	 */
	private $paymentRules;
	
	/**
	 * @var string $deliveryRules
	 *
	 * @ORM\Column(name="delivery_rules", type="string", length=255)
	 */
	private $deliveryRules;
	
	/**
	 * Remise générale
	 * @var float $discount
	 *
	 * @ORM\Column(name="discount", type="decimal", scale=7)
	 */
	private $discount;
	
	/**
	 * Validé
	 * @var bool $valid
	 *
	 * @ORM\Column(name="valid",type="boolean")
	 */
	private $valid = false;
	
	/**
	 * Envoyé
	 * @var bool $send
	 *
	 * @ORM\Column(name="send",type="boolean")
	 */
	private $send = false;
	
	/**
	 * Accordé
	 * @var bool $given
	 *
	 * @ORM\Column(name="given",type="boolean")
	 */
	private $given = false;
	
	/**
	 * Lignes
	 * @var ArrayCollection $lines
	 *
	 * @ORM\OneToMany(targetEntity="QuoteLine",mappedBy="quote")
	 * @ORM\OrderBy({"position" = "ASC"})
	 */
	private $lines;
	
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
	 * @return Quote
	 */
	public function setQuote(Quote $quote)
	{
		$this->quote = $quote;
		return $this;
	}
	
	/**
	 * Get quote
	 * 
	 * @return Quote
	 */
	public function getQuote()
	{
		return $this->quote;
	}
	
	/**
	 * Set variantNumber
	 *
	 * @param string $variantNumber
	 * @return Quote
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
	 * @return Document
	 */
	public function setCreation($creation)
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
			return $this->getQuote()->getNumber();
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
	 * return QuoteVariant
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
	 * @return Quote
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
	 * @return Quote
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
	 * Set valid
	 *
	 * @param boolean $valid
	 * @return Quote
	 */
	public function setValid($valid = true)
	{
		$this->valid = (bool)$valid;
	
		return $this;
	}
	
	/**
	 * Get valid
	 *
	 * @return boolean
	 */
	public function getValid()
	{
		return $this->valid;
	}
	
	/**
	 * Is valid
	 *
	 * @return boolean
	 */
	public function isValid()
	{
		return $this->getValid();
	}
	
	/**
	 * Set send
	 *
	 * @param boolean $send
	 * @return Quote
	 */
	public function setSend($send = true)
	{
		$this->send = (bool)$send;
	
		return $this;
	}
	
	/**
	 * Get send
	 *
	 * @return boolean
	 */
	public function getSend()
	{
		return $this->send;
	}
	
	/**
	 * Is send
	 *
	 * @return boolean
	 */
	public function isSend()
	{
		return $this->getSend();
	}
	
	/**
	 * Set given
	 *
	 * @param boolean $given
	 * @return Quote
	 */
	public function setGiven($given = true)
	{
		$this->given = (bool)$given;
	
		return $this;
	}
	
	/**
	 * Get given
	 *
	 * @return boolean
	 */
	public function getGiven()
	{
		return $this->given;
	}
	
	/**
	 * Is given
	 *
	 * @return boolean
	 */
	public function isGiven()
	{
		return $this->getGiven();
	}
	
	/**
	 * Set discount
	 *
	 * @param float $discount
	 * @return Document
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
	 * @param JLM\ModelBundle\Entity\QuoteLine $lines
	 * @return Quote
	 */
	public function addLine(\JLM\OfficeBundle\Entity\QuoteLine $lines)
	{
		$lines->setVariant($this);
		$this->lines[] = $lines;
		 
		return $this;
	}
	
	/**
	 * Remove lines
	 *
	 * @param JLM\ModelBundle\Entity\QuoteLine $lines
	 */
	public function removeLine(\JLM\OfficeBundle\Entity\QuoteLine $lines)
	{
		$lines->setVariant();
		$this->lines->removeElement($lines);
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
	 */
	public function getTotalPrice()
	{
		$total = 0;
		foreach ($this->getLines() as $line)
			$total += $line->getPrice();
		$total *= (1-$this->getDiscount());
		return $total;
	}
	
	/**
	 * Get Total TVA
	 */
	public function getTotalVat()
	{
		$total = 0;
		foreach ($this->getLines() as $line)
			$total += $line->getVatValue();
		$total *= (1-$this->getDiscount());
		return $total;
	}
	
	/**
	 * Get Total TTC
	 */
	public function getTotalPriceAti()
	{
		$total = 0;
		foreach ($this->getLines() as $line)
			$total += $line->getPriceAti();
		$total *= (1-$this->getDiscount());
		return $total;
	}
	
	/**
	 * Get TotalPurchase
	 */
	public function getTotalPurchase()
	{
		$total = 0;
		foreach ($this->getLines() as $line)
			$total += $line->getTotalPurchasePrice();
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
}
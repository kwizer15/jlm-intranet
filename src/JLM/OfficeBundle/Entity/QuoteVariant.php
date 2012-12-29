<?php

namespace JLM\OfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * JLM\OfficeBundle\Entity\QuoteVariant
 *
 * @ORM\Table(name="quote_variant")
 * @ORM\Entity(repositoryClass="JLM\OfficeBundle\Entity\QuoteVariantRepository")
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
	 *
	 * @ORM\Column(name="state",type="smallint")
	 */
	private $state = 0;
	
	/**
	 * Lignes
	 * @var ArrayCollection $lines
	 *
	 * @ORM\OneToMany(targetEntity="QuoteLine",mappedBy="variant")
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
	 * Set state
	 *
	 * @param int $state
	 * @return QuoteVariant
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
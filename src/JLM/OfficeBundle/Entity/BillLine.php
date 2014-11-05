<?php
namespace JLM\OfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JLM\BillBundle\Model\BillLineInterface;
use JLM\CommerceBundle\Entity\CommercialPartLineProduct;
use JLM\BillBundle\Model\BillInterface;

/**
 * JLM\OfficeBundle\Entity\BillLine
 *
 * @ORM\Table(name="bill_lines")
 * @ORM\Entity
 */
class BillLine extends CommercialPartLineProduct implements BillLineInterface
{
	/**
	 * @var integer $id
	 * 
	 * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO") 
	 */
	private $id;
	
	/**
	 * @var Bill $bill
	 * 
	 * @ORM\ManyToOne(targetEntity="JLM\BillBundle\Model\BillInterface",inversedBy="lines")
	 */
	private $bill;

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
     * Set bill
     *
     * @param BillInterface $variant
     * @return self
     */
    public function setBill(BillInterface $bill = null)
    {
        $this->bill = $bill;
    
        return $this;
    }

    /**
     * Get bill
     *
     * @return BillInterface
     */
    public function getBill()
    {
        return $this->bill;
    }
    
    /**
     * Populate from QuoteLine
     * @deprecated
     */
    public function populateFromQuoteLine(QuoteLine $line)
    {
    	$this->setPosition($line->getPosition());
    	$this->setProduct($line->getProduct());
    	$this->setReference($line->getReference());
    	$this->setDesignation($line->getDesignation());
    	$this->setDescription($line->getDescription());
    	$this->setShowDescription($line->getShowDescription());
    	$this->setIsTransmitter($line->getIsTransmitter());
    	$this->setQuantity($line->getQuantity());
    	$this->setUnitPrice($line->getUnitPrice());
    	$this->setDiscount($line->getDiscount());
    	$this->setVat($line->getVat());
    	
    	return $this;
    }
}
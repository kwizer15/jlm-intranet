<?php
namespace JLM\OfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JLM\OfficeBundle\Entity\BillLine
 *
 * @ORM\Table(name="bill_lines")
 * @ORM\Entity
 */
class BillLine extends DocumentLine
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
	 * @ORM\ManyToOne(targetEntity="Bill",inversedBy="lines")
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
     * @param JLM\OfficeBundle\Entity\Bill $variant
     * @return QuoteLine
     */
    public function setBill(\JLM\OfficeBundle\Entity\Bill $bill = null)
    {
        $this->bill = $bill;
    
        return $this;
    }

    /**
     * Get bill
     *
     * @return JLM\OfficeBundle\Entity\Bill
     */
    public function getBill()
    {
        return $this->bill;
    }
}
<?php
namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * 
 * @author kwizer
 * @ORM\Table(name="fees")
 * @ORM\Entity
 */
class Fee
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
	 * @var ArrayCollection $contracts
	 * @ORM\ManyToMany(targetEntity="Contract")
	 * @ORM\JoinTable(name="fees_contracts",
	 * 				  joinColumns={@ORM\JoinColumn(name="fee_id", referencedColumnName="id")},
	 * 				  inverseJoinColumns={@ORM\JoinColumn(name="contract_id", referencedColumnName="id")}
	 * )
	 */
	private $contracts;
	
	/**
	 * @var Trustee $trustee
	 * @ORM\ManyToOne(targetEntity="Trustee")
	 */
	private $trustee;
	
	/**
	 * @var string $address
	 * @ORM\Column(name="address",type="text")
	 */
	private $address;
	
	/**
	 * @var string $prelabel
	 * @ORM\Column(name="prelabel",type="text", nullable=true)
	 */
	private $prelabel;
	
	/**
	 * @var int $frequence
	 * @ORM\Column(name="frequence",type="integer")
	 */
	private $frequence = 2;
	
	/**
	 * @var Vat $vat
	 * @ORM\ManyToOne(targetEntity="VAT")
	 */
	private $vat;
	
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->contracts = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set address
     *
     * @param string $address
     * @return Fee
     */
    public function setAddress($address)
    {
        $this->address = $address;
    
        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set prelabel
     *
     * @param string $prelabel
     * @return Fee
     */
    public function setPrelabel($prelabel)
    {
        $this->prelabel = $prelabel;
    
        return $this;
    }

    /**
     * Get prelabel
     *
     * @return string 
     */
    public function getPrelabel()
    {
        return $this->prelabel;
    }

    /**
     * Set frequence
     *
     * @param int $frequence
     * @return Fee
     */
    public function setFrequence($frequence)
    {
    	$values = array(1,2,4);
    	if (in_array($frequence,$values))
    		$this->frequence = $frequence;
    	return $this;
    }
    
    /**
     * Get frequence
     *
     * @return int
     */
    public function getFrequence()
    {
    	return $this->frequence;
    }
    
    /**
     * Set Vat
     * @return Fee
     */
    public function setVat(VAT $vat)
    {
    	$this->vat = $vat;
    	return $this;
    }
    
    /**
     * Get Vat
     * @return VAT
     */
    public function getVat()
    {
    	return $this->vat;
    }
    
    /**
     * Add contracts
     *
     * @param JLM\ModelBundle\Entity\Contract $contracts
     * @return Fee
     */
    public function addContract(\JLM\ModelBundle\Entity\Contract $contracts)
    {
        $this->contracts[] = $contracts;
    
        return $this;
    }

    /**
     * Remove contracts
     *
     * @param JLM\ModelBundle\Entity\Contract $contracts
     */
    public function removeContract(\JLM\ModelBundle\Entity\Contract $contracts)
    {
        $this->contracts->removeElement($contracts);
    }

    /**
     * Get contracts
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getContracts()
    {
        return $this->contracts;
    }

    /**
     * Set trustee
     *
     * @param JLM\ModelBundle\Entity\Trustee $trustee
     * @return Fee
     */
    public function setTrustee(\JLM\ModelBundle\Entity\Trustee $trustee = null)
    {
        $this->trustee = $trustee;
    
        return $this;
    }

    /**
     * Get trustee
     *
     * @return JLM\ModelBundle\Entity\Trustee 
     */
    public function getTrustee()
    {
        return $this->trustee;
    }
    
    /**
     * Get Contract Numbers
     * @return array
     */
    public function getContractNumbers()
    {
    	$numbers = array();
    	foreach ($this->contracts as $contract)
    	{
    		if (!in_array($contract->getNumber(),$numbers))
    			$numbers[] = $contract->getNumber();
    	}
    	return $numbers;
    }
    
    /**
     * Get Descriptif des portes
     * @return string
     */
    public function getDoorDescription()
    {
    	$doors = array();
    	foreach ($this->contracts as $contract)
    	{
    		$install = $contract->getDoor();
    		$doors[] = $install->getType().' / '.$install->getLocation();
    	}
    	return $doors;
    }
    
    /**
     * Get BillingAddress
     * @return Address
     */
    public function getBillingAddress()
    {
    	$address = $this->getTrustee()->getAddress();
		$billingaddress = $this->getTrustee()->getBillingAddress();
		if ($billingaddress)
			if ($billingaddress->getStreet())
				return $billingaddress;
		return $address;
    }
    
    /**
     * Get Amount
     * @return float
     */
    public function getYearAmount()
    {
    	$amount = 0;
    	foreach ($this->contracts as $contract)
    		$amount += $contract->getFee();
    	return $amount;
    }
    
    /**
     * Get Amount
     * @return float
     */
    public function getAmount()
    {
    	return $this->getYearAmount() / $this->getFrequence();
    }
   
    /**
     * Get Reference
     */
    public function getGroup()
    {
    	$group = '';
    	foreach ($this->contracts as $contract)
    	{
    		$group = $contract->getDoor()->getSite()->getGroupNumber();
    		if ($group != '')
    			$group .= ' ';
    	}
    	return $group;
    }
    
    public function getBill($number, Product $product,\JLM\OfficeBundle\Entity\FeesFollower $follower)
    {
    	$bill = new \JLM\OfficeBundle\Entity\Bill;
    	$bill->setFee($this);
    	$bill->setFeesFollower($follower);
    	$bill->setCreation(new \DateTime);
    	$bill->setNumber($number);
    	$bill->setTrustee($this->getTrustee());
    	$bill->setTrusteeName($this->getTrustee()->getName());
    	$bill->setTrusteeAddress($this->getBillingAddress());
    	$bill->setAccountNumber($this->getTrustee()->getAccountNumber());
    	$bill->setPrelabel($this->getPrelabel());
    	$bill->setVat($this->getVat()->getRate());
    	$ref = '';
    	if ($this->getGroup() != '')
    		$ref .= 'Groupe : '.$this->getGroup().chr(10);
    	$ref .= 'Contrat : ';
    	foreach ($this->getContractNumbers() as $key=>$n)
    	{
    		if ($key > 0)
    			$ref .= ', ';
    		$ref .= $n;
    	}
    	$bill->setReference($ref);
    	$bill->setSite($this->getAddress());
    	$dd = '';
    	foreach ($this->getDoorDescription() as $key=>$desc)
    	{
    		if ($key > 0)
    			$dd .= chr(10);
    		$dd .= $desc;
    	}
    	$bill->setDetails($dd);
    	foreach ($this->getContracts() as $key=>$contract)
    	{
    		$begin = \DateTime::createFromFormat('Y-m-d',$follower->getActivation()->format('Y-m-d'));
    		$end = \DateTime::createFromFormat('Y-m-d',$follower->getActivation()->format('Y-m-d'));
    		$periods = array('1'=>'P1Y','2'=>'P6M','4'=>'P3M');
    		$end->add(new \DateInterval($periods[$this->getFrequence()]));
    		$end->sub(new \DateInterval('P1D'));
    		$line = new \JLM\OfficeBundle\Entity\BillLine();
    		$line->setBill($bill);
    		$line->setPosition($key);
    		$line->setReference($product->getReference());
    		$line->setDesignation($product->getDesignation().' du '.$begin->format('d/m/Y').' au '.$end->format('d/m/Y'));
    		
    		$line->setShowDescription(true);
    		$line->setDescription($contract->getDoor()->getType().' / '.$contract->getDoor()->getLocation());
    		$line->setUnitPrice($contract->getFee() / $this->getFrequence());
    		$line->setQuantity(1);
    		$line->setVat($this->getVat()->getRate());
    		$bill->addLine($line);
    	}
    	$bill->setEarlyPayment('0,00% pour paiement anticipé');
    	$bill->setMaturity(null);
    	$bill->setPenalty('de 1,50% par mois pour paiement différé');
    	return $bill;
    }
    
}
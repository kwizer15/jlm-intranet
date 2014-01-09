<?php
namespace JLM\FeeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use JLM\ModelBundle\Entity\VAT;
use JLM\ModelBundle\Entity\Contract;
use JLM\ModelBundle\Entity\Trustee;
use JLM\ModelBundle\Entity\Product;

use JLM\OfficeBundle\Entity\Bill;
use JLM\OfficeBundle\Entity\BillLine;

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
	 * @ORM\ManyToMany(targetEntity="JLM\ModelBundle\Entity\Contract")
	 * @ORM\JoinTable(name="fees_contracts",
	 * 				  joinColumns={@ORM\JoinColumn(name="fee_id", referencedColumnName="id")},
	 * 				  inverseJoinColumns={@ORM\JoinColumn(name="contract_id", referencedColumnName="id")}
	 * )
	 * @Assert\Valid(traverse=true)
	 */
	private $contracts;
	
	/**
	 * @var Trustee $trustee
	 * @ORM\ManyToOne(targetEntity="JLM\ModelBundle\Entity\Trustee")
	 * @Assert\Valid
	 */
	private $trustee;
	
	/**
	 * @var string $address
	 * @ORM\Column(name="address",type="text")
	 * @Assert\Type(type="string")
	 * @Assert\NotNull
	 */
	private $address;
	
	/**
	 * @var string $prelabel
	 * @ORM\Column(name="prelabel",type="text", nullable=true)
	 * @Assert\Type(type="string")
	 */
	private $prelabel;
	
	/**
	 * @var int $frequence
	 * @ORM\Column(name="frequence",type="integer")
	 * @Assert\Choice(choices={1,2,3,4})
	 * @Assert\NotNull
	 */
	private $frequence = 2;
	
	/**
	 * @var Vat $vat
	 * @ORM\ManyToOne(targetEntity="JLM\ModelBundle\Entity\VAT")
	 * @Assert\Valid
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
     * Get frequence string
     *
     * @return string
     */
    public function getFrequenceString()
    {
    	switch ($this->getFrequence())
    	{
    		case 1:
    			return 'annuelle';
    			break;
    		case 2:
    			return 'semestrielle';
    			break;
    		case 4:
    			return 'trimestrielle';
    			break;
    		default:
    			return '';
    	}
    	return '';
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
    public function addContract(Contract $contracts)
    {
        $this->contracts[] = $contracts;
    
        return $this;
    }

    /**
     * Remove contracts
     *
     * @param JLM\ModelBundle\Entity\Contract $contracts
     */
    public function removeContract(Contract $contracts)
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
    public function setTrustee(Trustee $trustee = null)
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
			if ($billingaddress->getStreet() && $billingaddress->getCity() !== null)
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
    		$group .= $contract->getDoor()->getSite()->getGroupNumber();
    		if ($group != '')
    			$group .= ' ';
    	}
    	return $group;
    }
    
    public function getBill(Product $product, FeesFollower $follower, $number)
    {
    	$bill = new Bill;
    	$bill->setNumber($number);
    	$bill->setFee($this);
    	$bill->setFeesFollower($follower);
    	// $creation = \DateTime::createFromFormat('Y-m-d',$follower->getActivation()->format('Y-m-d'));
    	// $creation->add(new \DateInterval('P1M'));
    	$creation = new \DateTime;
    	$bill->setCreation($creation);
    	$bill->setTrustee($this->getTrustee());
    	$bill->setTrusteeName($this->getTrustee()->getBillingLabel());
    	$bill->setTrusteeAddress($this->getBillingAddress()->toString());
    	$bill->setAccountNumber($this->getTrustee()->getAccountNumber());
    	$bill->setPrelabel($this->getPrelabel());
    	$bill->setVat($this->getVat()->getRate());
    	$ref = '';
    	if ($this->getGroup() != '')
    		$ref .= 'Groupe : '.$this->getGroup().chr(10);
    	$ref .= 'Contrat';
    	if (count($this->getContractNumbers()) > 1)
    		$ref .= 's';
    	$ref .= ' n°';
    	foreach ($this->getContractNumbers() as $key=>$n)
    	{
    		if ($key > 0)
    			$ref .= ', n°';
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
    		$line = new BillLine();
    		$line->setBill($bill);
    		$line->setPosition($key);
    		$line->setReference($product->getReference());
    		$line->setDesignation($product->getDesignation().' '.$this->getFrequenceString().' du '.$begin->format('d/m/Y').' au '.$end->format('d/m/Y'));
    		
    		$line->setShowDescription(true);
    		$line->setDescription($contract->getDoor()->getType().' / '.$contract->getDoor()->getLocation());
    		$line->setUnitPrice($contract->getFee() / $this->getFrequence());
    		$line->setQuantity(1);
    		$line->setVat($this->getVat()->getRate());
    		$bill->addLine($line);
    	}
    	$bill->setEarlyPayment('0,00% pour paiement anticipé');
    	$bill->setMaturity(30);
    	$bill->setPenalty('de 1,50% par mois pour paiement différé');
    	return $bill;
    }
    
}
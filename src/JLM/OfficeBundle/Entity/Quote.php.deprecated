<?php

namespace JLM\OfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JLM\DailyBundle\Entity\Work;
use JLM\ContactBundle\Model\PersonInterface;
use JLM\CommerceBundle\Entity\CommercialPart;

/**
 * JLM\OfficeBundle\Entity\Quote
 *
 * @ORM\Table(name="quote")
 * @ORM\Entity(repositoryClass="JLM\OfficeBundle\Entity\QuoteRepository")
 */
class Quote extends CommercialPart
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
	 * Suiveur (pour le suivi)
	 * @var Collaborator $follower
	 * 
	 * @ORM\Column(name="follower",type="string", nullable=true)
	 */
	private $follower;
	
	/**
	 * Suiveur (pour le devis)
	 * @var string $followerCp
	 *
	 * @ORM\Column(name="follower_cp",type="string")
	 */
	private $followerCp;
	
	/**
	 * Porte concernée (pour le suivi)
	 * @var Door $door
	 * 
	 * @ORM\ManyToOne(targetEntity="JLM\ModelBundle\Entity\Door")
	 */
	private $door;
	
	/**
	 * Porte concernée (pour le devis)
	 * @var string $doorCp
	 *
	 * @ORM\Column(name="door_cp",type="text")
	 */
	private $doorCp;
	
	/**
	 * @var JLM\ModelBundle\Entity\SiteContact $contact
	 * 
	 * @ORM\ManyToOne(targetEntity="JLM\ModelBundle\Entity\SiteContact")
	 */
	private $contact;
	
	/**
	 * @var JLM\ContactBundle\Model\PersonInterface $contactPerson
	 *
	 * @ORM\ManyToOne(targetEntity="JLM\ContactBundle\Model\PersonInterface")
	 */
	private $contactPerson;
	
	/**
	 * @var string $contactCp
	 * 
	 * @ORM\Column(name="contact_cp", type="string")
	 */
	private $contactCp;
	

	
	/**
	 * @var ArrayCollection $variants
	 * 
	 * @ORM\OneToMany(targetEntity="QuoteVariant",mappedBy="quote")
	 */
	private $variants;
	
	/**
	 * Demande de devis liée
	 * @var AskQuote
	 * 
	 * @ORM\ManyToOne(targetEntity="AskQuote",inversedBy="quotes")
	 */
	private $ask;
	
	/**
	 * Construteur
	 *
	 */
	public function __construct()
	{
		$this->variants = new ArrayCollection;
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
     * Set follower
     *
     * @param string $follower
     * @return Quote
     */
    public function setFollower($follower)
    {
        $this->follower = $follower;
    
        return $this;
    }

    /**
     * Get follower
     *
     * @return string 
     */
    public function getFollower()
    {
        return $this->follower;
    }

    /**
     * Set followerCp
     *
     * @param string $followerCp
     * @return Quote
     */
    public function setFollowerCp($followerCp)
    {
        $this->followerCp = $followerCp;
    
        return $this;
    }

    /**
     * Get followerCp
     *
     * @return string 
     */
    public function getFollowerCp()
    {
        return $this->followerCp;
    }

    /**
     * Set doorCp
     *
     * @param string $doorCp
     * @return Quote
     */
    public function setDoorCp($doorCp)
    {
        $this->doorCp = $doorCp;
    
        return $this;
    }

    /**
     * Get doorCp
     *
     * @return string 
     */
    public function getDoorCp()
    {
        return $this->doorCp;
    }

    /**
     * Get state
     *
     * @return int
     */
    public function getState()
    {
    	$state = (sizeof($this->variants)  > 0) ? -1 : 0;
    	foreach ($this->variants as $variant)
    		if ($variant->getState() > $state)
    			$state = $variant->getState();
    	return $state;
    }

    /**
     * Set door
     *
     * @param JLM\ModelBundle\Entity\Door $door
     * @return Quote
     */
    public function setDoor(\JLM\ModelBundle\Entity\Door $door = null)
    {
        $this->door = $door;
    
        return $this;
    }

    /**
     * Get door
     *
     * @return JLM\ModelBundle\Entity\Door 
     */
    public function getDoor()
    {
        return $this->door;
    }

    /**
     * Set contact
     *
     * @param string $contact
     * @return Quote
     * @deprecated
     */
    public function setContact($contact)
    {
    	$this->contact = $contact;
    
    	return $this;
    }
    
    /**
     *
     * @return string
     * @deprecated
     */
    public function getContact()
    {
    	return $this->contact;
    }
    
    /**
     * Set contact
     *
     * @param string $contact
     * @return Quote
     */
    public function setContactPerson(PersonInterface $contact)
    {
    	$this->contactPerson = $contact;
    
    	return $this;
    }
    
    /**
     *
     * @return PersonInterface
     */
    public function getContactPerson()
    {
    	return $this->contactPerson;
    }
    
    /**
     * Set contactCp
     *
     * @param string $contactCp
     * @return Quote
     */
    public function setContactCp($contactCp)
    {
    	$this->contactCp = $contactCp;
    
    	return $this;
    }
    
    /**
     * Get contactCp
     *
     * @return string
     */
    public function getContactCp()
    {
    	return $this->contactCp;
    }


    
    /**
     * Add variant
     *
     * @param JLM\ModelBundle\Entity\QuoteVariant $variant
     * @return Quote
     */
    public function addVariant(\JLM\OfficeBundle\Entity\QuoteVariant $variant)
    {
    	$variant->setQuote($this);
    	$variant->setVariantNumber(sizeof($this->variants)+1);
    	$this->variants[] = $variant;
    		
    	return $this;
    }
    
    /**
     * Remove variant
     *
     * @param JLM\ModelBundle\Entity\QuoteVariant $variant
     */
    public function removeVariant(\JLM\OfficeBundle\Entity\QuoteVariant $variant)
    {
    	$variant->setQuote();
    	$this->variants->removeElement($variant);
    	$i = 0;
    	foreach ($this->variants as $v)
    		$v->setVariantNumber(++$i);
    }
    
    /**
     * Get variant
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getVariants()
    {
    	return $this->variants;
    }

    /**
     * Set ask
     *
     * @param \JLM\OfficeBundle\Entity\AskQuote $ask
     * @return Quote
     */
    public function setAsk(\JLM\OfficeBundle\Entity\AskQuote $ask = null)
    {
        $this->ask = $ask;
    
        return $this;
    }

    /**
     * Get ask
     *
     * @return \JLM\OfficeBundle\Entity\AskQuote 
     */
    public function getAsk()
    {
        return $this->ask;
    }
    
    /**
     * Creation depuis une demande de devis
     */
    public static function createFromAskQuote(AskQuote $askquote)
    {
    	$quote = new Quote();
    	$quote->setCreation(new \DateTime);
    	if (($door = $askquote->getDoor()) !== null)
    	{
    		$quote->setDoor($door);
    		$quote->setDoorCp($door->toString());
    		$quote->setVat($door->getSite()->getVat()->getRate());
    	}
    	else
    	{
    		$site = $askquote->getSite();
    		$quote->setDoorCp($site->toString());
    		$quote->setVat($site->getVat()->getRate());
    	}
    	$quote->setTrustee($trustee = $askquote->getTrustee());
    	$quote->setTrusteeName($trustee->getName());
    	$quote->setTrusteeAddress($trustee->getAddress().'');
    	$quote->setContact($askquote->getPerson());
    	$quote->setContactCp($askquote->getPerson().'');
    	$quote->setAsk($askquote);
    	return $quote;
    }
    
    /**
     * Generation du numéro de devis
     */
    public function generateNumber($lastnumber)
    {
    	$n = $lastnumber + 1;
    	$number = $this->getCreation()->format('ym');
    	for ($i = strlen($n); $i < 4 ; $i++)
    		$number.= '0';
    		$number.= $n;
    	$this->setNumber($number);
    	return $number;
    }
}
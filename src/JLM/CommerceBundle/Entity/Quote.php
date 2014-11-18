<?php

/*
 * This file is part of the JLMCommerceBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CommerceBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use JLM\CommerceBundle\Model\QuoteRecipientInterface;
use JLM\ModelBundle\Entity\Door;                // @todo Must be replaced by BusinessInterface
use JLM\OfficeBundle\Entity\AskQuote;           // @todo Must be removed
use JLM\CommerceBundle\Model\QuoteInterface;
use JLM\CommerceBundle\Model\QuoteVariantInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class Quote extends CommercialPart implements QuoteInterface
{
	/**
	 * @var int $id
	 */
	private $id;
	
	/**
	 * Suiveur (pour le suivi)
	 * @var string $follower
	 */
	private $follower;
	
	/**
	 * Suiveur (pour le devis)
	 * @var string $followerCp
	 */
	private $followerCp;
	
	/**
	 * Porte concernée (pour le suivi)
	 * @var Door $door
	 */
	private $door;
	
	/**
	 * Porte concernée (pour le devis)
	 * @var string $doorCp
	 */
	private $doorCp;
	
	/**
	 * @var JLM\ModelBundle\Entity\SiteContact $contact
	 */
	private $contact;
	
	/**
	 * @var JLM\ContactBundle\Model\PersonInterface $contactPerson
	 */
	private $contactPerson;
	
	/**
	 * @var string $contactCp
	 */
	private $contactCp;
	
	/**
	 * @var ArrayCollection $variants
	 */
	private $variants;
	
	/**
	 * Demande de devis liée
	 * @var AskQuote
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
     * @return self
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
     * @return self
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
     * @return self
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
    	{
    		if ($variant->getState() > $state)
    		{
    			$state = $variant->getState();
    		}
    	}
    	
    	return $state;
    }

    /**
     * Set door
     *
     * @param Door $door
     * @return self
     */
    public function setDoor(Door $door = null)
    {
        $this->door = $door;
    
        return $this;
    }

    /**
     * Get door
     *
     * @return Door 
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
     * @param QuoteRecipientInterface $contact
     * @return self
     * @deprecated Use setRecipient($recipient)
     */
    public function setContactPerson(QuoteRecipientInterface $contact)
    {
    	return $this->setRecipient($contact);
    }
    
    /**
     *
     * @return QuoteRecipientInterface
     * @deprecated Use getRecipient()
     */
    public function getContactPerson()
    {
    	return $this->getRecipient();
    }
    
    /**
     * Set recipient
     *
     * @param QuoteRecipientInterface $contact
     * @return self
     */
    public function setRecipient(QuoteRecipientInterface $recipient)
    {
        $this->contactPerson = $recipient;
    
        return $this;
    }
    
    /**
     * Get recipient
     * 
     * @return QuoteRecipientInterface
     */
    public function getRecipient()
    {
        return $this->contactPerson;
    }
    
    /**
     * Set contactCp
     *
     * @param string $contactCp
     * @return self
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
     * @param QuoteVariantInterface $variant
     * @return bool
     */
    public function addVariant(QuoteVariantInterface $variant)
    {
    	$variant->setQuote($this);
    	$variant->setVariantNumber(sizeof($this->variants)+1);
    	$this->variants[] = $variant;
    		
    	return true;
    }
    
    /**
     * Remove variant
     *
     * @param QuoteVariantInterface $variant
     * @return bool
     */
    public function removeVariant(QuoteVariantInterface $variant)
    {
    	$variant->setQuote();
    	$return = $this->variants->removeElement($variant);
    	$i = 0;
    	foreach ($this->variants as $v)
    	{
    		$v->setVariantNumber(++$i);
    	}
    	
    	return $return;
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
     * @param AskQuote $ask
     * @return self
     */
    public function setAsk(AskQuote $ask = null)
    {
        $this->ask = $ask;
    
        return $this;
    }

    /**
     * Get ask
     *
     * @return AskQuote 
     */
    public function getAsk()
    {
        return $this->ask;
    }
    
    /**
     * Creation depuis une demande de devis
     * @todo Create a builder
     */
    public static function createFromAskQuote(AskQuote $askquote)
    {
    	$quote = new self();
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
     * @todo Create a service
     */
    public function generateNumber($lastnumber)
    {
    	$n = $lastnumber + 1;
    	$number = $this->getCreation()->format('ym');
    	for ($i = strlen($n); $i < 4 ; $i++)
    	{
    		$number.= '0';
    	}
    	$number.= $n;
    	$this->setNumber($number);
    	
    	return $number;
    }
}
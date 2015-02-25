<?php
namespace JLM\DailyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JLM\OfficeBundle\Entity\Order;
use JLM\CommerceBundle\Model\QuoteVariantInterface;
use JLM\DailyBundle\Model\WorkInterface;

/**
 * Plannification de travaux
 * JLM\DailyBundle\Entity\Work
 */
class Work extends Intervention implements WorkInterface
{
	/**
	 * Devis source (pour "selon devis...")
	 * @Assert\Valid
	 */
	private $quote;
	
	/**
	 * Work category
	 * @Assert\Valid
	 * @Assert\NotNull
	 */
	private $category;
	
	/**
	 * Work objective
	 * @Assert\Valid
	 * @Assert\NotNull
	 */
	private $objective;
	
	/**
	 * Fiche travaux
	 * @Assert\Valid
	 */
	private $order;
	
	/**
	 * Intervention source
	 * @ORM\OneToOne(targetEntity="Intervention", mappedBy="work")
	 */
	private $intervention;
	
	/**
	 * Get work category
	 * @return WorkCategory
	 */
	public function getCategory()
	{
		return $this->category;
	}
	
	/**
	 * Set work category
	 *
	 * @param WorkCategory $category
	 * @return self
	 */
	public function setCategory(WorkCategory $category = null)
	{
		$this->category = $category;
		
		return $this;
	}
	
	/**
	 * Get work objective
	 * @return WorkObjective
	 */
	public function getObjective()
	{
		return $this->objective;
	}
	
	/**
	 * Set work objective
	 *
	 * @param WorkObjective $objective
	 * @return self
	 */
	public function setObjective(WorkObjective $objective = null)
	{
		$this->objective = $objective;
		
		return $this;
	}
	
	/**
	 * Get Type
	 * @see Shifting
	 * @return string
	 */
	public function getType()
	{
		return 'work';
	}

    /**
     * Set order
     *
     * @param \JLM\OfficeBundle\Entity\Order $order
     * @return Work
     */
    public function setOrder(\JLM\OfficeBundle\Entity\Order $order = null)
    {
        $this->order = $order;
    
        return $this;
    }

    /**
     * Get order
     *
     * @return \JLM\OfficeBundle\Entity\Order 
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set quote
     *
     * @param QuoteVariantInterface $quote
     * @return Work
     */
    public function setQuote(QuoteVariantInterface $quote = null)
    {
        $this->quote = $quote;
    
        return $this;
    }

    /**
     * Get quote
     *
     * @return QuoteVariantInterface
     */
    public function getQuote()
    {
        return $this->quote;
    }

    /**
     * Set intervention
     *
     * @param \JLM\DailyBundle\Entity\Intervention $intervention
     * @return Work
     */
    public function setIntervention(\JLM\DailyBundle\Entity\Intervention $intervention = null)
    {
        $this->intervention = $intervention;
    
        return $this;
    }

    /**
     * Get intervention
     *
     * @return \JLM\DailyBundle\Entity\Intervention 
     */
    public function getIntervention()
    {
        return $this->intervention;
    }
    
    /**
     * Populate from intervention
     * 
     * @param Intervention $interv
     * @return void
     */
    public function populateFromIntervention(Intervention $interv)
    {
    	$this->setCreation(new \DateTime);
    	$this->setPlace($interv->getPlace());
    	$this->setReason($interv->getRest());
    	$this->setDoor($interv->getDoor());
    	$this->setContactName($interv->getContactName());
    	$this->setContactPhones($interv->getContactPhones());
    	$this->setContactEmail($interv->getContactEmail());
    	$this->setPriority(3);
    	$this->setContract($interv->getDoor()->getActualContract().'');
    	$this->setIntervention($interv);
    }
    
    public static function createFromIntervention(Intervention $interv)
    {
    	$work = new Work;
    	$work->populateFromIntervention($interv);
    	return $work;
    }
    
    /**
     * Populate from QuoteVariant
     * @param QuoteVariant $variant
     * @return void
     */
    public function populateFromQuoteVariant(QuoteVariantInterface $variant)
    {
    	$quote = $variant->getQuote();
    	$this->setCreation(new \DateTime);
    	$this->setDoor($quote->getDoor());
    	$this->setPlace($quote->getDoor().'');
    	if ($quote->getAsk() !== null)
    		$this->setReason($quote->getAsk()->getAsk());
    	$this->setContactName($quote->getContactCp());
    	if ($quote->getContact())
    		$this->setContactPhones(
    				$quote->getContact()->getPerson()->getFixedPhone().chr(10)
    				.$quote->getContact()->getPerson()->getMobilePhone()
    		);
    	$this->setPriority(3);
    	$this->setContract($quote->getDoor()->getActualContract().'');
    	$this->setQuote($variant);
    	
    	if ($this->getReason() === null)
    		$this->setReason($variant->getIntro());	
    }
    
    /**
     * Create from QuoteVariant
     * 
     * @param QuoteVariant $variant
     * @return \JLM\DailyBundle\Entity\Work
     */
    public static function createFromQuoteVariant(QuoteVariantInterface $variant)
    {
    	$work = new Work;
    	$work->populateFromQuoteVariant($variant);
    	return $work;
    }
}
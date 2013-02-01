<?php
namespace JLM\OfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * 
 * @author kwizer
 * @ORM\Table(name="fees_follower")
 * @ORM\Entity
 */
class FeesFollower
{
	/**
	 * @var DateTime
	 * @ORM\Column(name="activation", type="datetime")
	 * @ORM\Id
	 */
	private $activation;
	
	/**
	 * @var DateTime
	 * @ORM\Column(name="generation", type="datetime", nullable=true)
	 */
	private $generation = null;
	
	/**
	 * Augmentation annuelle (1)
	 * @var float
	 * @ORM\Column(name="frequence1", type="decimal", scale=3, precision=3, nullable=true)
	 */
	private $frequence1;
	
	/**
	 * Augmntation semestrielle (2)
	 * @var float
	 * @ORM\Column(name="frequence2", type="decimal", scale=3, precision=3, nullable=true)
	 */
	private $frequence2;
	
	/**
	 * Augmntation trimestrielle (4)
	 * @var float
	 * @ORM\Column(name="frequence4", type="decimal", scale=3, precision=3, nullable=true)
	 */
	private $frequence4;
	

    /**
     * Set activation
     *
     * @param \DateTime $activation
     * @return FeesFollower
     */
    public function setActivation($activation)
    {
        $this->activation = $activation;
    
        return $this;
    }

    /**
     * Get activation
     *
     * @return \DateTime 
     */
    public function getActivation()
    {
        return $this->activation;
    }

    /**
     * Set generation
     *
     * @param \DateTime $generation
     * @return FeesFollower
     */
    public function setGeneration($generation)
    {
        $this->generation = $generation;
    
        return $this;
    }

    /**
     * Get generation
     *
     * @return \DateTime 
     */
    public function getGeneration()
    {
        return $this->generation;
    }

    /**
     * Set frequence1
     *
     * @param float $frequence1
     * @return FeesFollower
     */
    public function setFrequence1($frequence1)
    {
        $this->frequence1 = $frequence1;
    
        return $this;
    }

    /**
     * Get frequence1
     *
     * @return float 
     */
    public function getFrequence1()
    {
        return $this->frequence1;
    }

    /**
     * Set frequence2
     *
     * @param float $frequence2
     * @return FeesFollower
     */
    public function setFrequence2($frequence2)
    {
        $this->frequence2 = $frequence2;
    
        return $this;
    }

    /**
     * Get frequence2
     *
     * @return float 
     */
    public function getFrequence2()
    {
        return $this->frequence2;
    }

    /**
     * Set frequence4
     *
     * @param float $frequence4
     * @return FeesFollower
     */
    public function setFrequence4($frequence4)
    {
        $this->frequence4 = $frequence4;
    
        return $this;
    }

    /**
     * Get frequence4
     *
     * @return float 
     */
    public function getFrequence4()
    {
        return $this->frequence4;
    }
    
    /**
     * Get frequence
     * 
     * @return float
     */
    public function getFrequence($frequence)
    {
    	switch ($frenquence)
    	{
    		case 1:
    			return $this->getFrequence1();
    			break;
    		case 4:
    			return $this->getFrequence4();
    			break;
    		default:
    			return $this->getFrequence2();
    	}
    	return null;
    }
}
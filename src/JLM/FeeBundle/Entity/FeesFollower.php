<?php

/*
 * This file is part of the JLMFeeBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\FeeBundle\Entity;

use JLM\FeeBundle\Model\FeesFollowerInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class FeesFollower implements FeesFollowerInterface
{
	/**
	 * @var int $id
	 */
	private $id;
	
	/**
	 * @var DateTime
	 */
	private $activation;
	
	/**
	 * @var DateTime
	 */
	private $generation = null;
	
	/**
	 * Augmentation annuelle (1)
	 * @var float
	 */
	private $frequence1;
	
	/**
	 * Augmentation semestrielle (2)
	 * @var float
	 */
	private $frequence2;
	
	/**
	 * Augmentation trimestrielle (4)
	 * @var float
	 */
	private $frequence4;
	
	/**
	 * Get Id
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

    /**
     * {@inheritdoc}
     */
    public function setActivation(\DateTime $activation = null)
    {
        $this->activation = $activation;
    
        return $this;
    }

    /**
     * {@inheritdoc}
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
    public function setGeneration(\DateTime $generation)
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
    	switch ($frequence)
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
    
    /**
     * {@inheritdoc}
     */
    public function isActive()
    {
    	$today = new \DateTime();
    	if ($today > $this->getActivation())
    	{
    		return true;
    	}
    	return false;
    }
}

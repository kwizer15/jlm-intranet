<?php

namespace JLM\TransmitterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JLM\TransmitterBundle\Model\TransmitterInterface;
use JLM\TransmitterBundle\Model\AttributionInterface;

/**
 * Transmitter
 *
 * @ORM\Table(name="transmitters_transmitters")
 * @ORM\Entity(repositoryClass="JLM\TransmitterBundle\Entity\TransmitterRepository")
 */
class Transmitter implements TransmitterInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="number", type="string", length=6)
     */
    private $number = null;

    /**
     * @var string
     *
     * @ORM\Column(name="guarantee", type="string",length=4)
 	 * @Assert\Regex(pattern="/^(0[1-9]|1[0-2])[0-9][0-9]$/", message="Garantie au mauvais format")
     */
    private $guarantee = null;

    /**
     * @var string
     *
     * @ORM\Column(name="userName", type="string", length=255, nullable=true)
     */
    private $userName;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isActive", type="boolean")
     */
    private $isActive = true;

    /**
     * @var Attribution
     *
     * @ORM\ManyToOne(targetEntity="Attribution", inversedBy="transmitters")
     */
    private $attribution;
    
    /**
     * @var UserGroup
     *
     * @ORM\ManyToOne(targetEntity="UserGroup")
     */
    private $userGroup;
    
    /**
     * @var Model
     * 
     * @ORM\ManyToOne(targetEntity="Model")
     */
    private $model;
    
    /**
     * $this remplace $replacedTransmitter 
     * @var Tranmitter replacedTransmitter
     *
     * @ORM\OneToOne(targetEntity="Transmitter", inversedBy="replace")
     */
    private $replacedTransmitter;
    
    /**
     * $replace replace $this
     * @var Tranmitter replace
     *
     * @ORM\OneToOne(targetEntity="Transmitter",mappedBy="replacedTransmitter")
     */
    private $replace;
    
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
     * Set number
     *
     * @param integer $number
     * @return Transmitter
     */
    public function setNumber($number)
    {
    	while (strlen($number) < 6)
    		$number = '0'.$number;
        $this->number = $number;
    
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getNumber()
    {
    	return $this->number;
    }

    /**
     * Set guarantee
     *
     * @param integer $guarantee
     * @return Transmitter
     */
    public function setGuarantee($guarantee)
    {
    	while (strlen($guarantee) < 4)
    		$guarantee = '0'.$guarantee;
        $this->guarantee = $guarantee;
    
        return $this;
    }

    /**
     * {@inheritdoc} 
     */
    public function getGuarantee()
    {
    	return $this->guarantee;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getGuaranteeDate()
    {
    	return \DateTime::createFromFormat('my',$this->getGuarantee());
    }
    
    /**
     * {@inheritdoc}
     */
    public function getEndGuarantee()
    {
    	$number = $this->guarantee + 2;
    	while (strlen($number) < 4)
    		$number = '0'.$number;
    	return $number;
    }

    /**
     * {@inheritdoc}
     */
    public function getEndGuaranteeDate()
    {
    	return \DateTime::createFromFormat('my',$this->getEndGuarantee());
    }
    
    /**
     * Set suffix
     *
     * @param integer $suffix
     * @return Transmitter
     */
    public function setSuffix($suffix)
    {
        $this->suffix = $suffix;
    
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSuffix()
    {
        return $this->suffix;
    }

    /**
     * Set userName
     *
     * @param string $userName
     * @return Transmitter
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
    
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Transmitter
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set attribution
     *
     * @param AttributionInterface $attribution
     * @return Transmitter
     */
    public function setAttribution(AttributionInterface $attribution = null)
    {
        $this->attribution = $attribution;
    
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAttribution()
    {
        return $this->attribution;
    }

    /**
     * Set userGroup
     *
     * @param \JLM\TransmitterBundle\Entity\UserGroup $userGroup
     * @return Transmitter
     */
    public function setUserGroup(\JLM\TransmitterBundle\Entity\UserGroup $userGroup = null)
    {
        $this->userGroup = $userGroup;
    
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUserGroup()
    {
        return $this->userGroup;
    }

    /**
     * Set model
     *
     * @param \JLM\TransmitterBundle\Entity\Model $model
     * @return Transmitter
     */
    public function setModel(\JLM\TransmitterBundle\Entity\Model $model = null)
    {
    	$this->model = $model;
    
    	return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getModel()
    {
    	return $this->model;
    }
    
    /**
     * {@inheritdoc}
     * @Assert\True(message="La date de début de garantie doit se situer AVANT ou PENDANT le mois en cours")
     */
    public function isGuaranteeValid()
    {
    	$today = new \DateTime;
    	$gar = $this->getGuaranteeDate();
    	if ($gar <= $today)
    		return true;
    	return false;
    }
    
    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
    	return $this->getNumber();
    }

    /**
     * Set replacedTransmitter
     *
     * @param \JLM\TransmitterBundle\Entity\Transmitter $replacedTransmitter
     * @return Transmitter
     */
    public function setReplacedTransmitter(TransmitterInterface $replacedTransmitter = null)
    {
        $this->replacedTransmitter = $replacedTransmitter;
        $this->replacedTransmitter->setReplace($this);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getReplacedTransmitter()
    {
        return $this->replacedTransmitter;
    }

    /**
     * Set replace
     *
     * @param \JLM\TransmitterBundle\Entity\Transmitter $replace
     * @return Transmitter
     */
    public function setReplace(TransmitterInterface $replace = null)
    {
        $this->replace = $replace;
    
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getReplace()
    {
        return $this->replace;
    }
}
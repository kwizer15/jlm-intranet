<?php

namespace JLM\ContactBundle\Entity;

use JLM\ContactBundle\Model\AddressInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use JLM\ContactBundle\Model\CityInterface;

/**
 * JLM\ContactBundle\Entity\Address
 *
 * @ORM\Table(name="addresses")
 * @ORM\Entity
 */
class Address implements AddressInterface
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
     * @var string $street
     *
     * @ORM\Column(name="street", type="text", nullable=true)
     * @Assert\Type(type="string")
     */
    private $street;
    
    /**
     * @var string $city
     *
     * @ORM\ManyToOne(targetEntity="CityInterface")
     * @Assert\NotNull
     * @Assert\Valid
     */
    private $city;
    
    /**
     * Constructor
     * @param string $street
     * @param CityInterface|string $city
     * @param string $zip
     */
    public function __construct($street = null, CityInterface $city = null)
    {
    	$this->setStreet($street);
    	$this->setCity($city);
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
     * Set street
     *
     * @param string $street
     * @return self
     */
    public function setStreet($street)
    {
        $this->street = (string)$street;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set city
     *
     * @param CityInterface $city
     * @return self
     */
    public function setCity(CityInterface $city = null)
    {
        $this->city = $city;
    	return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getCity()
    {
    	return (string)$this->city->getName();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getZip()
    {
    	return (string)$this->city->getZip();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getCountry()
    {
    	return (string)$this->city->getCountry();
    }
    
    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
    	return ($this->getStreet() == '') ? (string)$this->city : $this->getStreet().chr(10).$this->city;
    }
}
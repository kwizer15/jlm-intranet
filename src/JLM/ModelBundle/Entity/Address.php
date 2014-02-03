<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use JLM\ContactBundle\Model\AddressInterface;
use JLM\ContactBundle\Model\CityInterface;

/**
 * JLM\ModelBundle\Entity\Address
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
    private $street = '';
    
    /**
     * @var JLM\ContactBundle\Model\CityInterface $city
     *
     * @ORM\ManyToOne(targetEntity="JLM\ContactBundle\Model\CityInterface")
     * @Assert\NotNull
     * @Assert\Valid
     */
    private $city;
    
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
     * @param JLM\ContactBundle\Model\CityInterface $city
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
        return $this->city;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getZip()
    {
    	return $this->city->getZip();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getCountry()
    {
    	return $this->city->getCountry();
    }
    
    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
    	return ($this->getStreet() == '') ? (string)$this->getCity() : $this->getStreet().chr(10).$this->getCity();
    }
    
    /**
     * To String
     */
    public function toString()
    {
    	return $this->getStreet().chr(10).$this->getCity()->toString();
    }
}
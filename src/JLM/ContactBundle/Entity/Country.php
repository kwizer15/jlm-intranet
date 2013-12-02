<?php

namespace JLM\ContactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JLM\ContactBundle\Entity\CountryException;

/**
 * JLM\ContactBundle\Entity\Country
 *
 * @ORM\Table(name="countries")
 * @ORM\Entity(readOnly=true)
 * @UniqueEntity("code")
 */
class Country implements CountryInterface
{
    /**
     * @var string $code
     *
     * @ORM\Column(name="code", type="string", length=2)
     * @ORM\Id
     * @Assert\Type(type="string")
     * @Assert\Length(min=2,max=2)
     * @Assert\NotBlank
     */
    private $code;
    
    /**
     * @var string $name
     * 
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    
    /**
     * {@inheritdoc}
     */
    public function __construct($code, $name)
    {
    	$this->setCode($code);
    	$this->setName($name);
    }
    
    /**
     * {@inheritdoc}
     * @throws CountryException
     */
    public function setCode($code)
    {
    	// Filtrage
    	$code = strtoupper(substr(trim($code),0,2));
    	if (!preg_match('#^[A-Z]{2}$#',$code))
    		throw new CountryException('Code pays incorrect');
    	$this->code = $code;
    	return $this;
    }

    /**
	 * {@inheritdoc}
     */
    public function getCode()
    {
        return $this->code;
    }
    
    /**
	 * {@inheritdoc}
     */
    public function setName($name)
    {
    	$name = ucwords(strtolower(trim($name)));
    	if (!preg_match('#^[ \-A-z]+$#',$name))
    		throw new CountryException('Country name invalid');
    	$this->name = $name;
    	return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
    	return $this->name;
    }
    
    /**
     * {@inheritdoc}
     */
     public function __toString()
     {
     	return $this->getName();
     }
}
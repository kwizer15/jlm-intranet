<?php

namespace JLM\ContactBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use JLM\ContactBundle\Model\CountryInterface;

class CountryException extends \Exception {}

/**
 * JLM\ContactBundle\Entity\Country
 */
class Country implements CountryInterface
{
    /**
     * @var string $code
     * 
     * @Assert\Type(type="string")
     * @Assert\Length(min=2,max=2)
     * @Assert\NotNull
     */
    private $code;
    
    /**
     * @var string $name
     * 
     * @Assert\Type(type="string")
     * @Assert\Length(min=1)
     * @Assert\NotNull
     */
    private $name;
    
    /**
     * {@inheritdoc}
     */
    public function __construct($code = null, $name = null)
    {
    	if ($code !== null)
    		$this->setCode($code);
    	if ($name !== null)
    		$this->setName($name);
    }
    
    /**
     * {@inheritdoc}
     */
    public function setCode($code)
    {
    	// Filtrage
    	$code = strtoupper(substr(trim($code),0,2));
    	$this->code = (preg_match('#^[A-Z]{2}$#',$code)) ? $code : null;
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
    	$this->name = (preg_match('#^[ \-A-z]+$#',$name)) ? $name : null;
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
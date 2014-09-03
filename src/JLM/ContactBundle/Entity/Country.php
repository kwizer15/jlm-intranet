<?php

namespace JLM\ModelBundle\Entity;

use JLM\ContactBundle\Model\CountryInterface;

/**
 * JLM\ContactBundle\Entity\Country
 *
 * @UniqueEntity("code")
 */
class Country implements CountryInterface
{
    /**
     * @var string
     */
    private $code;
    
    /**
     * @var string
     */
    private $name = '';
    
    /**
     * Set code
     *
     * @param string $code
     * @throws CountryException
     * @return self
     */
    public function setCode($code)
    {
    	$code = strtoupper(substr(trim($code),0,2));
    	if (!preg_match('#^[A-Z]{2}$#',$code))
    		throw new \Exception('Code pays incorrect');
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
    public function getName()
    {
        return $this->name;
    } 

    /**
     * Set name
     *
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $name = str_replace(array('0','1','2','3','4','5','6','7','8','9'),'',$name);
        $name = ucwords(strtolower($name));
        $this->name = $name;
        
        return $this;
    }
    
    /**
     * To String
     */
    public function __toString()
    {
        return $this->getName();
    }
}
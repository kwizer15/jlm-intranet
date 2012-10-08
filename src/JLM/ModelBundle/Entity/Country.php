<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JLM\ModelBundle\Entity\Country
 *
 * @ORM\Table(name="countries")
 * @ORM\Entity
 */
class Country
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="code", type="string", length=2)
     * @ORM\Id
     */
    private $code;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var integer $phonePrefix
     * 
     * @ORM\Column(name="phone_prefix", type="integer")
     */
    private $phonePrefix;
    
    
    /**
     * Get code
     *
     * @return integer
     */
    public function getCode()
    {
    	return $this->code;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Get phonePrefix
     * 
     * @return integer
     */
    public function getPhonePrefix()
    {
    	return $this->phonePrefix;
    }

    /**
     * Set code
     *
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Set phonePrefix
     *
     * @param integer $phonePrefix
     */
    public function setPhonePrefix($phonePrefix)
    {
        $this->phonePrefix = $phonePrefix;
    }
}
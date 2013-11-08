<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * JLM\ModelBundle\Entity\Country
 *
 * @ORM\Table(name="countries")
 * @ORM\Entity(readOnly=true)
 * @UniqueEntity("code")
 */
class Country extends StringModel
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
     * Set code
     *
     * @param string $code
     */
    public function setCode($code)
    {
    	$code = strtoupper(substr($code,0,2));
    	$this->code = (preg_match('#^[A-Z]{2}$#',$code)) ? $code : null;
    	return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }
    
    /**
     * @return self
     */
    public function setName($name)
    {
    	$name = str_replace(array('0','1','2','3','4','5','6','7','8','9'),'',$name);
    	$name = ucwords(strtolower($name));
    	return parent::setName($name);
    }
}
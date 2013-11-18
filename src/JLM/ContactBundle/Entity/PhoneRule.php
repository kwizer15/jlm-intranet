<?php

namespace JLM\ContactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JLM\ContactBundle\Entity\Country;
use JLM\ContactBundle\Entity\PhoneRuleException;

/**
 * PhoneRule
 *
 * @ORM\Table(name="phone_rules")
 * @ORM\Entity
 */
class PhoneRule
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
     * @var Country
     * 
     * @ORM\OneToOne(targetEntity="Country")
     */
    private $country = null;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="integer")
     */
    private $code = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="local_code", type="integer", nullable=true)
     */
    private $localCode = null;

    /**
     * @var string
     *
     * @ORM\Column(name="format", type="string", length=255)
     */
    private $format = null;

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
     * Set code
     *
     * @param int $code
     * @return PhoneRule
     */
    public function setCode($code)
    {
    	if (!is_integer($code))
    		throw new PhoneRuleException('Telephone international code invalid');
    	if ($code < 0 || $code > 9999 || !is_integer($code))
    		throw new PhoneRuleException('Telephone international code "'.$code.'" invalid');
        $this->code = (int)$code;
    
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
     * Set localCode
     *
     * @param int $localCode
     * @return PhoneRule
     */
    public function setLocalCode($localCode)
    {
    	if (!is_integer($localCode))
    		throw new PhoneRuleException('Telephone international code invalid');
    	if ($localCode < 0 || $localCode > 9999)
    		throw new PhoneRuleException('Telephone local code "'.$localCode.'" invalid');
        $this->localCode = (int)$localCode;
    
        return $this;
    }

    /**
     * Get localCode
     *
     * @return integer 
     */
    public function getLocalCode()
    {
        return $this->localCode;
    }

    /**
     * Set format
     *
     * @param string $format
     * @return PhoneRule
     */
    public function setFormat($format)
    {
    	if (!is_string($format))
    		throw new PhoneRuleException('Phone format invalid');
    	$format = strtoupper(trim($format));
    	if (!preg_match('#^[ \-ILN0-9]+$#',$format))
    		throw new PhoneRuleException('Phone format invalid');
    	$countI = 0;
    	$countLN = 0;
    	for ($i = 0; $i < strlen($format); $i++)
    	{
    		switch ($format[$i])
    		{
    			case 'I':
    				$countI++;
    				break;
    			case 'L' :
    			case 'N' :
    				$countLN++;
    				break;
    		}
    	}
    	if ($countI != 1 || $countLN < 1)
    		throw new PhoneRuleException('Phone format invalid');
        $this->format = (string)$format;
    
        return $this;
    }

    /**
     * Get format
     *
     * @return string 
     */
    public function getFormat()
    {
        return $this->format;
    }
    
    /**
     * Get regex to test format
     *
     * @return string
     */
    public function getRegex()
    {
    	$format = $this->getFormat();
    	$format = str_replace(' ',' ?',$format);
    	$format = str_replace('-','-?',$format);
    	$format = str_replace('N','[0-9]',$format);
    	$format = str_replace('L','[A-Z]',$format);
    	if ($this->getLocalCode() === null)
    		$format = str_replace('I','(00'.$this->getCode().'|\+'.$this->getCode().')?',$format);
    	else
    		$format = str_replace('I','('.$this->getLocalCode().'|00'.$this->getCode().'|\+'.$this->getCode().')',$format);
    	return '#^'.$format.'$#';
    }

    /**
     * Set country
     *
     * @param Country $country
     * @return PhoneRule
     */
    public function setCountry(Country $country = null)
    {
        $this->country = $country;
    
        return $this;
    }

    /**
     * Get country
     *
     * @return Country 
     */
    public function getCountry()
    {
        return $this->country;
    }
}
<?php

namespace JLM\ContactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use JLM\ContactBundle\Model\PhoneRuleInterface;
use JLM\ContactBundle\Model\CountryInterface;

class PhoneRuleException extends \Exception {}

/**
 * PhoneRule
 *
 * @ORM\Table(name="phone_rules")
 * @ORM\Entity
 */
class PhoneRule implements PhoneRuleInterface
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
     * @ORM\OneToOne(targetEntity="CountryInterface")
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
     * {@inheritdoc}
     */
    public function __construct($format, $code, $localCode = null, CountryInterface $country = null)
    {
    	$this->setFormat($format);
    	$this->setCode($code);
    	$this->setLocalCode($localCode);
    	$this->setCountry($country);
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
     * Set code
     *
     * @param int $code
     * @return self
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
     * {@inheritdoc}
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set localCode
     *
     * @param int $localCode
     * @return self
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
     * {@inheritdoc}
     */
    public function getLocalCode()
    {
        return $this->localCode;
    }

    /**
     * Set format
     *
     * @param string $format
     * @return self
     */
    public function setFormat($format)
    {
    	if (!is_string($format))
    		throw new PhoneRuleException('Phone format invalid');
    	$format = strtoupper(trim($format));
    	while (substr_count($format,'  '))
			$format = str_replace('  ',' ',$format);
    	if (!preg_match('#^I[ \-\./,LN]+$#',$format))
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
     * {@inheritdoc}
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
    	$regex = '';
    	for ($i = 0; $i < strlen($format); $i++)
    	{
    		switch ($format[$i])
    		{
    			case 'N' :
    				$regex .= '[ \-\.,/]?[0-9]';
    				break;
    			case 'L' :
    				$regex .= '[ \-\.,/]?[A-Z]';
    				break;
    			case 'I' :
    				$regex .= ($this->getLocalCode() === null)
    						? '(00'.$this->getCode().'|\+'.$this->getCode().')?'
    						: '('.$this->getLocalCode().'|00'.$this->getCode().'|\+'.$this->getCode().')'; 
    				break;
    		}
    	}
    	return '#^'.$regex.'$#';
    }

    /**
     * Set country
     *
     * @param Country $country
     * @return self
     */
    public function setCountry(CountryInterface $country = null)
    {
        $this->country = $country;
    
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCountry()
    {
        return $this->country;
    }
    
    /**
     * {@inheritdoc}
     */
    public function isValid($number)
    {
    	return (bool)preg_match($this->getRegEx(),$number);
    }
}
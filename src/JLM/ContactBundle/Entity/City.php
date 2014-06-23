<?php

namespace JLM\ContactBundle\Entity;

use JLM\ContactBundle\Model\CityInterface;
use Symfony\Component\Validator\Constraints as Assert;
use JLM\ContactBundle\Model\CountryInterface;

/**
 * JLM\ContactBundle\Entity\City
 */
class City implements CityInterface
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $zips
     * @Assert\Type(type="string")
     * @Assert\Length(min=4,max=20)
     * @Assert\NotNull
     */
    private $zip = '';
    
    /**
     * @var CountryInterface $country
     * @Assert\NotNull
     * @Assert\Valid
     */
    private $country;
    
    /**
     * @var string $name
     * 
     * @ORM\Column(name="name", type="string")
     */
    private $name;
    
    /**
     * {@inheritdoc}
     */
    public function __construct($name, $zip, CountryInterface $country)
    {
    	$this->setName($name);
    	$this->setZip($zip);
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
     * {@inheritdoc}
     */
    public function setName($name)
    {
    	$name = str_replace('-','- ',$name);
    	$name = ucwords(strtolower($name));
    	$name = str_replace('- ','-',$name);
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
    public function setZip($zip)
    {
    	$zip = strtoupper($zip);
    	$this->zip = (preg_match('#[0-9A-Z\-]#',$zip)) ? $zip : '';
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * {@inheritdoc}
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
    public function __toString()
    {
    	$out =  '';
    		$out .= $this->getZip();
    	if ($this->getZip() && $this->getName())
    		$out .= ' - ';
    	$out .= $this->getName();
    	
    	return $out;
    }
    
    /**
     * To string upper
     * @return string
     */
    public function toString()
    {
	  	$name = $this->getName();
	    $zip = substr($this->getZip(),0,5);
	    $cedex = str_replace($zip,'',$this->getZip());
	    if (substr($name,0,5) == 'Paris')
	    	$name = 'Paris';
	    $name = strtoupper($name.$cedex);
	    $replace = array('à'=>'À','é'=>'É','è'=>'È','ê'=>'Ê','ô'=>'Ô','û'=>'Û');
	    foreach ($replace as $before => $after)
	    	$name = str_replace($before,$after,$name);
	    $out =  $zip;
	    if ($zip && $name)
	    	$out .= ' - ';
	    $out .= $name;
	     
	    return $out;

    }
}
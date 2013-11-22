<?php

namespace JLM\ContactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

use JLM\ContactBundle\Entity\Country;

/**
 * JLM\ContactBundle\Entity\City
 *
 * @ORM\Table(name="cities")
 * @ORM\Entity(repositoryClass="JLM\ContactBundle\Entity\CityRepository", readOnly=true)
 */
class City extends \JLM\DefaultBundle\Entity\AbstractNamed
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
     * @var string $zips
     * 
     * @ORM\Column(name="zip",type="string",length=20)
     * @Assert\Type(type="string")
     * @Assert\Length(min=4,max=20)
     * @Assert\NotNull
     */
    private $zip = '';
    
    /**
     * @var Country $country
     * 
     * @ORM\ManyToOne(targetEntity="Country")
     * @ORM\JoinColumn(name="country_code", referencedColumnName="code")
     * @Assert\NotNull
     * @Assert\Valid
     */
    private $country;
    
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
     * Set name
     *
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
    	$name = str_replace('-','- ',$name);
    	$name = ucwords(strtolower($name));
    	$name = str_replace('- ','-',$name);
    	return parent::setName($name);
    }

    /**
     * Set zip
     *
     * @param string $zip
     */
    public function setZip($zip)
    {
    	$zip = strtoupper($zip);
    	$this->zip = (preg_match('#[0-9A-Z\-]#',$zip)) ? $zip : '';
        return $this;
    }

    /**
     * Get zip
     *
     * @return string 
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Set country
     *
     * @param Country $country
     * @return self
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
    
    /**
     * To String
     */
    public function __toString()
    {
    	$out =  '';
    	if ($this->getZip() != '')
    		$out = $this->getZip().' - ';
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
	    $out =  '';
	    if ($zip != '')
	    	$out = $zip.' - ';
	    $out .= $name;
	     
	    return $out;

    }
}
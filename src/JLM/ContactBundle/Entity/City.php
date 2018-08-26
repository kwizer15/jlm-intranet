<?php

/*
 * This file is part of the JLMContactBundle package.
*
* (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace JLM\ContactBundle\Entity;

use JLM\ContactBundle\Model\CityInterface;
use JLM\ContactBundle\Model\CountryInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class City implements CityInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name = '';
    
    /**
     * @var string
     */
    protected $zip = '';
    
    /**
     * @var CountryInterface
     */
    protected $country;
    
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
        $name = str_replace('-', '- ', $name);
        $name = ucwords(strtolower($name));
        $name = str_replace('- ', '-', $name);
        $this->name = $name;
        
        return $this;
    }

    /**
     * Set zip
     *
     * @param string $zip
     * @return self
     */
    public function setZip($zip)
    {
        $zip = strtoupper($zip);
        $this->zip = (preg_match('#[0-9A-Z\-]#', $zip)) ? $zip : '';
        
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
     * Set country
     *
     * @param JLM\ContactBundle\Model\CountryInterface $country
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
    public function __toString()
    {
        $out =  '';
        $out = $this->getZip();
        $out = ($out != '') ? $out.' - ' : '';
        
        return $out.$this->getName();
    }
    
    /**
     * Alternative to string
     * @deprecated
     * @return string
     */
    public function toString()
    {
        $name = $this->getName();
        $zip = substr($this->getZip(), 0, 5);
        $cedex = str_replace($zip, '', $this->getZip());
        if (substr($name, 0, 5) == 'Paris') {
            $name = 'Paris';
        }
        $name = strtoupper($name.$cedex);
        $replace = ['à'=>'À','é'=>'É','è'=>'È','ê'=>'Ê','ô'=>'Ô','û'=>'Û'];
        foreach ($replace as $before => $after) {
            $name = str_replace($before, $after, $name);
        }
        
        return $zip.' - '.$name;
    }
}

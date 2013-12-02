<?php

namespace JLM\ContactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use JLM\ContactBundle\Entity\Contact;

class PersonException extends \Exception {}

/**
 * Person
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Person extends Contact
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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=4)
     */
    private $title = '';

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=255)
     */
    private $firstName = '';

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255)
     */
    private $lastName = '';


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
     * Set title
     *
     * @param string $title
     * @return Person
     */
    public function setTitle($title)
    {
    	$title = ucfirst(strtolower(trim($title)));
    	if (!in_array($title,array('','M.','Mlle','Mme')))
    		throw new PersonException('Title must be only "", "M.", "Mme" or "Mlle"');
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }


    /**
     * Filtre pour nom et prénom
     * @param string $name
     * @throws PersonException
     * @return string
     */
    private function filterName($name)
    {
    	$name = trim($name);
    	$name = str_replace('-','- ',$name);
    	$name = strtolower($name);
    	$specialchars = array(
    		'À'=>'à',
    		'Â'=>'â',
    		'Ç'=>'ç',
    		'É'=>'é',
    		'È'=>'è',
    		'Ê'=>'ê',
    		'Î'=>'î',
    		'Ô'=>'ô',
    		'Û'=>'û',
    		'Ù'=>'ù',
    	);
    	foreach ($specialchars as $maj=>$min)
    		$name = str_replace($maj,$min,$name);
    	$name = str_replace('- ','-',ucwords($name));
    	while (substr_count($name,'  '))
    		$name = str_replace('  ',' ',$name);
    	while (substr_count($name,'- '))
    		$name = str_replace('- ','-',$name);
    	while (substr_count($name,' -'))
    		$name = str_replace(' -','-',$name);
    	if (!preg_match('#^[ A-zàâçéèêîôûùÂÀÇÉÈÊÎÔÛÙ\-]*$#',$name))
    		throw new PersonException('invalid name');
    	return $name;
    }
    
    /**
     * Set firstName
     *
     * @param string $firstName
     * @throw PersonException
     * @return Person
     */
    public function setFirstName($firstName)
    {
    	try {
    		$this->firstName = $this->filterName($firstName);
    	} catch (PersonException $e) {
    		throw new PersonException('invalid firstName');
    	}
        return $this;
    }
    
    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @throw PersonException
     * @return Person
     */
    public function setLastName($lastName)
    {
    	try {
    		$this->lastName = $this->filterName($lastName);
    	} catch (PersonException $e) {
    		throw new PersonException('invalid lastName');
    	}
        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }
    
    /**
     * To string
     * 
     * @return string
     */
    public function __toString()
    {
    	$out = '';
    	if ($this->getTitle() != '')
    		$out .= $this->getTitle().' ';
    	if ($this->getFirstName() != '')
    		$out .= $this->getFirstName().' ';
    	if ($this->getLastName() != '')
    		$out .= strtoupper($this->getLastName());
    	return $out;
    }
}

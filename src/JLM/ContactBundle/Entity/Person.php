<?php

namespace JLM\ContactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Person
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Person
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
     * Set firstName
     *
     * @param string $firstName
     * @throw PersonException
     * @return Person
     */
    public function setFirstName($firstName)
    {
    	$firstName = str_replace('- ','-',ucwords(strtolower(str_replace('-','- ',trim($firstName)))));
    	while (substr_count($firstName,'  '))
    		$firstName = str_replace('  ',' ',$firstName);
    	while (substr_count($firstName,'- '))
    		$firstName = str_replace('- ','-',$firstName);
    	while (substr_count($firstName,' -'))
    		$firstName = str_replace(' -','-',$firstName);
    	if (!preg_match('#^[ A-zéèçàÉÈÇÀâêîôûÂÊÎÔÛ\-]*$#',$firstName))
    		throw new PersonException('invalid firstName');
        $this->firstName = $firstName;
    
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
    	$lastName = str_replace('- ','-',ucwords(strtolower(str_replace('-','- ',trim($lastName)))));
    	while (substr_count($lastName,'  '))
    		$lastName = str_replace('  ',' ',$lastName);
    	while (substr_count($lastName,'- '))
    		$lastName = str_replace('- ','-',$lastName);
    	while (substr_count($lastName,' -'))
    		$lastName = str_replace(' -','-',$lastName);
    	if (!preg_match('#^[ A-zéèçàÉÈÇÀâêîôûÂÊÎÔÛ\-]*$#',$lastName))
    		throw new PersonException('invalid lastName');
        $this->lastName = $lastName;
    
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

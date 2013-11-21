<?php

namespace JLM\ContactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JLM\ContactBundle\Entity\Contact;

/**
 * @ORM\MappedSuperclass
 */
abstract class ContactData
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
	 * @var Contact
	 *
	 * @ORM\ManyToOne(targetEntity="Contact")
	 */
	private $contact = null;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="alias", type="string", length=255)
	 */
	private $alias = '';
	
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
     * Set alias
     *
     * @param string $alias
     * @return Phone
     */
    public function setAlias($alias)
    {
    	try{
    		$alias = (string)$alias;
    	}
    	catch (\Exception $e) {
    		throw new ContactDataException('alias parameter must be a string');
    	}

    		
    	$alias = substr(ucfirst(strtolower(str_replace('  ',' ',trim($alias)))),0,255);
    	if (empty($alias))
    		throw new ContactDataException('alias parameter must contain more 1 character');
        $this->alias = $alias;
    	
        return $this;
    }

	
	/**
	 * Get alias
	 *
	 * @return string
	 */
	public function getAlias()
	{
		return $this->alias;
	}
	
	/**
	 * Set contact
	 *
	 * @param \JLM\ContactBundle\Entity\Contact $contact
	 * @return ContactAddress
	 */
	public function setContact(\JLM\ContactBundle\Entity\Contact $contact = null)
	{
		$this->contact = $contact;
	
		return $this;
	}
	
	/**
	 * Get contact
	 *
	 * @return \JLM\ContactBundle\Entity\Contact
	 */
	public function getContact()
	{
		return $this->contact;
	}
	
	abstract public function __toString();
	
}
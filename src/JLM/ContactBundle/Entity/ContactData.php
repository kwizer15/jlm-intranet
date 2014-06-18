<?php

namespace JLM\ContactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use JLM\ContactBundle\Model\ContactDataInterface;
use JLM\ContactBundle\Model\ContactInterface;

class ContactDataException extends \Exception {}

/**
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap(
 * 		{
 * 			"address" = "JLM\ContactBundle\Entity\ContactAddress",
 * 			"email"   = "JLM\ContactBundle\Entity\ContactEmail",
 * 			"phone"   = "JLM\ContactBundle\Entity\ContactPhone",
 * 		}
 * 	)
 */
abstract class ContactData implements ContactDataInterface
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
	 * @ORM\ManyToOne(targetEntity="JLM\ContactBundle\Model\ContactInterface", inversedBy="datas")
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
     * @return self
     */
    public function setAlias($alias)
    {
    	if (is_array($alias))
    		throw new ContactDataException('alias parameter must be a string');
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
	 * @return self
	 */
	public function setContact(ContactInterface $contact = null)
	{
		$this->contact = $contact;
	
		return $this;
	}
	
	/**
	 * Get contact
	 *
	 * @return Contact
	 */
	public function getContact()
	{
		return $this->contact;
	}
	
	/**
	 * {@inheritdoc}
	 */
	abstract public function __toString();
	
}
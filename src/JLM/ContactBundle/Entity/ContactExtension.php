<?php
namespace JLM\ContactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JLM\ContactBundle\Model\ContactInterface;
use JLM\ContactBundle\Model\ContactAddressInterface;
use JLM\ContactBundle\Model\ContactEmailInterface;
use JLM\ContactBundle\Model\ContactPhoneInterface;

/**
 * @ORM\MappedSuperclass
 */
abstract class ContactExtension implements ContactInterface
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
	 * @ORM\OneToOne(targetEntity="JLM\ContactBundle\Model\ContactInterface")
	 */
	private $contact;
	
	/**
	 * Constructor
	 * @param ContactInterface $contact
	 */
	public function __construct(ContactInterface $contact)
	{
		$this->contact = $contact;
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
	public function getName()
	{
		return $this->contact->getName();
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getMainAddress()
	{
		return $this->contact->getMainAddress();
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function addEmail(ContactEmailInterface $email)
	{
		$this->contact->addEmail($email);
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function removeEmail(ContactEmailInterface $email)
	{
		$this->contact->removeEmail($email);
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getEmails()
	{
		return $this->contact->getEmails();
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function addAddress(ContactAddressInterface $address)
	{
		$this->contact->addAddress($address);
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function removeAddress(ContactAddressInterface $address)
	{
		$this->contact->removeAddress($address);
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getAddresses()
	{
		return $this->contact->getAddresses();
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function addPhone(ContactPhoneInterface $phone)
	{
		$this->contact->addPhone($phone);
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function removePhone(ContactPhoneInterface $phone)
	{
		$this->contact->removePhone($phone);
		return $this;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getPhones()
	{
		return $this->contact->getPhones();
	}
	
	/**
	 * {@inherirdoc}
	 */
	public function __toString()
	{
		return $this->contact->__toString();
	}
}
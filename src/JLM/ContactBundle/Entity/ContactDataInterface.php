<?php
namespace JLM\ContactBundle\Entity;

interface ContactDataInterface
{
	/**
	 * get Alias
	 * @return string
	 */
	public function getAlias();
	
	/**
	 * get Contact
	 * @return ContactInterface
	 */
	public function getContact();
	
	/**
	 * get Contact
	 * @param ContactInterface $contact
	 * @return ContactInterface
	 */
	public function setContact(ContactInterface $contact = null);
	
	/**
	 * to String
	 * @return string
	 */
	public function __toString();
	
}
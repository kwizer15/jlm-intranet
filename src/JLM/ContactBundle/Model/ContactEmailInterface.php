<?php
namespace JLM\ContactBundle\Model;

interface ContactEmailInterface extends ContactDataInterface, EmailInterface
{
	/**
	 * Construct
	 * @param ContactInterface $contact
	 * @param string $alias
	 * @param EmailInterface $email
	 */
	public function __construct(ContactInterface $contact, $alias, EmailInterface $email);
}
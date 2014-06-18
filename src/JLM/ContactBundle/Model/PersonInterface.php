<?php
namespace JLM\ContactBundle\Model;

interface PersonInterface extends ContactInterface
{
	/**
	 * Get firstName
	 *
	 * @return string
	 */
	public function getFirstName();
	
	/**
	 * Get lastName
	 *
	 * @return string
	 */
	public function getLastName();
}
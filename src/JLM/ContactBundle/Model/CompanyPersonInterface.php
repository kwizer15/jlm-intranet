<?php
namespace JLM\ContactBundle\Model;

interface CompanyPersonInterface extends PersonInterface
{
	/**
	 * Get role
	 * 
	 * @return string
	 */
	public function getRole();
	
	/**
	 * Get company
	 * 
	 * @return CompanyInterface
	 */
	public function getCompany();
}
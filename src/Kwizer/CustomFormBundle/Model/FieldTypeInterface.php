<?php
namespace Kwizer\CustomFormBundle\Model;

interface FieldTypeInterface
{
	/**
	 * Get the name
	 * 
	 * @return string
	 */
	public function getName();
	
	/**
	 * Get the FormType
	 * 
	 * @return string
	 */
	public function getFormTypeName();
}
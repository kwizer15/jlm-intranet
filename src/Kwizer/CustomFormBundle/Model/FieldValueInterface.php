<?php
namespace Kwizer\CustomFormBundle\Model;

interface FieldValueInterface
{
	/**
	 * Get the field
	 * 
	 * @return FieldInterface
	 */
	public function getField();
	
	/**
	 * Get the field value
	 * 
	 * @return mixed
	 */
	public function getValue();
	
	/**
	 * Set the field value
	 *
	 * @param mixed $value
	 * @return self
	 */
	public function setValue($value);
}
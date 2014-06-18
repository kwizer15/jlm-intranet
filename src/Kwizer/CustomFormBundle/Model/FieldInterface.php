<?php
namespace Kwizer\CustomFormBundle\Model;

interface FieldInterface
{
	/**
	 * Get the name
	 * 
	 * @return string
	 */
	public function getTitle();
	
	/**
	 * Get the default value
	 *
	 * @return mixed
	 */
	public function getDefaultValue();
	
	/**
	 * Get the field type
	 * 
	 * @return FieldTypeInterface
	 */
	public function getFieldType();
	

	/**
	 * @return array
	 */
	public function getOptions();
}
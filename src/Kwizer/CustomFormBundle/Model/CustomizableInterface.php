<?php
namespace Kwizer\CustomFormBundle\Model;

interface CustomizableInterface
{
	/**
	 * Set the type
	 * @param CustomizableTypeInterface $type
	 * @return self
	 */
	public function setType(CustomizableTypeInterface $type);
	
	/**
	 * Get values of each attributes
	 * @param string $attr
	 * @throws \Exception
	 * @return mixed
	 */
	public function __get($attr);
	
	/**
	 * Get the type
	 * @return FieldTypeInterface
	 */
	public function getType();
	
	/**
	 * Get the type name
	 * @return string
	 */
	public function getTypeName();
}
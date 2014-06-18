<?php
namespace Kwizer\CustomFormBundle\Model;

interface CustomizableTypeInterface
{
	public function getFields();
	
	public function addField(FieldInterface $field);
}
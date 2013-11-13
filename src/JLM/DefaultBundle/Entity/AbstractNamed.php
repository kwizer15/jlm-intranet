<?php
namespace JLM\DefaultBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * JLM\DefaultBundle\Entity\NameModel
 *
 * @ORM\MappedSuperclass
 */
abstract class AbstractNamed
{
	/**
	 * @var string
	 * 
	 * @ORM\Column(name="name")
	 * @Assert\NotNull
	 * @Assert\Type(type="string")
	 * @Assert\NotBlank
	 */
	private $name = '';
	
	/**
	 * Set text
	 *
	 * @param string $text
	 */
	public function setName($name)
	{
		$this->name = trim($name);
		return $this;
	}

	/**
	 * Get text
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * To String
	 */
	public function __toString()
	{
		return $this->getName();
	}
}
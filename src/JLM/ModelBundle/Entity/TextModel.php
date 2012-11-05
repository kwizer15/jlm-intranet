<?php
namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JLM\ModelBundle\Entity\TextModel
 *
 * @ORM\MappedSuperclass
 */
abstract class TextModel
{
	/**
	 * @var string
	 * 
	 * @ORM\Column(name="text")
	 */
	private $text;
	
	/**
	 * Set text
	 *
	 * @param string $text
	 */
	public function setText($text)
	{
		$this->text = $text;
	}

	/**
	 * Get text
	 *
	 * @return string
	 */
	public function getText()
	{
		return $this->text;
	}

	/**
	 * To String
	 */
	public function __toString()
	{
		return $this->getText();
	}
}
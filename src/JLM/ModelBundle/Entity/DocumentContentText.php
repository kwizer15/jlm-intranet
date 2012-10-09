<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JLM\ModelBundle\Entity\DocumentContentText
 *
 * @ORM\Table(name="document_contents_text")
 * @ORM\Entity
 */
class DocumentContentText extends DocumentContent
{
	/**
	 * @var string $textModel
	 *
	 * @ORM\ManyToOne(targetEntity="DocumentContentTextModel")
	 */
	private $model;
	
    /**
     * @var string $text
     *
     * @ORM\Column(name="text", type="text")
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
     * Set model
     *
     * @param JLM\ModelBundle\Entity\DocumentContentTextModel $model
     */
    public function setModel(\JLM\ModelBundle\Entity\DocumentContentTextModel $model)
    {
        $this->model = $model;
    }

    /**
     * Get model
     *
     * @return JLM\ModelBundle\Entity\DocumentContentTextModel 
     */
    public function getModel()
    {
        return $this->model;
    }
}
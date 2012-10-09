<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JLM\ModelBundle\Entity\DocumentContent
 *
 * @ORM\Table(name="document_contents")
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
 * 		"line" = "DocumentContentLine",
 *      "text" = "DocumentContentText"
 * })
 */
abstract class DocumentContent
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Document $document
     * 
     * @ORM\ManyToOne(targetEntity="Document",inversedBy="contents")
     */
    private $document;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set document
     *
     * @param JLM\ModelBundle\Entity\Docuement $document
     */
    public function setDocument(\JLM\ModelBundle\Entity\Docuement $document)
    {
        $this->document = $document;
    }

    /**
     * Get document
     *
     * @return JLM\ModelBundle\Entity\Docuement 
     */
    public function getDocument()
    {
        return $this->document;
    }
}
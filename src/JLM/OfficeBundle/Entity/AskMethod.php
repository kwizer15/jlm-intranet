<?php

namespace JLM\OfficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JLM\ModelBundle\Entity\StringModel;

/**
 * JLM\OfficeBundle\Entity\AskMethod
 *
 * @ORM\Table(name="askmethods")
 * @ORM\Entity(readOnly=true,repositoryClass="JLM\CommerceBundle\Entity\TextModelRepository")
 */
class AskMethod extends StringModel
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
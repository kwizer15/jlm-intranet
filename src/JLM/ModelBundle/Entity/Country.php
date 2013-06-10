<?php

namespace JLM\ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * JLM\ModelBundle\Entity\Country
 *
 * @ORM\Table(name="countries")
 * @ORM\Entity(readOnly=true)
 * @UniqueEntity("code")
 */
class Country extends StringModel
{
    /**
     * @var string $code
     *
     * @ORM\Column(name="code", type="string", length=2)
     * @ORM\Id
     * @Assert\Type(type="string")
     * @Assert\Length(min=2,max=2)
     * @Assert\NotBlank
     */
    private $code;

    /**
     * Set code
     *
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }
}
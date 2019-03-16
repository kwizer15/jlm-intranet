<?php

/*
 * This file is part of the JLMModelBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ModelBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use JLM\ContactBundle\Entity\PersonDecorator as BasePerson;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class Technician extends BasePerson
{
    /**
     * @var string $internalPhone
     *
     * @Assert\Regex(pattern="/^\d{3,4}$/",message="Ce numéro ne contient pas uniquement 10 chiffres")
     */
    private $internalPhone;

    public function __toString()
    {
        return $this->getFirstName();
    }
}

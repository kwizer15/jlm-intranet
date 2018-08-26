<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ContactBundle\Entity;

use JLM\ContactBundle\Model\CountryInterface;
use Symfony\Component\DependencyInjection\Exception\LogicException;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class Country implements CountryInterface
{
    /**
     * @var string
     */
    protected $code;
    
    /**
     * @var string
     */
    protected $name = '';
    
    /**
     * Set code
     *
     * @param string $code
     * @throws CountryException
     * @return self
     */
    public function setCode($code)
    {
        $code = strtoupper(substr(trim($code), 0, 2));
        if (!preg_match('#^[A-Z]{2}$#', $code)) {
            throw new LogicException('Code pays incorrect');
        }
        $this->code = $code;
        
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCode()
    {
        return $this->code;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $name = str_replace(['0','1','2','3','4','5','6','7','8','9'], '', $name);
        $name = ucwords(strtolower($name));
        $this->name = $name;
        
        return $this;
    }
    
    /**
     * To String
     */
    public function __toString()
    {
        return $this->getName();
    }
}

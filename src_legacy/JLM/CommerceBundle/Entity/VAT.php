<?php

/*
 * This file is part of the JLMCommerceBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JLM\CommerceBundle\Model\VATInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class VAT implements VATInterface
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var int $rate
     */
    private $rate;


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
     * Set name
     *
     * @param int $rate
     */
    public function setRate($rate)
    {
        $this->rate = $rate;
    }

    /**
     * {@inheritdoc}
     */
    public function getRate()
    {
        return $this->rate;
    }
    
    /**
     * To String
     *
     * @return string
     */
    public function __toString()
    {
        return str_replace('.', ',', number_format($this->rate * 100, 1)).' %';
    }
}

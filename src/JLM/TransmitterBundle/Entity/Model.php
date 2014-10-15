<?php

namespace JLM\TransmitterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JLM\ProductBundle\Model\ProductInterface;

/**
 * Model
 *
 * @ORM\Table(name="transmitters_model")
 * @ORM\Entity
 */
class Model extends \JLM\OfficeBundle\Entity\TextModel
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Product
     * 
     * @ORM\OneToOne(targetEntity="JLM\ProductBundle\Model\ProductInterface")
     */
    private $product;

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
     * Set product
     *
     * @param ProductInterface $product
     * @return Model
     */
    public function setProduct(ProductInterface $product = null)
    {
        $this->product = $product;
    
        return $this;
    }

    /**
     * Get product
     *
     * @return ProductInterface 
     */
    public function getProduct()
    {
        return $this->product;
    }
    
}
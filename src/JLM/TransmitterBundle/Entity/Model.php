<?php

namespace JLM\TransmitterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JLM\ModelBundle\Entity\Product;

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
     * @ORM\OneToOne(targetEntity="JLM\ModelBundle\Entity\Product")
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
     * @param Product $product
     * @return Model
     */
    public function setProduct(Product $product = null)
    {
        $this->product = $product;
    
        return $this;
    }

    /**
     * Get product
     *
     * @return Product 
     */
    public function getProduct()
    {
        return $this->product;
    }
    
}
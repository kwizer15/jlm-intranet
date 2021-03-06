<?php

/*
 * This file is part of the JLMProductBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ProductBundle\Entity;

use JLM\ProductBundle\Model\ProductInterface;
use JLM\ProductBundle\Model\ProductPriceInterface;
use JLM\ProductBundle\Model\ProductCategoryInterface;
use JLM\ProductBundle\Model\SupplierInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class Product implements ProductInterface
{
    /**
     * Id
     *
     * @var integer $id
     */
    private $id;

    /**
     * Designation
     *
     * @var string $designation
     */
    private $designation;

    /**
     * Description longue
     *
     * @var text $description
     */
    private $description;

    /**
     * Fournisseur principal
     *
     * @var SupplierInterface $supplier
     */
    private $supplier;

    /**
     * Reference produit
     *
     * @var string $reference
     */
    private $reference;

    /**
     * Code barre
     *
     * @var string $barcode
     */
    private $barcode;

    /**
     * Prix de vente unitaire (en €)
     *
     * @var float $unitPrice
     */
    private $unitPrice;

    /**
     * Famille de produit
     *
     * @var ProductCategory $category
     */
    private $category;

    /**
     * Prix d'achat HT
     *
     * @var float $purchase
     */
    private $purchase;

    /**
     * Taux de remise fournisseur (en %)
     *
     * @var float $discountSupplier
     */
    private $discountSupplier;

    /**
     * Taux de frais (en %)
     *
     * @var float $expenseRatio
     */
    private $expenseRatio;

    /**
     * Frais de port (en €)
     *
     * @var float $shipping
     */
    private $shipping;

    /**
     * Unité (pièce, mètre...)
     *
     * @var string $unity
     */
    private $unity;

    /**
     * Prix quantitatifs
     *
     * @var ArrayCollection
     */
    private $unitPrices;

    /**
     * Prix public
     *
     * @var decimal
     */
    private $publicPrice;

    /**
     * Produit actif
     *
     * @var bool
     */
    private $active = true;

    /**
     * Fichiers liés (plans, docs...)
     *
     * @var LinkedFile[] $files
     *
     * ORM\OneToMany(targetEntity="LinkedFile", mappedBy="product")
     */
    // private $files;

    /**
     * Photo
     *
     * @var LinkedFile $picture
     */
    // private $picture;

    /**
     * Pour les kits
     *
     * @var Product[] $children
     */
    // private $children;

    /**
     * Pour les kits
     *
     * @var Product $parent
     */
    // private $parent;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function isSmallSupply()
    {
        return $this->getCategory()->isSmallSupply();
    }

    public function isService()
    {
        return $this->getCategory()->isService();
    }

    /**
     * Set designation
     *
     * @param string $designation
     *
     * @return self
     */
    public function setDesignation($designation)
    {
        $this->designation = $designation;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDesignation()
    {
        return $this->designation;
    }

    /**
     * Set description
     *
     * @param text $description
     *
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set reference
     *
     * @param string $reference
     *
     * @return self
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set barcode
     *
     * @param string $barcode
     *
     * @return self
     */
    public function setBarcode($barcode)
    {
        $this->barcode = $barcode;

        return $this;
    }

    /**
     * Get barcode
     *
     * @return string
     */
    public function getBarcode()
    {
        return $this->barcode;
    }

    /**
     * Set unitPrice
     *
     * @param float $unitPrice
     *
     * @return self
     */
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUnitPrice($quantity = null)
    {
        if ($quantity === null || $this->unitPrices === null) {
            return $this->unitPrice;
        }
        $index = 0;
        $q = $this->unitPrices[$index]->getQuantity();
        while ($quantity >= $q) {
            // Quand on arrive au bout du tableau
            if (!isset($this->unitPrices[$index + 1])) {
                return $this->unitPrices[$index]->getUnitPrice();
            }
            $q = $this->unitPrices[++$index]->getQuantity();
        }

        return $this->unitPrices[$index - 1]->getUnitPrice();
    }

    /**
     * Set purchase
     *
     * @param decimal $purchase
     *
     * @return self
     */
    public function setPurchase($purchase)
    {
        $this->purchase = $purchase;

        return $this;
    }

    /**
     * Get purchase
     *
     * @return decimal
     */
    public function getPurchase()
    {
        return $this->purchase;
    }

    /**
     * Set discountSupplier
     *
     * @param decimal $discountSupplier
     *
     * @return self
     */
    public function setDiscountSupplier($discountSupplier)
    {
        $this->discountSupplier = $discountSupplier;

        return $this;
    }

    /**
     * Get discountSupplier
     *
     * @return decimal
     */
    public function getDiscountSupplier()
    {
        return $this->discountSupplier;
    }

    /**
     * Set expenseRatio
     *
     * @param decimal $expenseRatio
     *
     * @return self
     */
    public function setExpenseRatio($expenseRatio)
    {
        $this->expenseRatio = $expenseRatio;

        return $this;
    }

    /**
     * Get expenseRatio
     *
     * @return decimal
     */
    public function getExpenseRatio()
    {
        return $this->expenseRatio;
    }

    /**
     * Set shipping
     *
     * @param decimal $shipping
     *
     * @return self
     */
    public function setShipping($shipping)
    {
        $this->shipping = $shipping;

        return $this;
    }

    /**
     * Get shipping
     *
     * @return decimal
     */
    public function getShipping()
    {
        return $this->shipping;
    }

    /**
     * Set unity
     *
     * @param string $unity
     *
     * @return self
     */
    public function setUnity($unity)
    {
        $this->unity = $unity;

        return $this;
    }

    /**
     * Get unity
     *
     * @return string
     */
    public function getUnity()
    {
        return $this->unity;
    }

    public function getPurchasePrice()
    {
        return ($this->getPurchase() * (1 - ($this->getDiscountSupplier() / 100))) * (1 + ($this->getExpenseRatio()
                    / 100)) + $this->getShipping();
    }

    public function getMargin()
    {
        return ($this->getUnitPrice() - $this->getPurchasePrice());
    }

    public function getCoef()
    {
        $d = $this->getPurchasePrice() - $this->getShipping();
        $n = $this->getUnitPrice() - $this->getShipping();
        if ($d == 0) {
            return 0;
        }

        return (($n / $d) - 1) * 100;
    }

    /**
     * Set supplier
     *
     * @param SupplierInterface $supplier
     *
     * @return self
     */
    public function setSupplier(SupplierInterface $supplier)
    {
        $this->supplier = $supplier;

        return $this;
    }

    /**
     * Get supplier
     *
     * @return SupplierInterface
     */
    public function getSupplier()
    {
        return $this->supplier;
    }

    /**
     * Set category
     *
     * @param ProductCategoryInterface $category
     */
    public function setCategory(ProductCategoryInterface $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * To String
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getDesignation();
    }

    /**
     * Vérifie coeficient
     *
     * @return boolean
     */
    public function isCoefPositive()
    {
        return $this->getCoef() >= 0;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->unitPrices = new \Doctrine\Common\Collections\ArrayCollection();
        //$this->files = new \Doctrine\Common\Collections\ArrayCollection();
        //$this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add unitPrices
     *
     * @param ProductPriceInterface $unitPrices
     *
     * @return self
     */
    public function addUnitPrice(ProductPriceInterface $unitPrices)
    {
        return $this->unitPrices->add($unitPrices);
    }

    /**
     * Remove unitPrices
     *
     * @param ProductPriceInterface $unitPrices
     *
     * @return boolean
     */
    public function removeUnitPrice(ProductPriceInterface $unitPrices)
    {
        return $this->unitPrices->removeElement($unitPrices);
    }

    /**
     * Get unitPrices
     *
     * @return ProductPriceInterface[]
     */
    public function getUnitPrices()
    {
        return $this->unitPrices;
    }

    /**
     * Is active
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Set active
     *
     * @param bool $active
     *
     * @return self
     */
    public function setActive($active)
    {
        $this->active = (bool) $active;

        return $this;
    }
}

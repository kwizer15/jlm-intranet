<?php

/*
 * This file is part of the  package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\InstallationBundle\Entity;

use JLM\InstallationBundle\Model\PartTypeInterface;
use JLM\InstallationBundle\Model\PartCategoryInterface;
use JLM\InstallationBundle\Model\PartStateInterface;
/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class PartType implements PartTypeInterface
{
    /**
     * Nom de la pièce
     * @var string
     */
    private $name;
    
    /**
     * Catégorie de fonction de la pièce
     * @var PartCategoryInterface
     */
    private $category;
    
    /**
     * Les états dans lesquelles peut se trouver la pièce
     * @var Traversable
     */
    private $states;
    
    /**
     * 
     * @param string $name
     * @param PartCategoryInterface $category
     * @param array|Traversable $states
     */
    public function __construct($name, PartCategoryInterface $category, $states = array())
    {
        $this->setName($name);
        $this->setCategory($category);
        $this->setStates($states);
    }
    
    /**
     * 
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * 
     * {@inheritdoc}
     */
    public function getCategory()
    {
        return $this->category;
    }
    
    /**
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        
        return $this;
    }
    
    /**
     * @param PartCategoryInterface $category
     * @return self
     */
    public function setCategory(PartCategoryInterface $category)
    {
        $this->category = $category;
    
        return $this;
    }
    
    /**
     * @return StateInterface[]
     */
    public function getStates()
    {
        return $this->states;
    }
    
    /**
     * @param array|Traversable $states
     * @return self
     */
    public function setStates($states)
    {
        if (!is_array($states) && !$states instanceof \Traversable)
        {
            throw new \LogicException('state must be traversable');
        }
        
        $this->states = new \Doctrine\Common\Collections\ArrayCollection;
        foreach ($states as $state)
        {
            if ($state instanceof PartStateInterface)
            {
                $this->states->add($state);
            }
        }
        
        return $this;
    }
}
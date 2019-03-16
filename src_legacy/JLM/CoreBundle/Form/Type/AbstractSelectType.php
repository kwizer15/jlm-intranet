<?php

/*
 * This file is part of the JLMCoreBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CoreBundle\Form\Type;

use Doctrine\Common\Persistence\ObjectManager;
use Genemu\Bundle\FormBundle\Form\JQuery\Type\Select2HiddenType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
abstract class AbstractSelectType extends AbstractType
{
    /**
     * @var ObjectManager
     */
    private $om;
    
    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return Select2HiddenType::class;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $transformer = $this->getTransformerClass();
        $resolver->setDefaults([
            'transformer' => new $transformer($this->om),
        ]);
    }

    public function getOm()
    {
        return $this->om;
    }

    /**
     * Get the transformer class
     *
     * @return string
     */
    abstract protected function getTransformerClass();
}

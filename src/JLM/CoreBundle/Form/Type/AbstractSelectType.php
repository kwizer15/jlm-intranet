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

use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
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
        return 'genemu_jqueryselect2_hidden';
    }
    
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $transformer = $this->getTransformerClass();
        $resolver->setDefaults([
                'transformer' => new $transformer($this->om),
        ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getTypeName().'_select';
    }
    
    /**
     * Get the transformer class
     *
     * @return string
     */
    abstract protected function getTransformerClass();
    
    /**
     * Get the type name
     *
     * @return string
    */
    abstract protected function getTypeName();
}

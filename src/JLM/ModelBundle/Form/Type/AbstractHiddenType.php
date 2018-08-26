<?php

namespace JLM\ModelBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

abstract class AbstractHiddenType extends AbstractType
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
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $cl = $this->getTransformerClass();
        $transformer = new $cl($this->om);
        $builder->addModelTransformer($transformer);
    }

    public function getParent()
    {
        return 'hidden';
    }
    
    public function getName()
    {
        return $this->getTypeName().'_hidden';
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'invalid_message' => 'The selected '.$this->getTypeName().' does not exist',
        ]);
    }
    
    abstract protected function getTransformerClass();
    
    abstract protected function getTypeName();
}

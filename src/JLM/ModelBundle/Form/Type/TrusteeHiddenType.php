<?php

namespace JLM\ModelBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use JLM\ModelBundle\Form\DataTransformer\TrusteeToIntTransformer;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TrusteeHiddenType extends AbstractType
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
        $transformer = new TrusteeToIntTransformer($this->om);
        $builder->addModelTransformer($transformer);
    }

    public function getParent()
    {
        return 'hidden';
    }
    
    public function getName()
    {
        return 'trustee_hidden';
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'invalid_message' => 'The selected trustee does not exist',
        ]);
    }
}

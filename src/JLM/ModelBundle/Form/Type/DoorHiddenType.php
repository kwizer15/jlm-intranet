<?php

namespace JLM\ModelBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use JLM\ModelBundle\Form\DataTransformer\DoorToIntTransformer;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DoorHiddenType extends AbstractType
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
        $transformer = new DoorToIntTransformer($this->om);
        $builder->addModelTransformer($transformer);
    }

    public function getParent()
    {
        return 'hidden';
    }
    
    public function getName()
    {
        return 'door_hidden';
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'invalid_message' => 'The selected door does not exist',
        ]);
    }
}

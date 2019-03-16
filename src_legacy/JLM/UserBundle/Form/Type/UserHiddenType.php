<?php

namespace JLM\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use JLM\UserBundle\Form\DataTransformer\UserToIntTransformer;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserHiddenType extends AbstractType
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
        $transformer = new UserToIntTransformer($this->om);
        $builder->addModelTransformer($transformer);
    }

    public function getParent()
    {
        return HiddenType::class;
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['invalid_message' => 'The selected trustee does not exist']);
    }
}

<?php

namespace JLM\OfficeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use JLM\OfficeBundle\Form\DataTransformer\AskQuoteToIntTransformer;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AskQuoteHiddenType extends AbstractType
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
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $transformer = new AskQuoteToIntTransformer($this->om);
        $builder->addModelTransformer($transformer);
    }

    public function getParent(): string
    {
        return HiddenType::class;
    }
    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['invalid_message' => 'The selected askquote does not exist']);
    }
}

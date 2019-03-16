<?php

namespace JLM\DailyBundle\Form\Type;

use JLM\DailyBundle\Entity\PartFamily;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use JLM\CoreBundle\Form\DataTransformer\ObjectToStringAutocreateTransformer;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

class PartFamilyType extends AbstractType
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
        $transformer = new ObjectToStringAutocreateTransformer($this->om, PartFamily::class, 'name');
        $builder->addModelTransformer($transformer);
    }
    
    public function getParent()
    {
        return TextType::class;
    }

    /**
     * Ajoute l'option source
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        // TODO: Deprecated method to replace OptionsResolver::setOptional
        $resolver->setDefined(['source']);
    }
    
    /**
     * Passe la source de données à la vue
     *
     * @param \Symfony\Component\Form\FormView $view
     * @param \Symfony\Component\Form\FormInterface $form
     * @param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $parts = $this->om->getRepository('JLMDailyBundle:PartFamily')->findAll();
        $view->vars['source'] = $parts;
    }
}

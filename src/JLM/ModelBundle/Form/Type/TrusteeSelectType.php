<?php

namespace JLM\ModelBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use JLM\ModelBundle\Form\DataTransformer\TrusteeToIntTransformer;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TrusteeSelectType extends AbstractType
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

    public function getParent()
    {
        return 'genemu_jqueryselect2_hidden';
    }
    
    public function getName()
    {
        return 'trustee_select';
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'transformer' => new TrusteeToIntTransformer($this->om),
        ]);
    }
}

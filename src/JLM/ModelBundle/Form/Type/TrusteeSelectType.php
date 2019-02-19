<?php

namespace JLM\ModelBundle\Form\Type;

use Genemu\Bundle\FormBundle\Form\JQuery\Type\Select2HiddenType;
use Symfony\Component\Form\AbstractType;
use JLM\ModelBundle\Form\DataTransformer\TrusteeToIntTransformer;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
        return Select2HiddenType::class;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'transformer' => new TrusteeToIntTransformer($this->om),
            ]
        );
    }
}

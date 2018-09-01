<?php

namespace JLM\OfficeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AskQuoteDontTreatType extends AskDontTreatType
{

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(['data_class' => 'JLM\OfficeBundle\Entity\AskQuote']);
    }

    public function getName()
    {
        return 'askquotedonttreat';
    }
}

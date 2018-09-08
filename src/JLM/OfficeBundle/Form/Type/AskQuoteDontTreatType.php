<?php

namespace JLM\OfficeBundle\Form\Type;

use JLM\OfficeBundle\Entity\AskQuote;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AskQuoteDontTreatType extends AskDontTreatType
{

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(['data_class' => AskQuote::class]);
    }
}

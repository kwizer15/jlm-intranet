<?php

namespace JLM\OfficeBundle\Form\Type;

use JLM\OfficeBundle\Entity\AskQuote;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AskQuoteDontTreatType extends AskDontTreatType
{

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => AskQuote::class]);
    }
}

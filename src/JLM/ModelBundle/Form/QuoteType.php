<?php

namespace JLM\ModelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class QuoteType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('creation','date')
            ->add('trusteeName')
            ->add('trusteeStreet')
            ->add('trusteeZip')
            ->add('trusteeCity')
            ->add('trusteeInterlocutor')
            ->add('paymentRules')
            ->add('deliveryRules')
            ->add('customerComments')
            ->add('follower')
            ->add('trustee')
            ->add('doors')
        ;
    }

    public function getName()
    {
        return 'jlm_modelbundle_quotetype';
    }
}

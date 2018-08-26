<?php

namespace JLM\ModelBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TrusteeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contact', 'jlm_contact_contact_select', ['label'=>'Contact','attr'=>['class'=>'input-large']])

            ->add('accountNumber', null, ['label'=>'Numéro de compte','required'=>false,'attr'=>['class'=>'input-small']])
            ->add('billingLabel', null, ['label'=>'Libélé de facturation','required'=>false])
            ->add('billingAddress', 'jlm_contact_address', ['label'=>'Adresse de facturation','required'=>false]) // Petite case à cocher + Formulaire
            ->add('billingPhone', null, ['label'=>'Téléphone','required'=>false,'attr'=>['class'=>'input-medium']])
            ->add('billingFax', null, ['label'=>'Fax','required'=>false,'attr'=>['class'=>'input-medium']])
            ->add('billingEmail', 'email', ['label'=>'e-mail','required'=>false,'attr'=>['class'=>'input-xlarge']])
        ;
    }

    public function getName()
    {
        return 'jlm_modelbundle_trusteetype';
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
        ->setDefaults([
                'data_class' => 'JLM\ModelBundle\Entity\Trustee',
        ]);
    }
}

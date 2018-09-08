<?php

namespace JLM\ModelBundle\Form\Type;

use JLM\ContactBundle\Form\Type\AddressType;
use JLM\ContactBundle\Form\Type\ContactSelectType;
use JLM\ModelBundle\Entity\Trustee;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TrusteeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contact', ContactSelectType::class, ['label' => 'Contact', 'attr' => ['class' => 'input-large']])
            ->add(
                'accountNumber',
                TextType::class,
                ['label' => 'Numéro de compte', 'required' => false, 'attr' => ['class' => 'input-small']]
            )
            ->add('billingLabel', TextType::class, ['label' => 'Libélé de facturation', 'required' => false])
            ->add(
                'billingAddress',
                AddressType::class,
                ['label' => 'Adresse de facturation', 'required' => false]
            )// Petite case à cocher + Formulaire
            ->add(
                'billingPhone',
                TextType::class,
                ['label' => 'Téléphone', 'required' => false, 'attr' => ['class' => 'input-medium']]
            )
            ->add('billingFax', TextType::class, ['label' => 'Fax', 'required' => false, 'attr' => ['class' => 'input-medium']])
            ->add(
                'billingEmail',
                EmailType::class,
                ['label' => 'e-mail', 'required' => false, 'attr' => ['class' => 'input-xlarge']]
            )
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(['data_class' => Trustee::class]);
    }
}

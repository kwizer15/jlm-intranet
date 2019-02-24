<?php

namespace JLM\ModelBundle\Form\Type;

use JLM\ContactBundle\Form\Type\AddressType;
use JLM\ModelBundle\Entity\Site;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('trustee', TrusteeSelectType::class, ['label' => 'Syndic', 'attr' => ['class' => 'input-large']])
            ->add('address', AddressType::class, ['label' => 'Adresse'])
            ->add('observations', TextType::class, ['label' => 'Observations', 'attr' => ['class' => 'input-xlarge']])
            ->add(
                'groupNumber',
                TextType::class,
                ['label' => 'Groupe (RIVP)', 'required' => false, 'attr' => ['class' => 'input-mini']]
            )
            ->add(
                'accession',
                ChoiceType::class,
                [
                    'label' => 'Accession/Social',
                    'choices' => array_flip(['1' => 'Accession', '0' => 'Social']),
                    'expanded' => true,
                    'multiple' => false,
                    'choices_as_values' => true,
                ]
            )
            ->add('vat', TextType::class, ['label' => 'TVA', 'attr' => ['class' => 'input-small']])
            ->add('lodge', AddressType::class, ['label' => 'Loge gardien', 'required' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Site::class]);
    }
}

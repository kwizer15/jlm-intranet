<?php

namespace JLM\ModelBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('trustee', 'trustee_select', ['label' => 'Syndic', 'attr' => ['class' => 'input-large']])
            ->add('address', 'jlm_contact_address', ['label' => 'Adresse'])
            ->add('observations', null, ['label' => 'Observations', 'attr' => ['class' => 'input-xlarge']])
            ->add(
                'groupNumber',
                null,
                ['label' => 'Groupe (RIVP)', 'required' => false, 'attr' => ['class' => 'input-mini']]
            )
            ->add(
                'accession',
                'choice',
                [
                    'label' => 'Accession/Social',
                    'choices' => ['1' => 'Accession', '0' => 'Social'],
                    'expanded' => true,
                    'multiple' => false,
                ]
            )
            ->add('vat', null, ['label' => 'TVA', 'attr' => ['class' => 'input-small']])
            ->add('lodge', 'jlm_contact_address', ['label' => 'Loge gardien', 'required' => false])
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(['data_class' => 'JLM\ModelBundle\Entity\Site']);
    }

    public function getName()
    {
        return 'jlm_modelbundle_sitetype';
    }
}

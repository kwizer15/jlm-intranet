<?php

namespace JLM\OfficeBundle\Form\Type;

use JLM\AskBundle\Entity\CommunicationMeans;
use JLM\CoreBundle\Form\Type\UploadDocumentType;
use JLM\ModelBundle\Entity\Door;
use JLM\ModelBundle\Form\Type\DatepickerType;
use JLM\ModelBundle\Form\Type\SiteSelectType;
use JLM\ModelBundle\Form\Type\TrusteeSelectType;
use JLM\OfficeBundle\Entity\AskQuote;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AskQuoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('creation', DatepickerType::class, ['label' => 'Date de la demande'])
            ->add('trustee', TrusteeSelectType::class, ['label' => 'Syndic', 'attr' => ['class' => 'input-xlarge']])
            ->add(
                'site',
                SiteSelectType::class,
                ['label' => 'Affaire', 'attr' => ['class' => 'input-xxlarge', 'rows' => 5]]
            )
            ->add(
                'door',
                EntityType::class,
                [
                    'class' => Door::class,
                    'empty_value' => 'Affaire complète',
                    'label' => 'Installation',
                    'attr' => ['class' => 'input-xxlarge'],
                    'required' => false,
                ]
            )
            ->add('method', EntityType::class, [
                'label' => 'Arrivée par',
                'class' => CommunicationMeans::class,
                'attr' => ['class' => 'input-medium']
            ])
            ->add('maturity', DatepickerType::class, [
                'label' => 'Date d\'échéance',
                'required' => false
            ])
            ->add('ask', TextType::class, [
                'label' => 'Demande',
                'attr' => [
                    'class' => 'input-xxlarge',
                    'rows' => 5
                ]
            ])
            ->add('file', UploadDocumentType::class, [
                'label' => 'Fichier joint',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => AskQuote::class,
            ]
        );
    }
}

<?php

/*
 * This file is part of the JLMContractBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ContractBundle\Form\Type;

use JLM\ContractBundle\Entity\Contract;
use JLM\ModelBundle\Form\Type\DatepickerType;
use JLM\ModelBundle\Form\Type\DoorHiddenType;
use JLM\ModelBundle\Form\Type\TrusteeSelectType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class ContractType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('door', DoorHiddenType::class)
            ->add('trustee', TrusteeSelectType::class, ['label' => 'Syndic'])
            ->add('number', TextType::class, ['label' => 'Numéro'])
            ->add('complete', ChoiceType::class, ['label' => 'Type', 'choices' => ['0' => 'Normal', '1' => 'Complet']])
            ->add(
                'option',
                ChoiceType::class,
                ['label' => 'Option', 'choices' => ['0' => '24/24h 7/7j', '1' => '8h30-17h30 du lundi au vendredi']]
            )
            ->add('begin', DatepickerType::class, ['label' => 'Début du contrat'])
            ->add('endWarranty', DatepickerType::class, ['label' => 'Fin de garantie', 'required' => false])
            ->add('fee', MoneyType::class, ['label' => 'Redevance annuelle', 'grouping' => true])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Contract::class,
                'label' => 'Contrat',
            ]
        );
    }
}

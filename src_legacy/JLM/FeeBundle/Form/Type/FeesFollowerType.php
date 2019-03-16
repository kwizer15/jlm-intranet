<?php

/*
 * This file is part of the JLMFeeBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\FeeBundle\Form\Type;

use JLM\FeeBundle\Entity\FeesFollower;
use JLM\ModelBundle\Form\Type\DatepickerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class FeesFollowerType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('activation', DatepickerType::class, ['label' => 'Date d\'activation'])
        ->add('frequence1', TextType::class, ['label' => 'Annuelle'])
        ->add('frequence2', TextType::class, ['label' => 'Semestriellle'])
        ->add('frequence4', TextType::class, ['label' => 'Trimestrielle'])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => FeesFollower::class]);
    }
}

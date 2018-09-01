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

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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
        ->add('activation', 'datepicker', ['label' => 'Date d\'activation'])
        ->add('frequence1', null, ['label' => 'Annuelle'])
        ->add('frequence2', null, ['label' => 'Semestriellle'])
        ->add('frequence4', null, ['label' => 'Trimestrielle'])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'feesfollower';
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(['data_class' => 'JLM\FeeBundle\Entity\FeesFollower']);
    }
}

<?php

/*
 * This file is part of the JLMCommerceBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CommerceBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class BillLineType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('position', 'hidden')
            ->add('product', 'jlm_product_product_hidden', ['required'=>false])
            ->add('reference', null, ['required'=>false,'attr'=>['class'=>'input-mini']])
            ->add('designation', null, ['attr'=>['class'=>'input-xlarge']])
            ->add('description', null, ['required'=>false,'attr'=>['class'=>'input-xlarge']])
            ->add('showDescription', 'hidden')
            ->add('quantity', null, ['attr'=>['class'=>'input-mini']])
            ->add('unitPrice', 'money', ['grouping'=>true,'attr'=>['class'=>'input-mini']])
            ->add('discount', 'percent', ['precision'=>0,'attr'=>['class'=>'input-mini']])
            ->add('vat', 'percent', ['precision'=>1,'attr'=>['class'=>'input-mini']])
            ->add('isTransmitter', 'hidden')

        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
                'data_class' => 'JLM\CommerceBundle\Entity\BillLine'
        ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'jlm_commerce_bill_line';
    }
}

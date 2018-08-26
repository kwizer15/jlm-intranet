<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ContactBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class ContactType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('address', 'jlm_contact_address', ['label'=>'Adresse', 'required'=>false])
            ->add('phones', 'jlm_contact_contactphonecollection', ['label'=>'Téléphones', 'required'=>false])
            ->add('email', 'email', ['label'=>'Adresse e-mail', 'required'=>false])
//            ->add('image','jlm_core_uploaddocument',array('label'=>'Image', 'required'=>false))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'jlm_contact_contact';
    }
    
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
        ->setDefaults([
            'inherit_data' => true,
        ]);
    }
}

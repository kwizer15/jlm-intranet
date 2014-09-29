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
class PersonType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        	->add('title','choice',array('label'=>'Titre','choices'=>array('M.'=>'M.','Mme'=>'Mme','Mlle'=>'Mlle'),'attr'=>array('class'=>'input-small')))
        	->add('lastName',null,array('label'=>'Nom'))
            ->add('firstName',null,array('label'=>'Prénom','required'=>false))
            ->add('role',null,array('label'=>'Rôle','required'=>true))
            ->add('address','jlm_contact_address',array('label'=>'Adresse','required'=>false))
            ->add('fixedPhone',null,array('label'=>'Téléphone fixe','required'=>false,'attr'=>array('class'=>'input-medium')))
            ->add('mobilePhone',null,array('label'=>'Téléphone mobile','required'=>false,'attr'=>array('class'=>'input-medium')))
            ->add('fax',null,array('label'=>'Fax','required'=>false,'attr'=>array('class'=>'input-medium')))
            ->add('email','email',array('label'=>'Adresse e-mail','required'=>false,'attr'=>array('class'=>'input-xlarge')))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'jlm_contact_person';
    }
    
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
        ->setDefaults(array(
            'data_class' => 'JLM\ContactBundle\Entity\Person',
        ));
    }
}

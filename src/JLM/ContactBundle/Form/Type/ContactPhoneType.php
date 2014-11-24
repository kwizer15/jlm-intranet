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
use JLM\ContactBundle\Entity\ContactPhone;
use JLM\ContactBundle\Model\ContactInterface;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class ContactPhoneType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        	->add('label',null,array('label'=>'Libélé'))
        	->add('phone','jlm_contact_phone',array('label'=>'Numéro'))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'jlm_contact_contactphone';
    }
    
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
        ->setDefaults(array(
            'data_class' => 'JLM\ContactBundle\Entity\ContactPhone',
        	//'empty_data' => new ContactPhone($this->contact, $this->label, $this->phone),
        ));
    }
}

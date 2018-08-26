<?php

/*
 * This file is part of the  package.
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
class CorporationContactType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('person', 'jlm_contact_person_select', ['label'=>'Contact'])
            ->add('corporation', 'jlm_contact_corporation_select', ['label'=>'Groupement'])
            ->add('position', null, ['label'=>'Rôle'])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'jlm_contact_corporation_contact';
    }
    
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => 'JLM\ContactBundle\Entity\CorporationContact',
                'label' => 'Contacts de groupement',
            ]);
    }
}

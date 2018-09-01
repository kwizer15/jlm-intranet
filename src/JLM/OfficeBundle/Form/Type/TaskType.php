<?php
namespace JLM\OfficeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TaskType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('type', null, ['label' => 'Type'])
        ->add('door', 'door_hidden', ['required' => false])
        ->add('place', null, ['label' => 'Lieu concerné'])
        ->add('todo', null, ['label' => 'À faire'])
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(['data_class' => 'JLM\OfficeBundle\Entity\Task']);
    }

    public function getName()
    {
        return 'task';
    }
}

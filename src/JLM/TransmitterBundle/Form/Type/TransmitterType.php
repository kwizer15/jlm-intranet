<?php

namespace JLM\TransmitterBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use JLM\TransmitterBundle\Entity\UserGroupRepository;

class TransmitterType extends AbstractType
{
    private $id;
    
    public function __construct($id)
    {
        $this->id = $id;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $id = $this->id;
        $builder
            ->add('attribution', 'transmitter_attribution_hidden')
            ->add('userGroup', 'entity', [
                    'class'=>'JLM\TransmitterBundle\Entity\UserGroup',
                    'label'=>'Groupe utilisateur',
                    'query_builder'=> function (UserGroupRepository $er) use ($id) {
                        return $er->getFromSite($id);
                    },
                    'empty_value' => 'Choisissez...',
            ])
            ->add('model', null, ['label'=>'Type d\'émetteur','empty_value' => 'Choisissez...',])
            ->add('number', null, ['label'=>'Numéro', 'attr'=>['class'=>'input-small']])
            ->add('guarantee', null, ['label'=>'Garantie', 'attr'=>['class'=>'input-mini','placeholder'=>'MMAA']])
            ->add('userName', null, ['label'=>'Utilisateur','required'=>false])
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'JLM\TransmitterBundle\Entity\Transmitter',
            'attr'=>['class'=>'transmitter'],
        ]);
    }

    public function getName()
    {
        return 'jlm_transmitterbundle_transmittertype';
    }
}

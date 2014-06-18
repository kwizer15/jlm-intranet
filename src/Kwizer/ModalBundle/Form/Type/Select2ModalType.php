<?php

namespace Kwizer\ModalBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Select2ModalType extends AbstractType
{
    public function getParent()
    {
    	return 'genemu_jqueryselect2_entity';
    }
    
    public function getName()
    {
        return 'kwizer_select2modal';
    }
}
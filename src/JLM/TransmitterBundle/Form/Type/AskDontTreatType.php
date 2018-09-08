<?php
namespace JLM\TransmitterBundle\Form\Type;

use JLM\TransmitterBundle\Entity\Ask;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AskDontTreatType extends \JLM\OfficeBundle\Form\Type\AskDontTreatType
{
   
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(['data_class' => Ask::class]);
    }
}

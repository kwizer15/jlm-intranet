<?php
namespace JLM\TransmitterBundle\Form\Type;

use JLM\TransmitterBundle\Entity\Ask;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AskDontTreatType extends \JLM\OfficeBundle\Form\Type\AskDontTreatType
{
   
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Ask::class]);
    }
}

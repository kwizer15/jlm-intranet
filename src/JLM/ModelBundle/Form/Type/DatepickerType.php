<?php

namespace JLM\ModelBundle\Form\Type;

use Genemu\Bundle\FormBundle\Form\JQuery\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DatepickerType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(
                [
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy',
                    'years' => range(date('Y') - 5, date('Y') + 5),
                    'attr' => ['class' => 'input-small datepicker'],
                ]
            );
    }

    public function getParent()
    {
        return DateType::class;
    }
}

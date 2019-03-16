<?php

namespace JLM\TransmitterBundle\Form\Type;

use JLM\TransmitterBundle\Form\DataTransformer\AskToIntTransformer;
use JLM\ModelBundle\Form\Type\AbstractHiddenType;
use JLM\TransmitterBundle\Form\DataTransformer\AttributionToIntTransformer;

class AttributionHiddenType extends AbstractHiddenType
{

    protected function getTransformerClass()
    {
        return AttributionToIntTransformer::class;
    }
}

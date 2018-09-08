<?php

namespace JLM\ModelBundle\Form\Type;

use JLM\ContactBundle\Form\DataTransformer\PersonToIntTransformer;

class PersonHiddenType extends AbstractHiddenType
{

    protected function getTransformerClass()
    {
        return PersonToIntTransformer::class;
    }
}

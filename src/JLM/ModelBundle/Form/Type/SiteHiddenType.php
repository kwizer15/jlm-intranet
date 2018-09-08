<?php

namespace JLM\ModelBundle\Form\Type;

use JLM\ModelBundle\Form\DataTransformer\SiteToIntTransformer;

class SiteHiddenType extends AbstractHiddenType
{

    protected function getTransformerClass()
    {
        return SiteToIntTransformer::class;
    }
}

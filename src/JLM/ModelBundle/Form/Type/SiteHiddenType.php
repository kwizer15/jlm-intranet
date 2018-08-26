<?php

namespace JLM\ModelBundle\Form\Type;

use JLM\ModelBundle\Form\DataTransformer\SiteToIntTransformer;
use JLM\ModelBundle\Form\Type\AbstractHiddenType;

class SiteHiddenType extends AbstractHiddenType
{

    protected function getTransformerClass()
    {
        return 'JLM\ModelBundle\Form\DataTransformer\SiteToIntTransformer';
    }
    
    protected function getTypeName()
    {
        return 'site';
    }
}

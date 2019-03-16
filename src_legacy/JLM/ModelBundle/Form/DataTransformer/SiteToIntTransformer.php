<?php

namespace JLM\ModelBundle\Form\DataTransformer;

class SiteToIntTransformer extends ObjectToIntTransformer
{
    public function getClass()
    {
        return 'JLMModelBundle:Site';
    }

    protected function getErrorMessage()
    {
        return 'A site with id "%s" does not exist!';
    }
}

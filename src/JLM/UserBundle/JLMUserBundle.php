<?php

namespace JLM\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class JLMUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}

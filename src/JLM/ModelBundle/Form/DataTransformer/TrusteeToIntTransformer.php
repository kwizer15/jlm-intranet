<?php
namespace JLM\ModelBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;

class TrusteeToIntTransformer extends ObjectToIntTransformer
{
    public function getClass()
    {
        return 'JLMModelBundle:Trustee';
    }
    
    protected function getErrorMessage()
    {
        return 'A trustee with id "%s" does not exist!';
    }
}

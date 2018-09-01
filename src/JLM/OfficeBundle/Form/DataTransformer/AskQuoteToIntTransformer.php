<?php
namespace JLM\OfficeBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;

class AskQuoteToIntTransformer implements DataTransformerInterface
{
    /**
     * @var ObjectManager
     */
    private $om;
    
    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }
    
    /**
     * Transforms an object (askquote) to an integer (id).
     *
     * @param  AskQuote|null $entity
     * @return int
     */
    public function transform($entity)
    {
        if (null === $entity) {
            return "";
        }
        return $entity->getId();
    }
    
    /**
     * Transforms an integer (number) to an object (askquote).
     *
     * @param  int $number
     * @return AskQuote|null
     * @throws TransformationFailedException if object (askquote) is not found.
     */
    public function reverseTransform($id)
    {
        if (!$id) {
            return null;
        }
    
        
            $entity = $this->om
                ->getRepository('JLMOfficeBundle:AskQuote')
                ->find($id)
            ;
        if (null === $entity) {
            throw new TransformationFailedException(sprintf(
                'An askquote with id "%s" does not exist!',
                $id
            ));
        }
    
        return $entity;
    }
}

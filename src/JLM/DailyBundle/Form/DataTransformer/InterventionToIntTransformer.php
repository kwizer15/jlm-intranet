<?php
namespace JLM\DailyBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;

class InterventionToIntTransformer implements DataTransformerInterface
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
     * Transforms an object (quote) to an integer (id).
     *
     * @param  QuoteVariant|null $entity
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
     * Transforms an integer (number) to an object (quote).
     *
     * @param  int $number
     * @return QuoteVariant|null
     * @throws TransformationFailedException if object (quote) is not found.
     */
    public function reverseTransform($id)
    {
        if (!$id) {
            return null;
        }
    
        
            $entity = $this->om
                ->getRepository('JLMDailyBundle:Intervention')
                ->find($id)
            ;
        if (null === $entity) {
            throw new TransformationFailedException(sprintf(
                'An intervention with id "%s" does not exist!',
                $id
            ));
        }
    
        return $entity;
    }
}

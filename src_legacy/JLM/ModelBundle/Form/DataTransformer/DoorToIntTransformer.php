<?php

namespace JLM\ModelBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;

class DoorToIntTransformer implements DataTransformerInterface
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
     * Transforms an object (door) to a string (name).
     *
     * @param  Door|null $entity
     *
     * @return string
     */
    public function transform($entity)
    {
        if (null === $entity) {
            return "";
        }
        return $entity->getId();
    }

    /**
     * Transforms an int (number) to an object (door).
     *
     * @param  int $number
     *
     * @return Door|null
     * @throws TransformationFailedException if object (door) is not found.
     */
    public function reverseTransform($number)
    {
        if (!$number) {
            return null;
        }


        $entity = $this->om
            ->getRepository('JLMModelBundle:Door')
            ->find($number)
        ;
        if (null === $entity) {
            throw new TransformationFailedException(
                sprintf(
                    'A door with id "%s" does not exist!',
                    $number
                )
            );
        }

        return $entity;
    }
}

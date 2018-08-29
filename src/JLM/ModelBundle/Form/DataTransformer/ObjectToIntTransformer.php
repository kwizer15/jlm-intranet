<?php

namespace JLM\ModelBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;

abstract class ObjectToIntTransformer implements DataTransformerInterface
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
     * Transforms an object to an int.
     *
     * @param  Object|null $entity
     *
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
     * Transforms an int to an object.
     *
     * @param  int $id
     *
     * @return Object|null
     * @throws TransformationFailedException if object is not found.
     */
    public function reverseTransform($id)
    {
        if (!$id) {
            return null;
        }


        $entity = $this->om
            ->getRepository($this->getClass())
            ->find($id)
        ;
        if (null === $entity) {
            throw new TransformationFailedException(
                sprintf(
                    $this->getErrorMessage(),
                    $id
                )
            );
        }

        return $entity;
    }

    abstract public function getClass();

    protected function getErrorMessage()
    {
        return 'A ' . $this->getClass . ' object with id "%s" does not exist!';
    }
}

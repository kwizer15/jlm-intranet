<?php

/*
 * This file is part of the JLMContractBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ContractBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class ContractToStringTransformer implements DataTransformerInterface
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
     * Transforms an object (contract) to a string (name).
     *
     * @param  Contract|null $entity
     * @return string
     */
    public function transform($entity)
    {
        if (null === $entity) {
            return "";
        }
        return $entity->getNumber().' / '.$entity->getDoor()->getLocation().' / '.$entity->getDoor()->getType();
    }
    
    /**
     * Transforms a string (number) to an object (contract).
     *
     * @param  string $number
     * @return Contract|null
     * @throws TransformationFailedException if object (contract) is not found.
     */
    public function reverseTransform($string)
    {
        if (!$string) {
            return null;
        }
        $matches = [];
        if (preg_match('#(.+) / (.+) / (.+)#', $string, $matches)) {
            $entity = $this->om
                ->getRepository('JLMContractBundle:Contract')
                ->createQueryBuilder('c')
                ->leftJoin('c.door', 'd')
                ->leftJoin('d.type', 't')
                ->where('c.number = :number')
                ->andWhere('d.location = :location')
                ->andWhere('t.name = :type')
                ->setParameter('number', trim($matches[1]))
                ->setParameter('location', trim($matches[2]))
                ->setParameter('type', trim($matches[3]))
                ->getQuery()->getResult();
        }
            
        if (null === $entity) {
            throw new TransformationFailedException(sprintf(
                'A contract with name "%s" does not exist!',
                $string
            ));
        }
        
        return $entity[0];
    }
}

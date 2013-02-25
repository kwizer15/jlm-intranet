<?php
namespace JLM\ModelBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use JLM\ModelBundle\Entity\City;

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
	 * Transforms an object (trustee) to a string (name).
	 *
	 * @param  Trustee|null $entity
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
	 * Transforms a string (number) to an object (trustee).
	 *
	 * @param  string $number
	 * @return Trustee|null
	 * @throws TransformationFailedException if object (trustee) is not found.
	 */
	public function reverseTransform($string)
	{
		if (!$string)
		{
			return null;
		}
			
		if ($model = preg_match('#(.+) / (.+) / (.+)#',$string,$matches))
			$entity = $this->om
				->getRepository('JLMModelBundle:Contract')
				->createQueryBuilder('c')
				->leftJoin('c.door','d')
				->leftJoin('d.type','t')
				->where('c.number = :number')
				->andWhere('d.location = :location')
				->andWhere('t.name = :type')
				->setParameter('number', trim($matches[1]))
				->setParameter('location', trim($matches[2]))
				->setParameter('type', trim($matches[3]))
				->getQuery()->getResult();		
		
			
		if (null === $entity) {
			
			throw new TransformationFailedException(sprintf(
					'A contract with name "%s" does not exist!',
					$string
			));
		}
		
		return $entity[0];
	}
}
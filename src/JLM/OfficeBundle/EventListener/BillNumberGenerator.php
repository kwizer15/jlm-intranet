<?php
namespace JLM\OfficeBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use JLM\OfficeBundle\Entity\Bill;

class BillNumberGenerator
{
	/**
	 * PrePersist
	 * @param LifecycleEventArgs $args
	 */
	public function prePersist(LifecycleEventArgs $args)
	{
		$entity = $args->getEntity();
		
		if ($entity instanceof Bill)
		{
			$em = $args->getEntityManager();
			
			$number = $entity->getCreation()->format('ym');
			$n = ($em->getRepository('JLMOfficeBundle:Bill')->getLastNumber() + 1);
			for ($i = strlen($n); $i < 4 ; $i++)
				$number.= '0';
			$number.= $n;
			$entity->setNumber($number);
			
			$lines = $entity->getLines();
			
			foreach ($lines as $line)
			{
				$line->setBill($entity);
				$em->persist($line);
			}
			
			$interv = $entity->getIntervention();
			if ($interv !== null)
			{
				$interv->setBill($entity);
				$em->persist($interv);
			}
		}
	}
}
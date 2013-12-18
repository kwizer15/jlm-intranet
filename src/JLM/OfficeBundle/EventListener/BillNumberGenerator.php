<?php
namespace JLM\OfficeBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use JLM\OfficeBundle\Entity\Bill;

class BillNumberGenerator
{
	public function prePersist(LifecycleEventArgs $args)
	{
		$entity = $args->getEntity();
		
		if ($entity instanceof Bill)
		{
			// Seulement pour les nouvelles entrées
			if ($entity->getId() === null)
			{
				$em = $args->getEntityManager();
				$number = $entity->getCreation()->format('ym');
				$n = ($em->getRepository('JLMOfficeBundle:Bill')->getLastNumber() + 1);
				for ($i = strlen($n); $i < 4 ; $i++)
					$number.= '0';
				$number.= $n;
				$entity->setNumber($number);
				

			}
		}
	}
}
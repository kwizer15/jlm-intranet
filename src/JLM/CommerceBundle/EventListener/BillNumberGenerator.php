<?php

/*
 * This file is part of the JLMCommerceBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CommerceBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use JLM\CommerceBundle\Entity\Bill;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
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
			
			if ($entity->getNumber() === null)
			{
				$number = $entity->getCreation()->format('ym');
				$n = ($em->getRepository('JLMCommerceBundle:Bill')->getLastNumber() + 1);
				for ($i = strlen($n); $i < 4 ; $i++)
					$number.= '0';
				$number.= $n;
				$entity->setNumber($number);
			}
			
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
<?php
namespace JLM\DailyBundle\Pdf;

use JLM\DailyBundle\Entity\Fixing;
use JLM\DailyBundle\Entity\Intervention;

class FixingReport extends InterventionReport
{
	public static function get(Intervention $entity)
	{
		return parent::get($entity);
	}
	
	protected function _getTitle()
	{
		return 'Rapport d\'intervention';
	}
	
	protected function _report(Intervention $entity)
	{	
		if (!$entity instanceof Fixing)
		{
			throw new \Exception('entity must be a Fixing');
		}
		$this->ln(3);
		$this->cellH3('Constat');
		$this->cellLi($entity->getObservation());
		$this->ln(3);
		$this->cellH3('Action menée');
		$this->cellLi($entity->getReport());
		
		if ($entity->getRest() != null)
		{
			$this->ln(15);
			if ($entity->getAskQuote())
			{
				$this->cellStrong('Nous vous enverrons dans les meilleurs délais, un devis de remise en état concernant les travaux de réparation nécessaire'); // à savoir :');
			}
			elseif ($entity->getWork())
			{
				$this->cellStrong('Nous nous engageons pour le remplacement des pièces nécessaires le plus rapidement possible selon la disponibilité de notre fabriquant');// à savoir :');
			}
			else 
			{
				$this->cellStrong('Reste à faire :');
			}
	//		$this->ln(3);
	//		$this->cellLiStrong($entity->getRest());
		}
		
	}
}
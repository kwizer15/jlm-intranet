<?php
namespace JLM\DailyBundle\Pdf;

use \JLM\DefaultBundle\Pdf\FPDFext;

class Tomorrow extends FPDFext
{
	private $entities;
	private $date;
	
	public static function get(\DateTime $date, $entities)
	{
		$pdf = new self();
		$pdf->_init();
		$pdf->_header($date);
		foreach ($entities as $entity)
			$pdf->_show($entity,$date);
		return $pdf->Output('','S');
	}
	
	private function _init()
	{
		$this->aliasNbPages();
		$this->setFillColor(200);
		$this->addPage('L');
	}
	
	private function _header(\DateTime $date)
	{
		$this->setFont('Arial','B',18);
		$this->cell(0,12,'Interventions du '.$date->format('d/m/Y'),1,1,'C',true);
		$this->ln(5);
		$this->setFont('Arial','B',11);
		$this->setWidths(array(24,77,8,109,30,29));
		$this->row(array('Type','Affaire','Ctr','Raison','Contact','Technicien'),6,1,true);
		$this->setFont('Arial','',10);
	}
	
	private function _show($entity,$date)
	{
		$types = array(
				'fixing' => 'Dépannage',
				'equipment' => 'Matériel',
				'maintenance' => 'Entretien',
				'work' => 'Travaux',
		);
		$datas[0] = $types[$entity->getType()];
		if ($entity->getType() == 'equipment')
		{
			$datas[1] = $entity->getPlace();
			$datas[2] = '';
			$datas[4] = '';
		}
		else
		{
			if ($entity->getDoor())
			{
				$datas[1] = $entity->getDoor()->getType()
					.' - '
					.$entity->getDoor()->getLocation()
					.chr(10)
					.$entity->getDoor()->getStreet()
					.chr(10)
					.$entity->getDoor()->getSite()->getAddress()->getCity()
				;
			}
			else
				$datas[1] = $entity->getPlace();
			$datas[2] = ($entity->getContract() == 'Hors contrat') ? 'HC' : $entity->getContract();
			$datas[4] = $entity->getContactName().chr(10).$entity->getContactPhones();
		}
		$datas[3] = $entity->getReason();
		$datas[5] = '';
		foreach($entity->getShiftTechnicians() as $tech)
		{
			if ($tech->getBegin() == $date)
			{
				if ($datas[5] != '')
					$datas[5] .= chr(10);
				$datas[5] .= $tech->getTechnician();
			}
		}
		$this->row($datas,5,1,false);	
	}
}
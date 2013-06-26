<?php
namespace JLM\DailyBundle\Pdf;

use \JLM\DefaultBundle\Pdf\FPDFext;
use \JLM\ModelBundle\Entity\Door as ModelDoor;
use \JLM\DailyBundle\Entity\ShiftTechnician;

class Door extends FPDFext
{
	
	public static function get($door,$entities)
	{
		$pdf = new self();
		$pdf->_init();
		$pdf->_header($door);
		

		foreach ($entities as $entity)
			$pdf->_show($entity);
		return $pdf->Output('','S');
	}
	
	private function _init()
	{
		$this->aliasNbPages();
		$this->setFillColor(200);
		$this->addPage('L');
	}
	
	private function _header(ModelDoor $door)
	{
		$this->setFont('Arial','B',18);
		$this->multicell(0,12,$door->toString(),1,1,'C',true);
		$this->ln(5);
		$this->setFont('Arial','B',11);
		$this->setWidths(array(24,24,8,96,96,29));
		$this->row(array('Date','Type','Ctr','Raison','Rapport','Technicien'),6,1,true);
		$this->setFont('Arial','',10);
	}
	
	private function _show(ShiftTechnician $entity)
	{
		$shifting = $entity->getShifting();
		$types = array(
				'fixing' => 'Dépannage',
				'maintenance' => 'Entretien',
				'work' => 'Travaux',
		);
		$datas[0] = $entity->getBegin()->format('d/m/Y');
		$datas[1] = $types[$shifting->getType()];
		$datas[2] = ($shifting->getContract() == 'Hors contrat') ? 'HC' : $shifting->getContract();
		$datas[3] = $shifting->getReason();
		if ($entity->getComment())
			$datas[4] = $entity->getComment();
		else
		{
			$interv = $entity->getIntervention();
			$datas[4] = ' rapport : '.$interv->getReport();
			if ($interv->getRest())
				$datas[4] .= chr(10).chr(10).'Reste à faire :'.chr(10).$interv->getRest();
			continue;
		}
		$datas[5] = $entity->getTechnician().'';
		$this->row($datas,5,1,false);
	}
}
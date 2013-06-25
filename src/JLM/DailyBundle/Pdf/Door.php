<?php
namespace JLM\DailyBundle\Pdf;

use \JLM\DefaultBundle\Pdf\FPDFext;

class Door extends FPDFext
{
	private $entities;
	private $door;
	
	public static function get(\DateTime $date, $entities, $standby)
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
	
	private function _header($door)
	{
		$this->setFont('Arial','B',18);
		$this->multicell(0,12,$door->toString(),1,1,'C',true);
		$this->ln(5);
		$this->setFont('Arial','B',11);
		$this->setWidths(array(24,77,8,69,70,29));
		$this->row(array('Date','Type','Ctr','Raison','Rapport','Technicien'),6,1,true);
		$this->setFont('Arial','',10);
	}
	
	private function _show($entity,$date)
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
		$datas[4] = $shifting->getReport();
		if ($shifting->getRest())
			$datas[4] .= chr(10).chr(10).'Reste à faire :'.chr(10).$shifting->getRest();
		$datas[3] = $shifting->getReason();
		$datas[5] = $entity->getTechnician().'';
		$this->row($datas,5,1,false);
	}
}
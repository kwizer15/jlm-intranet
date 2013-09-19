<?php
namespace JLM\OfficeBundle\Pdf;

use \JLM\DefaultBundle\Pdf\FPDFext;
use \JLM\DailyBundle\Entity\Intervention;

class BillList extends FPDFext
{
	private $entity;
	private $end = false;
	private $head = true;
	

	
	public static function get($entities)
	{
		
		$pdf = new self();
		$pdf->_init();
		$pdf->_header();
		foreach ($entities as $entity)
			$pdf->_line($entity);
		return $pdf->Output('','S');
	}
	
	public function _init()
	{
		$this->aliasNbPages();
		$this->setFillColor(200);
		$this->addPage('L');
	}
	
	public function _header()
	{
		$this->setFont('Arial','B',18);
		$this->multicell(0,12,'Liste des intervanetions à facturer',1,1,'C',true);
		$this->ln(5);
		$this->setFont('Arial','B',11);
		$this->setWidths(array(24,63,24,8,79,79)); // -29
		$this->row(array('Date','Affaire','Type','Ctr','Raison','Rapport'),6,1,true);
		$this->setFont('Arial','',10);
	}
	
	private function _line(Intervention $entity)
	{
		$types = array(
				'fixing' => 'Dépannage',
				'maintenance' => 'Entretien',
				'work' => 'Travaux',
		);
		$dayTrans = array('dimanche','lundi','mardi','mercredi','jeudi','vendredi','samedi');
		$datas[0] = $dayTrans[$entity->getClose()->format('w')].chr(10).$entity->getClose()->format('d/m/Y');
		$datas[1] = $entity->getDoor()->getSite()->getAddress().'';
		$datas[2] = $types[$entity->getType()];
		$datas[3] = ($entity->getContract() == 'Hors contrat') ? 'HC' : $entity->getDynContract();
		$datas[4] = $entity->getReason();
		$datas[5] = 'Rapport :'.chr(10).$entity->getReport();
		if ($entity->getRest())
			$datas[5] .= chr(10).chr(10).'Reste à faire :'.chr(10).$entity->getRest();
		$this->row($datas,5,1,false);
	}

}
<?php
namespace JLM\DailyBundle\Pdf;

use \JLM\DefaultBundle\Pdf\FPDFext;
use \JLM\ModelBundle\Entity\Door as ModelDoor;
use \JLM\DailyBundle\Entity\ShiftTechnician;
use JLM;

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
		$this->setWidths(array(24,34,24,8,79,79,29));
		$this->row(array('Date','Contact','Type','Ctr','Raison','Rapport','Technicien'),6,1,true);
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
		$dayTrans = array('dimanche','lundi','mardi','mercredi','jeudi','vendredi','samedi');
		$datas[0] = $dayTrans[$entity->getBegin()->format('w')].chr(10).$entity->getBegin()->format('d/m/Y');
		$datas[1] = 'le '.$shifting->getCreation()->format('d/m/Y H:i').chr(10)
			.$shifting->getContactName().chr(10)
			.$shifting->getContactPhones();
		$datas[2] = $types[$shifting->getType()];
		$datas[3] = ($shifting->getContract() == 'Hors contrat') ? 'HC' : $shifting->getContract();
		$datas[4] = $shifting->getReason();
		$datas[5] = '';
		if ($entity->getComment())
		{
			$datas[5] = 'Technicien :'.chr(10).$entity->getComment().chr(10).chr(10);
		}
		else
		{
		    $interv = $entity->getShifting();
		    if ($interv instanceof JLM\DailyBundle\Entity\Fixing)
		    {
		        $datas[5] = 'Constat :'.chr(10).$interv->getObservation().chr(10).chr(10);
		    }
			
			$datas[5] .= 'Action menée :'.chr(10).$interv->getReport();
			if ($interv->getRest())
				$datas[5] .= chr(10).chr(10).'Reste à faire :'.chr(10).$interv->getRest();
		}
		$datas[6] = $entity->getTechnician().'';
		if ($entity->getEnd())
		{
			$datas[6] .= chr(10).$entity->getBegin()->format('H\hi').' - '.$entity->getEnd()->format('H\hi').chr(10).$entity->getTime()->format('%h:%I');
		}
		$this->row($datas,5,1,false);
	}
}
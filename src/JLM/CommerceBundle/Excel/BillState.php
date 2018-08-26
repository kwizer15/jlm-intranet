<?php
namespace JLM\CommerceBundle\Excel;

class BillState
{
   
    public function __construct($service)
    {
        $this->service = $service;
        $this->object = $service->createPHPExcelObject();
    }
    
    public function createList(array $list)
    {
        
        $this->object->getProperties()->setCreator("JLM Entreprise")
        ->setLastModifiedBy("JLM Entreprise")
        ->setTitle("Etat des factures");
        
        $as = $this->object->setActiveSheetIndex(0);
        $titles = ['A'=>'Date','B'=>'Numéro','C'=>'Client','D'=>'HT','E'=>'TVA','F'=>'TTC'];
        foreach ($titles as $col => $value) {
            $as->setCellValue($col.'1', $value);
        }
        $row = 2;
        
        foreach ($list as $line) {
            $as->setCellValue('A'.$row, $line['date']);
            $as->setCellValue('B'.$row, $line['number']);
            $as->setCellValue('C'.$row, $line['manager']);
            $as->setCellValue('D'.$row, $line['ht']);
            $as->setCellValue('E'.$row, $line['tva']);
            $as->setCellValue('F'.$row, $line['ttc']);
            $row++;
        }
        
        $this->object->getActiveSheet()->setTitle('Etat des factures');
        $this->object->setActiveSheetIndex(0);
        
        return $this;
    }
    
    public function getResponse()
    {
        $writer = $this->service->createWriter($this->object, 'Excel5');
        $response = $this->service->createStreamedResponse($writer);
        // adding headers
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename=bill_state.xls');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        
        return $response;
    }
}

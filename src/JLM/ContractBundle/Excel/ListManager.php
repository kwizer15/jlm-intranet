<?php
namespace JLM\ContractBundle\Excel;

class ListManager
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
        ->setTitle("Liste des syndics");
        
        $as = $this->object->setActiveSheetIndex(0);
        $titles = ['A'=>'Syndic','B'=>'Nombre d\'installations','C'=>'Gestionnaire'];
        foreach ($titles as $col => $value) {
            $as->setCellValue($col.'1', $value);
        }
        $row = 2;
        
        foreach ($list as $line) {
            $as->setCellValue('A'.$row, $line['manager']);
            $as->setCellValue('B'.$row, $line['count_installs']);
            $as->setCellValue('C'.$row, $line['gestionnaire']);
            $row++;
        }
        
        $this->object->getActiveSheet()->setTitle('Liste syndics');
        $this->object->setActiveSheetIndex(0);
        
        return $this;
    }
    
    public function getResponse()
    {
        $writer = $this->service->createWriter($this->object, 'Excel5');
        $response = $this->service->createStreamedResponse($writer);
        // adding headers
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename=liste_syndic.xls');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        
        return $response;
    }
}

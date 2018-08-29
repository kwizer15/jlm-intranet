<?php
namespace JLM\TransmitterBundle\Pdf;

use JLM\DefaultBundle\Pdf\FPDFext;
use JLM\ModelBundle\Entity\Site;

class SiteList extends FPDFext
{
    private $withHeader = true;
    private $count = 0;
    private $countTemp = 0;
    private $lastUserGroup = '';
    
    public static function get(Site $entity, $transmitters, $withHeader = true)
    {
        $pdf = new self();
        $pdf->setWithHeader($withHeader);
        $pdf->init($entity);
        foreach ($transmitters as $transmitter) {
            $pdf->show($transmitter);
        }
        $pdf->customFooter();
        return $pdf->Output('', 'S');
    }
    
    private function init($entity)
    {
        $this->aliasNbPages();
        
        $this->setWidths([21, 44, 14, 31, 50, 15, 15]);
        $this->addPage('P');
        $this->setY(55);
        $this->setFont('Arial', 'B', 16);
        $this->cell(0, 9, 'Liste générale', 0, 0);
        $this->setXY(100, 55);
        $this->setFont('Arial', 'B', 12);
        $this->cell(100, 6, 'Affaire :', 0, 2);
        $this->setFont('Arial', '', 12);
        $this->multiCell(100, 6, $entity->toString(), 0);
        $this->ln(6);
        $this->tabHeader();
    }
    
    
    private function show($entity)
    {
        if ($this->lastUserGroup != $entity->getUserGroup().'' && $this->countTemp > 0) {
            $this->setFont('Arial', 'B', 10);
            $this->setFillColor(200);
            $this->cell(0, 6, 'Total '.$this->lastUserGroup.' : '.$this->countTemp, 1, 1, 'L', 1);
            $this->countTemp = 0;
            $this->ln(6);
            $this->tabHeader();
        }
        $this->setFont('Arial', '', 10);
        $state = $entity->getModel();
        if ($entity->getReplacedTransmitter() !== null) {
            $state = 'Remplacé par le '.$entity->getReplacedTransmitter()->getNumber();
        }
        $datas = [
                  $entity->getAttribution()->getCreation()->format('d/m/Y'),
                  $entity->getUserGroup().'',
                  $entity->getNumber(),
                  $state,
                  $entity->getUserName(),
                  '',
                  '',
                 ];
        $this->setFillColor(150);
        $this->row($datas, 5, 1, !$entity->getIsActive());
        if ($entity->getIsActive()) {
            $this->count++;
            $this->countTemp++;
        }
        $this->lastUserGroup = $entity->getUserGroup().'';
    }
    
    public function header()
    {
        if ($this->getWithHeader()) {
            $this->Image($_SERVER['DOCUMENT_ROOT'].'/bundles/jlmcommerce/img/pdf-header-comp.jpg', 10, 4, 190);
        }

        if ($this->pageNo() > 1) {
            $this->setY(55);
            $this->tabHeader();
        }
    }
    
    public function customFooter()
    {
        if ($this->count != $this->countTemp) {
            $this->setFont('Arial', 'B', 10);
            $this->setFillColor(200);
            $this->cell(0, 6, 'Total '.$this->lastUserGroup.' : '.$this->countTemp, 1, 1, 'L', 1);
            $this->countTemp = 0;
            $this->ln(3);
        }
        $this->setFont('Arial', 'B', 12);
        $this->cell(0, 10, 'Total : '.$this->count);
    }
    
    public function footer()
    {
        if ($this->getWithHeader()) {
            $this->Image($_SERVER['DOCUMENT_ROOT'].'/bundles/jlmcommerce/img/pdf-footer.jpg', 50, 280, 110);
        }
        
        $this->SetY(-15);
        // Police Arial italique 8
        $this->SetFont('Arial', '', 12);
        // Numéro de page
        $this->Cell(0, 10, $this->PageNo().'/{nb}', 0, 0, 'R');
    }
    
    private function tabHeader()
    {
        $this->setFont('Arial', 'B', 11);
        $this->setFillColor(200);
        $this->row(['Date', 'Groupe utilisateur', 'Num.', 'Type', 'Nom', 'Appt.', 'Place'], 6, 1, true);
    }
    
    public function setWithHeader($with)
    {
        $this->withHeader = (bool)$with;
        return $this;
    }
    
    public function getWithHeader()
    {
        return $this->withHeader;
    }
    
    public function setEntity($entity)
    {
        $this->entity = $entity;
        return $this;
    }
}

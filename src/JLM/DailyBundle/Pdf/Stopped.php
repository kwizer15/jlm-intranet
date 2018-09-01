<?php
namespace JLM\DailyBundle\Pdf;

use \JLM\DefaultBundle\Pdf\FPDFext;

class Stopped extends FPDFext
{
    public static function get($entities)
    {
        $pdf = new self();
        $pdf->init();
        $pdf->customHeader(new \DateTime);
        foreach ($entities as $entity) {
            $pdf->show($entity);
        }
        return $pdf->Output('', 'S');
    }
    
    private function init()
    {
        $this->aliasNbPages();
        $this->setFillColor(200);
        $this->addPage('L');
    }
    
    private function customHeader(\DateTime $date)
    {
        $this->setFont('Arial', 'B', 18);
        $this->cell(0, 12, 'Portes à l\'arrêt au '.$date->format('d/m/Y'), 1, 1, 'C', true);
        $this->ln(5);
        $this->setFont('Arial', 'B', 11);
        $this->setWidths([70, 70, 70, 9, 60]);
        $this->row(['Syndic', 'Affaire', 'Installation', 'Ctr', 'Notes'], 6, 1, true);
        $this->setFont('Arial', '', 10);
    }
    
    private function show($entity)
    {
        $datas = [
                  $entity->getTrustee().'',
                  $entity->getAddress()->toString(),
                  $entity->getType().' - '.$entity->getLocation(),
                  $entity->getActualContract().'',
                  'Depuis le '.$entity->getLastStop()->getBegin()->format('d/m/Y').chr(10)
                    .$entity->getLastStop()->getReason().chr(10).chr(10)
                    .$entity->getLastStop()->getState(),
                 ];
        $this->row($datas, 5, 1, false);
    }
}

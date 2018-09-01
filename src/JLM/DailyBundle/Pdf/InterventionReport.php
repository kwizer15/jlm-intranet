<?php
namespace JLM\DailyBundle\Pdf;

use \JLM\DefaultBundle\Pdf\FPDFext;
use JLM\DailyBundle\Entity\Intervention;

abstract class InterventionReport extends FPDFext
{
    abstract protected function getTitle();
    
    abstract protected function report(Intervention $entity);
    
    protected function show(Intervention $entity)
    {
        $trustee = $entity->getDoor()->getTrustee();
        $this->setX(120);
        $this->setFont('Arial', 'B', 11);
        $this->cell(0, 5, $trustee->getName(), 0, 2);
        $this->setX(120);
        $this->setFont('Arial', '', 11);
        $this->multiCell(0, 5, $trustee->getAddress());
        $this->ln(10);
        $this->cellTitle($this->getTitle());
        $this->cellIntro('Nous vous transmettons le rapport d\'intervention du '
                .$entity->getLastDate()->format('d/m/Y')
                .' qui fait suite à votre demande par '
                .$entity->getAskMethod().' :');
        $this->ln(10);
        $this->cellH1($entity->getDoor()->getSite().'');
        $this->cellH2($entity->getDoor()->getType().' - '.$entity->getDoor()->getLocation());
    }
    
    public static function get(Intervention $entity)
    {
        $pdf = new static();
        $pdf->init();
        $pdf->show($entity);
        $pdf->report($entity);
        return $pdf->Output('', 'S');
    }
    
    protected function getStandardFontName()
    {
        return 'Arial';
        
        // Normalement
        return 'Calibri';
    }
    
    protected function cellTitle($txt)
    {
        $this->setTextColor(79, 129, 189);
        $this->setFont($this->getStandardFontName(), '', 26);
        $this->cell(0, 20, mb_strtoupper($txt, 'UTF-8'), 0, 1, 'L');
    }
    
    protected function cellH1($txt)
    {
        $this->ln(3);
        $this->setFillColor(79, 129, 189);
        $this->setDrawColor(79, 129, 189);
        $this->setTextColor(255, 255, 255); // white
        $this->setFont($this->getStandardFontName(), 'B', 11);
        $this->multiCell(0, 7, mb_strtoupper($txt, 'UTF-8'), 1, 'L', true);
    }
    
    protected function cellH2($txt)
    {
        $this->ln(3);
        $this->setFillColor(219, 229, 241);
        $this->setDrawColor(219, 229, 241);
        $this->setTextColor(0, 0, 0);   // black
        $this->setFont($this->getStandardFontName(), '', 11);
        $this->multiCell(0, 7, mb_strtoupper($txt, 'UTF-8'), 1, 'L', true);
    }
    
    protected function cellH3($txt)
    {
        $this->ln(6);
        $this->setDrawColor(79, 129, 189);
        $this->setTextColor(36, 63, 96);
        $this->setFont($this->getStandardFontName(), '', 11);
        $this->multiCell(0, 7, mb_strtoupper($txt, 'UTF-8'), 'LT', 'L', false);
        $this->ln(3);
    }
    
    protected function cellIntro($txt)
    {
        $this->setTextColor(0, 0, 0);
        $this->setFont($this->getStandardFontName(), '', 11);
        $this->multiCell(0, 5, $txt, 0, 'L', false);
    }
    
    protected function cellP($txt)
    {
        $this->setTextColor(0, 0, 0);
        $this->setFont($this->getStandardFontName(), '', 10);
        $this->multiCell(0, 5, $txt, 0, 'L', false);
    }
    
    private function formatLi($txt)
    {
        $txt = '*'.$txt;
        $txt = str_replace(chr(10), chr(10).'*', $txt);
        $txt = str_replace('*- ', '', $txt);
        $txt = str_replace('*', '', $txt);
        $txt = '    - '.$txt;
        $txt = str_replace(chr(10), chr(10).'    - ', $txt);
        
        return $txt;
    }
    
    protected function cellLi($txt)
    {
        $this->setTextColor(0, 0, 0);
        $this->setFont($this->getStandardFontName(), '', 10);
        $this->multiCell(0, 5, $this->formatLi($txt), 0, 'L', false);
    }
    
    protected function cellStrong($txt)
    {
        $this->setTextColor(0, 0, 0);
        $this->setFont($this->getStandardFontName(), 'B', 10);
        $this->multiCell(0, 5, $txt, 0, 'L', false);
    }
    
    protected function cellLiStrong($txt)
    {
        $this->setTextColor(0, 0, 0);
        $this->setFont($this->getStandardFontName(), 'B', 10);
        $this->multiCell(0, 5, $this->formatLi($txt), 0, 'L', false);
    }
    
    private function init()
    {
        $this->aliasNbPages();
        $this->addPage('P');
    }
    
    public function header()
    {
        $this->Image($_SERVER['DOCUMENT_ROOT'].'bundles/jlmoffice/img/pdf-header-comp.jpg', 10, 4, 190);
        $this->setFont('Arial', 'B', 24);
        $this->ln(50);
    }
    
    public function footer()
    {
        $this->image($_SERVER['DOCUMENT_ROOT'].'bundles/jlmoffice/img/pdf-footer.jpg', 50, 280, 110);
    }
}

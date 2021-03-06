<?php
namespace JLM\ProductBundle\Pdf;

use JLM\DefaultBundle\Pdf\FPDFext;
use JLM\ProductBundle\Model\StockInterface;

class Stock extends FPDFext
{
    public static function get($stocks)
    {
        $pdf = new self();
        $pdf->init();
        foreach ($stocks as $stock) {
            $pdf->show($stock);
        }
        $pdf->customFooter();
        
        return $pdf->Output('', 'S');
    }
    
    protected function init()
    {
        $this->aliasNbPages();
        
        $this->setWidths([40, 90, 15, 20, 25]); // = 190
        $this->addPage('P');
        $this->tabHeader();
    }
    
    protected function tabHeader()
    {
        $this->setFont('Arial', 'B', 9);
        $this->setFillColor(200);
        $this->row(['Réference', 'Designation', 'Stock', 'Valeur', 'Total'], 5, 1, true);
    }
    
    protected function show(StockInterface $entity)
    {
        $this->setFont('Arial', '', 8);
        $datas = [
                  $entity->getProductReference(),
                  $entity->getProductName(),
                  $entity->getQuantity(),
                  number_format($entity->getProduct()->getPurchasePrice(), 2, ',', ' ').' €',
                  number_format($entity->getQuantity() * $entity->getProduct()->getPurchasePrice(), 2, ',', ' ').' €',
                 ];
        $this->row($datas, 4, 1);
    }
    
    public function customFooter()
    {
    }
    
    public function footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', '', 9);
        $this->Cell(0, 10, $this->PageNo().'/{nb}', 0, 0, 'R');
    }
}

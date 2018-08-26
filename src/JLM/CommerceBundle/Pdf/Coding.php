<?php

/*
 * This file is part of the  package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CommerceBundle\Pdf;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class Coding extends \fpdf\FPDF
{
    private $entity;
    private $end = false;

    public static function get($entity)
    {
        $pdf = new self();
        $pdf->setEntity($entity);
        $pdf->_init();

        return $pdf->Output('', 'S');
    }

    private function setEntity($entity)
    {
        $this->entity = $entity;

        return $this;
    }

    private function _init()
    {
        $this->aliasNbPages();
        $this->addPage('L');

        $content = array_fill(0, 4, array_fill(0, 13, ''));
        $fill = [
                [255,204,153],
                [255,204,153],
                [252,213,180],
                [252,213,180],
        ];
        $content[0][1] = utf8_decode(str_replace(chr(10), ' / ', $this->entity->getQuote()->getDoorCp()));
        $content[1][1] = $this->entity->getQuote()->getCreation()->format('d/m/Y');
        $content[2] = ['Q','fourniture','PA','taux','remise','PU','frais','port','PAHT','coef','marge','PU HT','PVHT'];

        $totalpurchase = $totalpurchaseFourniture = 0;
        $totalsell = 0;
        foreach ($this->entity->getLines() as $line) {
            if (!$line->isService() && $line->getReference() !== 'TITLE' && $line->getReference() !== 'ST') {
                $denom = ($line->getPurchasePrice()*(1-$line->getDiscountSupplier())*($line->getExpenseRatio()+1));
                $p = ($denom != 0) ? ( ($line->getUnitPrice() - $line->getShipping()) / $denom - 1 ) * 100 : 0;
                $content[] = [
                        number_format($line->getQuantity(), 0, ',', ' '),
                        utf8_decode($line->getDesignation()),
                        number_format($line->getPurchasePrice(), 2, ',', ' ').' '.chr(128),
                        number_format($line->getDiscountSupplier()*100, 0, ',', ' ').' %',
                        number_format($line->getPurchasePrice()*$line->getDiscountSupplier(), 2, ',', ' ').' '.chr(128),
                        number_format($line->getPurchasePrice()*(1-$line->getDiscountSupplier()), 2, ',', ' ').' '.chr(128),
                        number_format($line->getExpenseRatio()+1, 1, ',', ' '),
                        number_format($line->getShipping(), 2, ',', ' ').' '.chr(128),
                        number_format($line->getQuantity()*$line->getPurchasePrice()*(1-$line->getDiscountSupplier())*($line->getExpenseRatio()+1)+$line->getShipping(), 2, ',', ' ').' '.chr(128),
                        number_format($p, 0, ',', ' ').' %',
                        number_format($line->getQuantity()*($line->getUnitPrice()-($line->getPurchasePrice()*(1-$line->getDiscountSupplier())*($line->getExpenseRatio()+1)+$line->getShipping())), 2, ',', ' ').' '.chr(128),
                        number_format($line->getUnitPrice(), 2, ',', ' ').' '.chr(128),
                        number_format($line->getQuantity()*$line->getUnitPrice(), 2, ',', ' ').' '.chr(128),
                ];
                $totalpurchase += $line->getQuantity()*$line->getPurchasePrice()*(1-$line->getDiscountSupplier())*($line->getExpenseRatio()+1)+$line->getShipping();
                $totalsell += $line->getQuantity()*$line->getUnitPrice();
                $totalpurchaseFourniture += $line->getQuantity()*$line->getPurchasePrice()*(1-$line->getDiscountSupplier());
                $fill[] = [255,255,255];
            }
        }
        $subtotal = array_fill(0, 13, '');
        $subtotal[1] = 'achat';
        $subtotal[8] = number_format($totalpurchase, 2, ',', ' ').' '.chr(128);
        $subtotal[12] = number_format($totalsell, 2, ',', ' ').' '.chr(128);
        $content[] = $subtotal;
        $fill[] = [192,192,192];
        foreach ($this->entity->getLines() as $line) {
            if ($line->isService()) {
                $content[] = [
                        number_format($line->getQuantity(), 0, ',', ' '),
                        utf8_decode($line->getDesignation()),
                        number_format($line->getPurchasePrice(), 2, ',', ' ').' '.chr(128),
                        number_format($line->getDiscountSupplier()*100, 0, ',', ' ').' %',
                        number_format($line->getPurchasePrice()*$line->getDiscountSupplier(), 2, ',', ' ').' '.chr(128),
                        number_format($line->getPurchasePrice()*(1-$line->getDiscountSupplier()), 2, ',', ' ').' '.chr(128),
                        number_format($line->getExpenseRatio()+1, 1, ',', ' '),
                        number_format($line->getShipping(), 2, ',', ' ').' '.chr(128),
                        number_format($line->getQuantity()*$line->getPurchasePrice()*(1-$line->getDiscountSupplier())*($line->getExpenseRatio()+1)+$line->getShipping(), 2, ',', ' ').' '.chr(128),
                        number_format((($line->getUnitPrice()-$line->getShipping())/($line->getPurchasePrice()*(1-$line->getDiscountSupplier())*($line->getExpenseRatio()+1))-1)*100, 0, ',', ' ').' %',
                        number_format($line->getQuantity()*($line->getUnitPrice()-($line->getPurchasePrice()*(1-$line->getDiscountSupplier())*($line->getExpenseRatio()+1)+$line->getShipping())), 2, ',', ' ').' '.chr(128),
                        number_format($line->getUnitPrice(), 2, ',', ' ').' '.chr(128),
                        number_format($line->getQuantity()*$line->getUnitPrice(), 2, ',', ' ').' '.chr(128),
                ];
                $totalpurchase += $line->getQuantity()*$line->getPurchasePrice()*(1-$line->getDiscountSupplier())*($line->getExpenseRatio()+1)+$line->getShipping();
                $totalsell += $line->getQuantity()*$line->getUnitPrice();
                $fill[] = [255,255,255];
            }
        }
        $total = array_fill(0, 13, '');
        $total[1] = 'total';
        $total[8] = number_format($totalpurchase, 2, ',', ' ').' '.chr(128);
        $total[12] = number_format($totalsell, 2, ',', ' ').' '.chr(128);
        $content[] = $total;
        $fill[] = [255,255,0];
        $content[] = ['',
                utf8_decode('PV'),
                utf8_decode('remise %'),
                number_format($this->entity->getDiscount(), 0, ',', ' ').' %',
                number_format($totalsell*$this->entity->getDiscount(), 2, ',', ' ').' '.chr(128),
                '',
                '',
                '',
                '',
                utf8_decode('reste'),
                number_format(($totalsell*(1-$this->entity->getDiscount()))-$totalpurchase, 2, ',', ' ').' '.chr(128),
                'PV',
                number_format($totalsell*(1-$this->entity->getDiscount()), 2, ',', ' ').' '.chr(128)
        ];
        $fill[] = [184,204,228];

        $this->setFont('Arial', '', 10);
        $this->cell(0, 6, 'Texte mail :', 0, 1);
        $this->multicell(0, 6, utf8_decode($this->entity->getIntro()));
        $this->ln(10);
        foreach ($content as $key => $c) {
            $col = ($key < 4 ? 'L':'R');
            $this->setFont('Arial', '', 10);
            $this->setFillColor($fill[$key][0], $fill[$key][1], $fill[$key][2]);
            $this->cell(10, 6, $c[0], 1, 0, 'R', 1);
            $this->cell(80, 6, $c[1], 1, 0, 'L', 1);
            $this->cell(20, 6, $c[2], 1, 0, $col, 1);
            $this->cell(10, 6, $c[3], 1, 0, $col, 1);
            $this->cell(20, 6, $c[4], 1, 0, $col, 1);
            $this->cell(20, 6, $c[5], 1, 0, $col, 1);
            $this->cell(10, 6, $c[6], 1, 0, $col, 1);
            $this->cell(15, 6, $c[7], 1, 0, $col, 1);
            $this->cell(20, 6, $c[8], 1, 0, $col, 1);
            $this->cell(15, 6, $c[9], 1, 0, $col, 1);
            $this->cell(20, 6, $c[10], 1, 0, $col, 1);
            $this->cell(20, 6, $c[11], 1, 0, $col, 1);
            $this->cell(20, 6, $c[12], 1, 1, $col, 1);
        }
        $this->ln(10);
        $this->cell(0, 6, 'Taux de marque : '.number_format($totalsell/$totalpurchaseFourniture, 2, ',', ' '));
    }
}

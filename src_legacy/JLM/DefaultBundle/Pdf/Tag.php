<?php

namespace JLM\DefaultBundle\Pdf;

use \JLM\DefaultBundle\Pdf\FPDFext;

class Tag extends FPDFext
{
    private $entity;
    private $count = 0;

    public static function get($codes)
    {
        $pdf = new self();
        $pdf->init();
        foreach ($codes as $code) {
            $pdf->addEntity(strtoupper($code));
        }
        return $pdf->Output('', 'S');
    }


    public function addEntity($code)
    {
        $this->addPage('L', [105, 148.5]);
        $this->setMargins(0, 0);
        $this->setAutoPageBreak(0);
        $this->image($_SERVER['DOCUMENT_ROOT'] . 'bundles/jlmdefault/img/jlm-logo.png', 50, 10, 80);
        $url = 'http://chart.apis.google.com/chart'
            . '?chs=180x180&choe=UTF-8&cht=qr&chl=http://www.jlm-entreprise.fr/installation/' . $code;
        $this->image($url, 8, 8, 40, 40, 'png');
        $this->setXY(10, 55);
        $this->setFont('Arial', 'B', 18);
        $this->multiCell(0, 8, 'Service dépannage 24/24h 7/7' . chr(10) . '01 64 33 77 70', false, 'C');


        // Numéro d'install
        $this->setXY(103, 80);
        $this->setFont('Arial', 'B', 22);
        $this->cell(40, 14, $code, true, 0, 'C');

        $this->setXY(10, 80);
        $this->setFont('Arial', 'B', 15);
        $this->setTextColor(0, 0, 170);
        $this->multiCell(90, 7, 'Numéro à communiquer en cas de demande d\'intervention', false, 'C');
        $this->setTextColor(0, 0, 0);

        return $this;
    }

    public function addEntity2($code)
    {
        switch ($this->count) {
            case 0:
                $this->addPage('L', [297.64, 420.94]);
                $this->setMargins(0, 0, 0, 0);
                $this->line(148, 0, 148, 210);
                $this->line(0, 105, 297, 105);
                $origX = 0;
                $origY = 0;
                break;
            case 1:
                $origX = 148;
                $origY = 0;
                break;
            case 2:
                $origX = 0;
                $origY = 105;
                break;
            case 3:
                $origX = 148;
                $origY = 105;
                break;
        }
        $this->image(
            $_SERVER['DOCUMENT_ROOT'] . 'bundles/jlmoffice/img/pdf-logo-comp.jpg',
            $origX + 50,
            $origY + 10,
            80
        );
        $url = 'http://chart.apis.google.com/chart'
            . '?chs=180x180&choe=UTF-8&cht=qr&chl=http://www.jlm-entreprise.fr/installation/' . $code;
        $this->image($url, $origX + 8, $origY + 8, 40, 40, 'png');
        $this->setXY($origX + 10, $origY + 50);
        $this->setFont('Arial', 'B', 15);
        $this->multiCell(128, 7, 'En cas de panne blablabla');
        $this->setXY($origX + 98, $origY + 70);

        // Numéro d'install
        $this->setFont('Arial', 'B', 22);
        $this->cell(35, 10, $code, true, 0, 'C');
        $this->count = ($this->count == 3) ? 0 : $this->count + 1;

        return $this;
    }

    public function init()
    {
        $this->aliasNbPages();
        $this->setFillColor(200);
    }
}

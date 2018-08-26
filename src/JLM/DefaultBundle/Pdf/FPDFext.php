<?php
namespace JLM\DefaultBundle\Pdf;

class FPDFext extends \fpdf\FPDF
{

    var $widths;
    var $aligns;
    private $angler = 0;

    function SetWidths($w)
    {
        //Set the array of column widths
        $this->widths = $w;
    }

    function SetAligns($a)
    {
        //Set the array of column alignments
        $this->aligns = $a;
    }

    function Row($data, $height = 5, $border = 1, $fill = false)
    {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++) {
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        }
        $h = $height * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            $style = '';
            if ($border) {
                $style .= 'D';
            }
            if ($fill) {
                $style .= 'F';
            }
            $this->Rect($x, $y, $w, $h, $style);
            //Print the text
            $this->MultiCell($w, $height, $data[$i], 0, $a);
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h)
    {
        //If the height h would cause an overflow, add a new page immediately
        if ($this->GetY() + $h > $this->PageBreakTrigger) {
            $this->AddPage($this->CurOrientation);
        }
    }

    function NbLines($w, $txt)
    {
        //Computes the number of lines a MultiCell of width w will take
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0) {
            $w = $this->w - $this->rMargin - $this->x;
        }
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n") {
            $nb--;
        }
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ') {
                $sep = $i;
            }
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j) {
                        $i++;
                    }
                } else {
                    $i = $sep + 1;
                }
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else {
                $i++;
            }
        }
        return $nl;
    }
    
    public function cell($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = 0, $link = '')
    {
        $txt = str_replace('€', '$$euro$$', $txt);
        $txt = utf8_decode($txt);
        $txt = str_replace('$$euro$$', chr(128), $txt);
        $k=$this->k;
        if ($this->y+$h>$this->PageBreakTrigger and !$this->InFooter and $this->AcceptPageBreak()) {
            $x=$this->x;
            $ws=$this->ws;
            if ($ws>0) {
                $this->ws=0;
                $this->_out('0 Tw');
            }
            $this->AddPage($this->CurOrientation);
            $this->x=$x;
            if ($ws>0) {
                $this->ws=$ws;
                $this->_out(sprintf('%.3f Tw', $ws*$k));
            }
        }
        if ($w==0) {
            $w=$this->w-$this->rMargin-$this->x;
        }
        $s='';
        if ($fill==1 or $border==1) {
            if ($fill==1) {
                $op=($border==1) ? 'B' : 'f';
            } else {
                $op='S';
            }
            $s=sprintf('%.2f %.2f %.2f %.2f re %s ', $this->x*$k, ($this->h-$this->y)*$k, $w*$k, -$h*$k, $op);
        }
        if (is_string($border)) {
            $x=$this->x;
            $y=$this->y;
            if (is_int(strpos($border, 'L'))) {
                $s.=sprintf('%.2f %.2f m %.2f %.2f l S ', $x*$k, ($this->h-$y)*$k, $x*$k, ($this->h-($y+$h))*$k);
            }
            if (is_int(strpos($border, 'T'))) {
                $s.=sprintf('%.2f %.2f m %.2f %.2f l S ', $x*$k, ($this->h-$y)*$k, ($x+$w)*$k, ($this->h-$y)*$k);
            }
            if (is_int(strpos($border, 'R'))) {
                $s.=sprintf('%.2f %.2f m %.2f %.2f l S ', ($x+$w)*$k, ($this->h-$y)*$k, ($x+$w)*$k, ($this->h-($y+$h))*$k);
            }
            if (is_int(strpos($border, 'B'))) {
                $s.=sprintf('%.2f %.2f m %.2f %.2f l S ', $x*$k, ($this->h-($y+$h))*$k, ($x+$w)*$k, ($this->h-($y+$h))*$k);
            }
        }
        if ($txt!='') {
            if ($align=='R') {
                $dx=$w-$this->cMargin-$this->GetStringWidth($txt);
            } elseif ($align=='C') {
                $dx=($w-$this->GetStringWidth($txt))/2;
            } elseif ($align=='FJ') {
                //Set word spacing
                $wmax=($w-2*$this->cMargin);
                $this->ws=($wmax-$this->GetStringWidth($txt))/substr_count($txt, ' ');
                $this->_out(sprintf('%.3f Tw', $this->ws*$this->k));
                $dx=$this->cMargin;
            } else {
                $dx=$this->cMargin;
            }
            $txt=str_replace(')', '\\)', str_replace('(', '\\(', str_replace('\\', '\\\\', $txt)));
            if ($this->ColorFlag) {
                $s.='q '.$this->TextColor.' ';
            }
            $s.=sprintf('BT %.2f %.2f Td (%s) Tj ET', ($this->x+$dx)*$k, ($this->h-($this->y+.5*$h+.3*$this->FontSize))*$k, $txt);
            if ($this->underline) {
                $s.=' '.$this->_dounderline($this->x+$dx, $this->y+.5*$h+.3*$this->FontSize, $txt);
            }
            if ($this->ColorFlag) {
                $s.=' Q';
            }
            if ($link) {
                if ($align=='FJ') {
                    $wlink=$wmax;
                } else {
                    $wlink=$this->GetStringWidth($txt);
                }
                $this->Link($this->x+$dx, $this->y+.5*$h-.5*$this->FontSize, $wlink, $this->FontSize, $link);
            }
        }
        if ($s) {
            $this->_out($s);
        }
        if ($align=='FJ') {
            //Remove word spacing
            $this->_out('0 Tw');
            $this->ws=0;
        }
        $this->lasth=$h;
        if ($ln>0) {
            $this->y+=$h;
            if ($ln==1) {
                $this->x=$this->lMargin;
            }
        } else {
            $this->x+=$w;
        }
    }
    
    
    public function Text($x, $y, $txt)
    {
        $txt = str_replace('€', '$$euro$$', $txt);
        $txt = utf8_decode($txt);
        $txt = str_replace('$$euro$$', chr(128), $txt);
        return parent::Text($x, $y, $txt);
    }
    
    public function rotate($angle, $x = -1, $y = -1)
    {
        if ($x==-1) {
            $x=$this->x;
        }
        if ($y==-1) {
            $y=$this->y;
        }
        if ($this->angler!=0) {
            $this->_out('Q');
        }
        $this->angler=$angle;
        if ($angle!=0) {
            $angle*=M_PI/180;
            $c=cos($angle);
            $s=sin($angle);
            $cx=$x*$this->k;
            $cy=($this->h-$y)*$this->k;
            $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm', $c, $s, -$s, $c, $cx, $cy, -$cx, -$cy));
        }
    }
    
    public function rotatedText($x, $y, $txt, $angle)
    {
        //Rotation du texte autour de son origine
        $this->Rotate($angle, $x, $y);
        $this->Text($x, $y, $txt);
        $this->Rotate(0);
    }
}

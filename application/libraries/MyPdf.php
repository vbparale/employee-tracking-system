<?php

/**
 * Source Source: "https://tcpdf.org/examples/example_003/"
 * Author: TCPDF.org
 * Added by: Ben Zarmaynine E. Obra
 */


class MyPdf extends TCPDF { 

    public $title = 'Employee Tracking System';
    
    //Page header
    public function Header() {


        // Set font
        $this->SetFont('times', 'B', 20);
        // Title
        $this->Cell(0, 0, $this->title, 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('times', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

    public function setTable($headers,$data){
        $this->setFontSize(9);
        
        if ($headers) {

            $this->SetFillColor(255, 0, 0);
            $this->SetTextColor(255);
            $this->SetDrawColor(128, 0, 0);
            $this->SetLineWidth(0.3);            
            $this->SetFont('', 'B');

            $num_headers = count($headers);
            $w = array(35, 42, 66, 60);
            for($i = 0; $i < $num_headers; ++$i) {
                $this->Cell($w[$i], 7, $headers[$i], 1, 0, 'C', 1);
            }

        }

        $this->Ln(); 

        if ($data) {

            $this->SetFillColor(224, 235, 255);
            $this->SetTextColor(0);
            $this->SetFont('');

            $fill = 0;

            $this->Cell($w[0], 6, $data['EHC_DATE'], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $data['COMPLETION_DATE'], 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, $data['A1'], 'LR', 0, 'R', $fill);
            $this->Cell($w[3], 6, $data['A2'], 'LR', 0, 'R', $fill);
            $this->Ln();
            $fill=!$fill;



            $this->Cell(array_sum($w), 0, '', 'T');           

        } else {

            return false;
        }

    }
}
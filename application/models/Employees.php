<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Html;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class Employees extends MY_Model {

    public $table = 'nets_emp_info';
    public $primary_key = 'EMP_CODE';
    public $timestamps = FALSE;
    public $export_title = 'Summary of priority for testing';
    
    private $period = false;
    private $filename = 'PriorityTesting_';
    
    public function __construct(){

        $this->return_as = 'array';
        
        parent::__construct();

        $this->load->model('Companies');
        $this->load->model('Groups');

        $this->has_many['activities'] = array(

            'foreign_model' => 'Activities',
            'foreign_table' => 'nets_emp_activity',
            'foreign_key' => 'EMP_CODE',
            'local_key' => 'EMP_CODE'
        );

        $this->has_many['participants'] = array(

            'foreign_model' => 'Employees',
            'foreign_table' => 'nets_emp_act_participants',
            'foreign_key' => 'EMP_CODE',
            'local_key' => 'EMP_CODE'            
        );

        $this->has_many['healthChecks'] = array(

            'foreign_model' => 'HealthChecks',
            'foreign_table' => 'nets_emp_ehc',
            'foreign_key' => 'EMP_CODE',
            'local_key' => 'EMP_CODE' 
        );

        $this->has_one['company'] = array(

            'foreign_model' => 'Companies',
            'foreign_table' => 'nxx_company',
            'foreign_key' => 'COMP_CODE',
            'local_key' => 'COMP_CODE' 
        );

        $this->has_one['group'] = array(

            'foreign_model' => 'Groups',
            'foreign_table' => 'nxx_group',
            'foreign_key' => 'GRP_CODE',
            'local_key' => 'GRP_CODE'             
        );

        $this->has_many['healthDeclarations'] = array(

            'foreign_model' => 'HealthDeclarations',
            'foreign_table' => 'nets_emp_hdf',
            'foreign_key' => 'EMP_CODE',
            'local_key' => 'EMP_CODE' 
        );
        
        $this->has_many['healthChecks'] = array(

            'foreign_model' => 'HealthChecks',
            'foreign_table' => 'nets_emp_ehc',
            'foreign_key' => 'EMP_CODE',
            'local_key' => 'EMP_CODE' 
        );

        $this->has_many['visitors'] = array(

            'foreign_model' => 'Visitors',
            'foreign_table' => 'nets_visit_logs',
            'foreign_key' => 'PERS_TOVISIT',
            'local_key' => 'EMP_CODE' 
            
        );
    }

    /**
     * Added: Priority List export function
     * Author: Ben Zarmanine E. Obra
     * Date: 06-25-2020
     */

    public function excel($params=null){

        if ($params) {
            
            $spreadsheet = new SpreadSheet();

            if ($params['date_start']) {
                
                $this->period = 'Period From '.date("F d, Y",strtotime($params['date_start']));
                $this->filename.= $params['date_start'];
            }

            $company = ($params['company'] ? $this->Companies->fields('COMP_NAME')->where('COMP_CODE',$params['company'])->get()['COMP_NAME'] : false);
            $group = ($params['group'] ? $this->Groups->fields('GRP_NAME')->where('GRP_CODE',$params['group'])->get()['GRP_NAME'] : false);

            if ($group && $company) {
                
                $queryString = "call priority_list('".$params['company']."','".$params['group']."','".$params['date_start']."')";

                $queryResult = $this->Reports->custom($queryString);
                
                if ($queryResult) {
                    
                    $queryResult = $queryResult[0];

                } else {

                    return false;
                }
                
                $sheet = $spreadsheet->GetActiveSheet();
                
                $sheet->setCellValue('A1',$this->export_title);
                $sheet->setCellValue('A2',$this->period);
                $sheet->setCellValue('A3','Company: '.($company ? $company : 'Undefined Company'));
                $sheet->setCellValue('B3','Group: '.($group ? $group : 'Undefined Group'));
                
                $sheet->setCellValue('A6',"Priority For Testing");
                $sheet->setCellValue('B6',"Count");

                $sheet->setCellValue('A7',"Those who are symptomatic, whether or not they had known contacts with confirmed COVID-19 patients.\nHere are the usual symptoms:\n
                Dry cough
                Sore throat
                Muscle pain and weakness
                Decreased ability to smell (this has been a common symptom reported)
                Decreased ability to taste (less often than decreased ability to smell)
                Diarrhea
                Difficulty breathing (as soon as difficulty breathing occurs with the fever, then think COVID unless proven otherwise)
                Conjunctivitis in the presence of persistent fever and/or any of the above symptoms. This has been reported in a few patients.");
                $sheet->setCellValue('A8',"Employee with Fever (during the survey)");
                $sheet->setCellValue('A9',"Employees who are high risk and asymptomatic. (e.g. senior citizens or those that are above 50 years old with those with co-morbidities\nsuch as diabetes, hypertension chronic renal diseases and lung diseases, cancer patients on treatment, those with gross obesity with a BMI >/= 41,and those on immunosuppressive medicines, etc.");
                $sheet->setCellValue('A10','Employees with age 50+ living with someone with co-morbidities');
                $sheet->setCellValue('A11','Employees living with Relatives with existing co-morbidities');
                $sheet->setCellValue('A12',"Symptomatic or asymptomatic persons who live with or are in close contact with front liners\ni.e. Medical personnel, security, retail, package/food delivery personnel etc.");
                $sheet->setCellValue('A13','Employees with exposure with PUI, confirmed COVID19 patient');

                $sheet->setCellValue('B7',$queryResult['symptomatic']);
                $sheet->setCellValue('B8',$queryResult['with_fever']);
                $sheet->setCellValue('B9',$queryResult['asymptomatic']);
                $sheet->setCellValue('B10',$queryResult['old_coMorbidities']);
                $sheet->setCellValue('B11',$queryResult['coMorbidities']);
                $sheet->setCellValue('B12',$queryResult['close_contact']);
                $sheet->setCellValue('B13',$queryResult['with_exposure']);

                $sheet->setTitle('Priority for Testing');

                $sheet->mergeCells('A1:E1');
                $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->mergeCells('A2:E2');
                $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A6:B6')->getFont()->setBold(true);
                $sheet->getStyle('A1')->getFont()->setBold(true); 

                $sheet->getStyle('A7')->getAlignment()->setWrapText(true);
                $sheet->getStyle('A9')->getAlignment()->setWrapText(true);
                $sheet->getStyle('A12')->getAlignment()->setWrapText(true);
                
                $sheet->getColumnDimension('A')->setWidth(91);
                

                $writer = IOFactory::createWriter($spreadsheet,'Xlsx');
                header('Content-type: application/vnd.openxmlformats-officedocuments.spreadsheet.sheet');
                header('Content-Disposition: attachment;filename="'.$this->filename.'.xlsx"'.'');
                
                $writer->save('php://output');                
                
            } else {

                return false;
            }
        
        } else {

            return false;
        }

    }

    public function pdf($params=null){
        
        if ($params) {

            if ($params['date_start']) {
                
                $this->period = 'Period From '.date("F d, Y",strtotime($params['date_start']));
                $this->filename.= $params['date_start'];
            }
            
            $company = ($params['company'] ? $this->Companies->fields('COMP_NAME')->where('COMP_CODE',$params['company'])->get()['COMP_NAME'] : false);
            $group = ($params['group'] ? $this->Groups->fields('GRP_NAME')->where('GRP_CODE',$params['group'])->get()['GRP_NAME'] : false);            
            
            if ($company && $group) {
                
                $queryString = "call priority_list('".$params['company']."','".$params['group']."','".$params['date_start']."')";

                $queryResult = $this->Reports->custom($queryString);
                
                if ($queryResult) {
                    
                    $queryResult = $queryResult[0];

                } else {

                    return false;
                }

                $pdf = new MyPdf();
                $pdf->title = $this->export_title;
                
                $pdf->SetMargins(5.5, PDF_MARGIN_TOP, 4);
                $pdf->setHeaderMargin(10);
                $pdf->setFooterMargin(5);
                $pdf->setFontSize(12);

                $pdf->addPage();

                $pdf->Cell(0, 0, $this->period, 0, 1, 'C', 0, '', 0);
                $pdf->Ln();
                
                $pdf->Cell(140, 0, 'Company: '.$company, 0, 0, 'L', 0);
                $pdf->Cell(65, 0, 'Group: '.$group, 0, 0, 'L', 0);
                $pdf->Ln();
                
                $pdf->setFontSize(9);
                $pdf->SetFillColor(179, 204, 255);
                $pdf->SetTextColor(0);
                $pdf->SetLineWidth(0.3);            
                $pdf->SetFont('', 'B');
                
                $pdf->Ln();
                $pdf->Cell(170, 6, 'Priority for Testing', 1, 0, 'L', 1);
                $pdf->Cell(30, 6, 'Count', 1, 0, 'L', 1);
                $pdf->Ln();

                $pdf->SetFillColor(224, 235, 255);
                $pdf->SetFont('');
                
                $pdf->MultiCell(170, 50, "\n  Those who are symptomatic, whether or not they had known contacts with confirmed COVID-19 patients.
  Here are the usual symptoms:
    -Dry cough
    -Sore throat
    -Muscle pain and weakness
    -Decreased ability to smell (this has been a common symptom reported)
    -Decreased ability to taste (less often than decreased ability to smell)
    -Diarrhea
    -Difficulty breathing (as soon as difficulty breathing occurs with the fever,then think COVID unless proven otherwise)
    -Conjunctivitis in the presence of persistent fever and/or any of the above symptoms.
     This has been reported in a few patients.", 1, 'L', 0, 0);
                $pdf->Cell(30, 50, $queryResult['symptomatic'], 1, 0, 'C', 0);
                $pdf->Ln();
                $pdf->Cell(170, 10, '   Employee with Fever (during the survey)', 1, 0, 'L', 0);
                $pdf->Cell(30, 10, $queryResult['with_fever'] , 1, 0, 'C', 0);
                $pdf->Ln();
                $pdf->MultiCell(170, 18, "\n  Employees who are high risk and asymptomatic. (e.g. senior citizens or those that are above 50 years old with those
  with co-morbidities such as diabetes, hypertension chronic renal diseases and lung diseases, cancer patients on
  treatment, those with gross obesity with a BMI >/= 41,and those on immunosuppressive medicines, etc.", 1, 'L', 0, 0);
                $pdf->Cell(30, 18, $queryResult['asymptomatic'], 1, 0, 'C', 0);
                $pdf->Ln();
                $pdf->Cell(170, 10, '   Employees with age 50+ living with someone with co-morbidities', 1, 0, 'L', 0);
                $pdf->Cell(30, 10, $queryResult['old_coMorbidities'], 1, 0, 'C', 0);
                $pdf->Ln();
                $pdf->Cell(170, 10, '   Employees living with Relatives with existing co-morbidities', 1, 0, 'L', 0);
                $pdf->Cell(30, 10, $queryResult['coMorbidities'], 1, 0, 'C', 0);
                $pdf->Ln();
                $pdf->MultiCell(170, 15, "\n  Symptomatic or asymptomatic persons who live with or are in close contact with front liners i.e. Medical personnel,
  security, retail, package/food delivery personnel etc.", 1, 'L', 0, 0);
                $pdf->Cell(30, 15, $queryResult['close_contact'], 1, 0, 'C', 0);
                $pdf->Ln();
                $pdf->Cell(170, 10, '   Employees with exposure with PUI, confirmed COVID19 patient', 1, 0, 'L', 0);
                $pdf->Cell(30, 10, $queryResult['with_exposure'], 1, 0, 'C', 0);                                
                                                                               
                
                
                $pdf->Output($this->filename.'.pdf', 'D');

            }

        } else {

            return false;
        }

    }
}
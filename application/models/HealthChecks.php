<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Html;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class HealthChecks extends MY_Model {

    public $table = 'nets_emp_ehc';
    public $primary_key = 'EHC_ID';
    private $response = false;
    public $export_title = 'Summary of Daily Health Check per Employee';
    public function __construct(){

        $this->return_as = 'array';
        
        parent::__construct();
        
        $this->load->model('Groups');
        $this->load->model('Companies');
        $this->load->library('MyPdf');

        $this->has_one['employee'] = array(

            'foreign_model' => 'Employees',
            'foreign_table' => 'nets_emp-info',
            'foreign_key' => 'EMP_CODE',
            'local_key' => 'EMP_CODE' 
        );

    }

    public function excel($data,$params){
        
        $spreadsheet = new SpreadSheet();

        if ($data) {
            
            $data_length = count($data);
            $sheetIndex = 0;

            for ($i=0; $i < $data_length; $i++) { 
                $healthChecks = false;

                $where['EMP_CODE'] = $data[$i]['EMP_CODE'];
                
                if ($params['sick_filter']) {
                    
                    $where['A2'] = $params['sick_filter'];
                }

                if ($params['date_start'] && $params['date_end']) {
                    
                    $healthChecks = $this->where($where)
                    ->where_between('EHC_DATE', $params['date_start'], $params['date_end'])->get_all();

                } else if($params['date_start']) {

                    $healthChecks = $this->where($where)
                    ->where('EHC_DATE >=',$params['date_start'])
                    ->get_all();
                    

                } else {
                    
                    $healthChecks = $this->where($where)->get_all();
                }                

                
                if (!$healthChecks) {
                    continue;
                }

                $spreadsheet->createSheet();
                
                $sheet = $spreadsheet->setActiveSheetIndex($sheetIndex);

                if ($params['date_start'] && $params['date_end']) {
                    
                    $period = 'Period From '.date("F d, Y",strtotime($params['date_start'])).' to '.date("F d, Y",strtotime($params['date_end']));

                } else if($params['date_start']){

                    $period = 'Period From '.date("F d, Y",strtotime($params['date_start']));
                    
                } else {

                    $period = '';
                }

                if ($data[$i]['GRP_CODE']) {
                    
                    $id = array('GRP_CODE' => $data[$i]['GRP_CODE']);
                    $group = $this->Groups->fields('GRP_NAME')->get($id);

                } else {
                    
                    $group = false;
                }
                
                $sheet->setCellValue('A1',$this->export_title);
                $sheet->setCellValue('A2',$period);
                $sheet->setCellValue('A3','Employee No.:');
                $sheet->setCellValue('B3',($data[$i]['EMP_CODE'] ? $data[$i]['EMP_CODE'] : ''));
                $sheet->setCellValue('A4','Employee Name:');
                $sheet->setCellValue('B4',$data[$i]['EMP_LNAME'].' '.$data[$i]['EMP_FNAME']);
                $sheet->setCellValue('I3','Group:');
                $sheet->setCellValue('J3',(!$group ? 'No Group' : $group['GRP_NAME']));
                $sheet->setCellValue('I4','Company:');
                $sheet->setCellValue('J4',($data[$i]['company'] ? $data[$i]['company']['COMP_NAME'] : ''));

                $sheet->setCellValue('A6',"Health Check\nDate");
                $sheet->setCellValue('B6',"Completion Date\nand Time");
                $sheet->setCellValue('C6',"What is your\nbody temperature?");
                $sheet->setCellValue('D6',"Are you feeling\nsick today?");
                $sheet->setCellValue('E6',"Do you have the following\nsickness/symptoms?");
                $sheet->setCellValue('F6',"Did you travel outside of\nyour home?");
                $sheet->setCellValue('G6','Where');
                $sheet->setCellValue('H6','When');
                $sheet->setCellValue('I6',"Did you have any close\ncontact with positive CoViD\nPerson and/or Person Under\nvestigation (PUI)?");
                $sheet->setCellValue('J6','When');
                $sheet->setCellValue('K6','RUSH.net #');
                $sheet->setCellValue('L6','Reason');
                $sheet->setCellValue('M6','Status');                

                $sheetitle = $data[$i]['EMP_LNAME'].' '.$data[$i]['EMP_FNAME'];

                if (strlen($sheetitle) > 31) {
                    
                    $title_change = substr($data[$i]['EMP_FNAME'],0,1).$data[$i]['EMP_LNAME'];

                    $sheetitle = (strlen($title_change) > 31 ? $data[$i]['RUSH_ID'] :$title_change);

                }
                
                $sheet->setTitle($sheetitle);
                
                $row = 7;

                foreach ($healthChecks as $healthCheck) {
                    
                    $A3 = json_decode($healthCheck['A3'],true);
                    
                    if (count($A3) > 1) {
                        
                        $A3 = implode(', ',$A3);

                    } else {

                        $A3 = $A3[0];
                    }

                    switch ($healthCheck['STATUS']) {
                        case 'I':
                            $rush_status = 'In Process';
                            break;

                        case 'D':
                            $rush_status = 'Done';
                            break;

                        case 'C':
                            $rush_status = 'Closed';
                            break;

                        case 'R':
                            $rush_status = 'Rejected';
                            break; 
                                                                                                                       
                        default:
                            $rush_status = $healthCheck['STATUS'];
                            break;
                    }
                    
                    $sheet->setCellValue('A'.$row,$healthCheck['EHC_DATE']);
                    $sheet->setCellValue('B'.$row,$healthCheck['COMPLETION_DATE']);
                    $sheet->setCellValue('C'.$row,$healthCheck['A1']);
                    $sheet->setCellValue('D'.$row,($healthCheck['A2'] === 'Y' ? 'Yes' : 'No'));
                    $sheet->setCellValue('E'.$row,$A3);
                    $sheet->setCellValue('F'.$row,($healthCheck['A4'] === 'Y' ? 'Yes' : 'No'));
                    $sheet->setCellValue('G'.$row,$healthCheck['A4WHERE']);
                    $sheet->setCellValue('H'.$row,$healthCheck['A4WHEN']);
                    $sheet->setCellValue('I'.$row,($healthCheck['A5'] === 'Y' ? 'Yes' : 'No'));
                    $sheet->setCellValue('J'.$row,$healthCheck['A5WHEN']);
                    $sheet->setCellValue('K'.$row,$healthCheck['RUSHNO']);
                    $sheet->setCellValue('L'.$row,$healthCheck['REASON']);
                    $sheet->setCellValue('M'.$row,$rush_status);
                    
                    $row++;
                }

                $sheet->mergeCells('A1:M1');
                $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A1')->getFont()->setBold(true);
                $sheet->mergeCells('A2:M2');
                $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('I6')->getAlignment()->setWrapText(true);
                $sheet->getStyle('A6:F6')->getAlignment()->setWrapText(true);
                $sheet->getStyle('A6:O6')->getFont()->setBold(true);
    
                $sheet->getColumnDimension('A')->setWidth(16);
                $sheet->getColumnDimension('B')->setWidth(18);
                $sheet->getColumnDimension('C')->setWidth(14);
                $sheet->getColumnDimension('D')->setWidth(10);
                $sheet->getColumnDimension('E')->setWidth(19);
                $sheet->getColumnDimension('F')->setWidth(13);
                $sheet->getColumnDimension('G')->setWidth(10);
                $sheet->getColumnDimension('H')->setWidth(11);
                $sheet->getColumnDimension('I')->setWidth(26);
                $sheet->getColumnDimension('J')->setWidth(12);
                $sheet->getColumnDimension('K')->setWidth(13);
                $sheet->getColumnDimension('L')->setWidth(15);                

                $sheetIndex++;
            }
            
            $spreadsheet->setActiveSheetIndex(0);

            if ($params['date_start'] && $params['date_end']) {
                
                $filename = "EHC_".$params['date_start']."_to_".$params['date_end'].".xlsx";

            } else if($params['date_start']){

                $filename = "EHC_".$params['date_start'].".xlsx";
                
            } else {

                $filename = "EHC_".date("Y-m-d").".xlsx";
            }

            
            $writer = IOFactory::createWriter($spreadsheet,'Xlsx');
            header('Content-type: application/vnd.openxmlformats-officedocuments.spreadsheet.sheet');
            header('Content-Disposition: attachment;filename="'.$filename);
            
            $writer->save('php://output');
        }

    }

    public function pdf($data,$params){

        $pdf = new MyPdf();
        $pdf->title = $this->export_title;
        
        $pdf->SetMargins(4, PDF_MARGIN_TOP, 4);
        $pdf->setHeaderMargin(10);
        $pdf->setFooterMargin(5);
        // add a page

        foreach ($data as $employee) {
            
            $employeeData = array(

                'group' => $this->Groups->get(array('GRP_CODE' => $employee['GRP_CODE']))['GRP_NAME'],
                'company' => $this->Companies->get(array('COMP_CODE' => $employee['COMP_CODE']))['COMP_NAME'],
            );

            if (!isset($employee['healthChecks'])) {
                
                continue;
            }
            
            $pdf->setFontSize(12);
            
            $pdf->AddPage('L','LEGAL');
            
            if ($params['date_start'] && $params['date_end']) {
                    
                $period = 'Period From '.date("F d, Y",strtotime($params['date_start'])).' to '.date("F d, Y",strtotime($params['date_end']));

            } else if($params['date_start']){

                $period = 'Period From '.date("F d, Y",strtotime($params['date_start']));
                
            } else {

                $period = 'No Date Indicated';
            }
                        
            $pdf->Cell(0, 0, $period, 0, 1, 'C', 0, '', 0);
            $pdf->Ln();
            
            $pdf->Cell(247, 0, 'Employee No: '.$employee['EMP_CODE'], 0, 0, 'L', 0);
            $pdf->Cell(97, 0, 'Group: '.$employeeData['group'], 0, 0, 'L', 0);
            $pdf->Ln();
            $pdf->Cell(247, 0, 'Employee Name: '.$employee['EMP_LNAME'].' '.$employee['EMP_FNAME'], 0, 0, 'L', 0);
            $pdf->Cell(97, 0, 'Company: '.$employeeData['company'], 0, 0, 'L', 0);            
            $pdf->Ln();
            
            $pdf->setFontSize(9);
            $pdf->SetFillColor(179, 204, 255);
            $pdf->SetTextColor(0);
            $pdf->SetLineWidth(0.3);            
            $pdf->SetFont('', 'B');
            
            /**
             * Table Headers
             */
            $pdf->Ln();
            $pdf->Cell(30, 33, 'Health Check Date', 1, 0, 'L', 1);
            $pdf->MultiCell(28, 33, "\n\n\nCompletion Date and Time", 1, 'L', 1, 0);
            $pdf->MultiCell(22, 33, "\n\n\nBody Temperature", 1, 'L', 1, 0);
            $pdf->Cell(20, 33, "Sick today?", 1, 0, 'L', 1);
            $pdf->Cell(45, 33, "Sickness/Symptoms?", 1, 0, 'L', 1);
            $pdf->MultiCell(20,33,"\n\n\nTravel Outside of home", 1, 'L', 1, 0);
            $pdf->Cell(30, 33, 'Where', 1, 0, 'L', 1);
            $pdf->Cell(24, 33, 'When', 1, 0, 'L', 1);            
            $pdf->MultiCell(28,33,"Close contact with positive CoViD Person and/or Person Under investigation (PUI)?", 1, 'L', 1, 0);
            $pdf->Cell(26, 33, 'When', 1, 0, 'L', 1);
            $pdf->Cell(24, 33, 'RUSH.net #', 1, 0, 'L', 1);
            $pdf->Cell(26, 33, 'Reason', 1, 0, 'L', 1);
            $pdf->Cell(24, 33, 'Status', 1, 0, 'L', 1);
            $pdf->Ln();

            /**
             * Table Body
             * 
             */

            $pdf->SetFillColor(224, 235, 255);
            $pdf->SetFont('');             
            
            $limit = 0;
            foreach($employee['healthChecks'] as $healthCheck){

                $a3 = json_decode($healthCheck['A3'],true);
                $a3_length = count($a3);
                
                if ($a3_length > 2) {

                    $By2s = array_chunk($a3,2);
                    $new_string = '';
                    
                    for ($i=0; $i < 2; $i++) { 

                        $new_string.= implode(', ',$By2s[$i])."\n";
                        
                        if ($i === 1) {
                            
                            $new_string.= '*unable to show more symptoms*';
                        }                        
                    }
                    
                    $a3 = $new_string;

                } else if ($a3_length <= 2) {
                    
                    $a3 = implode(', ',$a3);

                } else {

                    $a3 = $a3[0];
                }

                $pdf->MultiCell(30, 16, "\n".date("F d, Y",strtotime($healthCheck['EHC_DATE'])), 1, 'L', 0, 0);
                $pdf->MultiCell(28, 16, "\n".date("F d, Y",strtotime($healthCheck['COMPLETION_DATE']))."\n".date("h:i a",strtotime($healthCheck['COMPLETION_DATE'])), 1, 'L', 0, 0);
                $pdf->Cell(22, 16, $healthCheck['A1'], 1, 0, 'L', 0);
                $pdf->Cell(20, 16, $healthCheck['A2'], 1, 0, 'L', 0);
                $pdf->MultiCell(45, 16, $a3, 1, 'L', 0, 0);
                $pdf->Cell(20, 16, $healthCheck['A4'], 1, 0, 'L', 0);
                $pdf->MultiCell(30, 16, ($healthCheck['A4'] === 'Y' ? $healthCheck['A4WHERE'] : ''), 1, 'L', 0, 0);
                $pdf->MultiCell(24, 16, ($healthCheck['A4'] === 'Y' ? "\n".date("F d, Y",strtotime($healthCheck['A4WHEN'])) : ''), 1, 'L', 0, 0);
                $pdf->Cell(28, 16, $healthCheck['A5'], 1, 0, 'L', 0);
                $pdf->MultiCell(26, 16, ($healthCheck['A5'] === 'Y' ? date("F d, Y",strtotime($healthCheck['A5WHEN'])) : ''), 1, 'L', 0, 0);
                $pdf->Cell(24, 16, $healthCheck['RUSHNO'], 1, 0, 'L', 0);
                $pdf->MultiCell(26,16,$healthCheck['REASON'],1,'L',0,0);
                $pdf->Cell(24,16, $this->statusConv($healthCheck['STATUS']), 1, 0, 'L', 0);

                $pdf->Ln();
                
                $limit++;
            }
            
        }

        //Close and output PDF document
        $pdf->Output('EmployeeHealthCheck.pdf', 'D');        

    }

    public function statusConv($string){
        
        $status = $string;
        
        switch ($status) {
            case 'I':
                
                $status = 'In-Process';
                break;
            
            case 'C':

                $status = 'Closed';
                break;

            case 'O':

                $status = 'Open';
                break;

            case 'R':

                $status = 'Rejected';
                break;

            default:
                $status = $string;
                break;
        }

        return $status;
    }

}
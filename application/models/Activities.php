<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Html;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class Activities extends MY_Model {

	public $table = 'nets_emp_activity';
	public $primary_key = 'ACTIVITY_ID';
	public $timestamps = FALSE;
    public $export_title = 'Summary of Daily Activity Report per Employee';

    private $response = false;

    public function __construct(){

        $this->return_as = 'array';

        parent::__construct();

        $this->load->model('Participants');

        $this->has_one['employee'] = array(
            'foreign_model' => 'Employees',
            'foreign_table' => 'nets_emp_info',
            'foreign_key' => 'EMP_CODE',
            'local_key' => 'EMP_CODE'
        );

        $this->has_many['participants'] = array(

            'foreign_model' => 'Participants',
            'foreign_table' => 'nets_emp_act_participants',
            'foreign_key' => 'ACTIVITY_ID',
            'local_key' => 'ACTIVITY_ID'
        );

        $this->has_many['visitors'] = array(

            'foreign_model' => 'Visitors',
            'foreign_table' => 'nets_visit_log',
            'foreign_key' => 'ACTIVITY_ID',
            'local_key' => 'ACTIVITY_ID'
        );

    }

    public function custom($string){

        if ($string) {
            
			$query = $this->db->query($string);

			$rowcount = $query->num_rows();
			
			if ($rowcount > 0) {
				
				$this->response = $query->result_array();

			}             
        }

        return $this->response;
    }

    /**
     * Report Module functions
     *
     */

     public function excel($data,$params){

        $spreadsheet = new SpreadSheet();

        if ($data) { 

            $data_length = count($data);
            $sheetIndex = 0;
            
            for ($i=0; $i < $data_length; $i++) {
                
                if ($data[$i]['EMP_CODE'] === 0) {
                    
                    continue;
                }
                
                $params['emp_code'] = $data[$i]['EMP_CODE'];
                $params['company'] = $data[$i]['COMP_CODE'];
                
                $query_string = $this->Reports->ReportBuilder('dar',$params);

                $activities = $this->custom($query_string." ORDER BY A.ACTIVITY_DATE ASC"); 
                
                $spreadsheet->createSheet();
                $sheet = $spreadsheet->setActiveSheetIndex($sheetIndex);

                if ($params['date_start'] && $params['date_end']) {
                    
                    $period = 'Period From '.date("F d, Y",strtotime($params['date_start'])).' to '.date("F d, Y",strtotime($params['date_end']));

                } else if($params['date_start']){

                    $period = 'Period From '.date("F d, Y",strtotime($params['date_start'])).' up to date';
                    
                } else {

                    $period = 'No Date Indicated';
                }

                if ($data[$i]['GRP_CODE']) {
                    
                    $grp_id = array('GRP_CODE' => $data[$i]['GRP_CODE']);
                    $group = $this->Groups->fields('GRP_NAME')->get($grp_id);

                } else {
                    
                    $group = false;
                }
                
                $sheet->setCellValue('A1',$this->export_title);
                $sheet->setCellValue('A2',$period);
                $sheet->setCellValue('A3','Employee No.:');
                $sheet->setCellValue('B3',($data[$i]['EMP_CODE'] ? $data[$i]['EMP_CODE'] : ''));
                $sheet->setCellValue('A4','Employee Name:');
                $sheet->setCellValue('B4',$data[$i]['EMP_LNAME'].' '.$data[$i]['EMP_FNAME']);
                $sheet->setCellValue('E3','Group:');
                $sheet->setCellValue('F3',(!$group ? 'No Group' : $group['GRP_NAME']));
                $sheet->setCellValue('E4','Company:');
                $sheet->setCellValue('F4',(isset($data[$i]['company']) ? $data[$i]['company']['COMP_NAME'] : 'No Company'));

                $sheet->setCellValue('A6',"Date");
                $sheet->setCellValue('B6',"Time From");
                $sheet->setCellValue('C6',"Time To");
                $sheet->setCellValue('D6',"Activity Type");
                $sheet->setCellValue('E6',"Requester");
                $sheet->setCellValue('F6',"Participants");
                $sheet->setCellValue('G6','Location');
                $sheet->setCellValue('H6','Status');                

                $sheetitle = $data[$i]['EMP_LNAME'].' '.$data[$i]['EMP_FNAME'];

                if (strlen($sheetitle) > 31) {
                    
                    $title_change = substr($data[$i]['EMP_FNAME'],0,1).$data[$i]['EMP_LNAME'];

                    $sheetitle = (strlen($title_change) > 31 ? $data[$i]['RUSH_ID'] :$title_change);

                }
                
                $sheet->setTitle($sheetitle);

                $row = 7;
                $activity_participants = [];
                
                foreach ($activities as $activity) {
                    


                    $sheet->setCellValue('A'.$row,date("F d, Y",strtotime($activity['ACTIVITY_DATE'])));
                    $sheet->setCellValue('B'.$row,date("h:i a",strtotime($activity['TIME_FROM'])));
                    $sheet->setCellValue('C'.$row,date("h:i a",strtotime($activity['TIME_TO'])));
                    $sheet->setCellValue('D'.$row,$activity['ACTIVITY_TYPE']);
                    $sheet->setCellValue('E'.$row,$activity['EMP_NAME']);
                    $sheet->setCellValue('F'.$row,"".(!$activity['PARTICIPANTS'] && !$activity['VISITORS'] ? 'No Participants' : $activity['PARTICIPANTS']."\r".$activity['VISITORS'])."");
                    $sheet->setCellValue('G'.$row,$activity['LOCATION']);
                    $sheet->setCellValue('H'.$row,$activity['STATUS']);
                    $sheet->getStyle('F'.$row)->getAlignment()->setWrapText(true);
                    $row++;                    

                }

                $sheet->mergeCells('A1:E1');
                $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A1')->getFont()->setBold(true);
                $sheet->mergeCells('A2:E2');
                $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A6:H6')->getFont()->setBold(true);
                
                $sheet->getColumnDimension('A')->setWidth(16);
                $sheet->getColumnDimension('B')->setWidth(18);
                $sheet->getColumnDimension('C')->setWidth(13);
                $sheet->getColumnDimension('D')->setWidth(17);
                $sheet->getColumnDimension('E')->setWidth(20);
                $sheet->getColumnDimension('F')->setWidth(70);
                $sheet->getColumnDimension('H')->setWidth(11);                 

                $sheetIndex++;
            }

            $spreadsheet->setActiveSheetIndex(0);

            if ($params['date_start'] && $params['date_end']) {
                
                $filename = "DAR_".$params['date_start']."_to_".$params['date_end'].".xlsx";

            } else if($params['date_start']){

                $filename = "DAR_".$params['date_start'].".xlsx";
                
            } else {

                $filename = "DAR_".date("Y-m-d").".xlsx";
            }

            
            $writer = IOFactory::createWriter($spreadsheet,'Xlsx');
            header('Content-type: application/vnd.openxmlformats-officedocuments.spreadsheet.sheet');
            header('Content-Disposition: attachment;filename="'.$filename);
            
            $writer->save('php://output');            

        } else {

            return false;
        }

     }

     public function pdf($data,$params){
        
        if ($data) {
            
            $pdf = new MyPdf();
            $pdf->title = $this->export_title;
            
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->setHeaderMargin(10);
            $pdf->setFooterMargin(5); 
            
            $data_length = count($data);
            $sheetIndex = 0;
            
            for ($i=0; $i < $data_length; $i++) { 
                
                if ($data[$i]['EMP_CODE'] === 0) {
                    
                    continue;
                }
                
                /**
                 * Employee set Data ang paragraphs
                 */

                $employeeData = array(

                    'group' => $this->Groups->get(array('GRP_CODE' => $data[$i]['GRP_CODE']))['GRP_NAME'],
                    'company' => $this->Companies->get(array('COMP_CODE' => $data[$i]['COMP_CODE']))['COMP_NAME'],
                );

                $params['emp_code'] = $data[$i]['EMP_CODE'];
                $params['company'] = $data[$i]['COMP_CODE'];
                
                $query_string = $this->Reports->ReportBuilder('dar',$params);

                $activities = $this->custom($query_string." ORDER BY A.ACTIVITY_DATE ASC");
                
                if ($params['date_start'] && $params['date_end']) {
                    
                    $period = 'Period From '.date("F d, Y",strtotime($params['date_start'])).' to '.date("F d, Y",strtotime($params['date_end']));

                } else if($params['date_start']){

                    $period = 'Period From '.date("F d, Y",strtotime($params['date_start'])).' up to date';
                    
                } else {

                    $period = 'No Date Indicated';
                }
               
                /**
                 * End
                 */

                 /**
                  * PDF initial set up and column headers
                  */
                  $pdf->setFontSize(12);
                  $pdf->SetPrintHeader(true);
                  $pdf->addPage('L');

                  $pdf->Cell(0, 0, 'Period from '.date("F d, Y",strtotime($params['date_start'])).' to '.date("F d, Y",strtotime($params['date_end'])), 0, 1, 'C', 0, '', 0);
                  $pdf->Ln();
                  
                  $pdf->Cell(182, 0, 'Employee No: '.$data[$i]['EMP_CODE'], 0, 0, 'L', 0);
                  $pdf->Cell(85, 0, 'Group: '.$employeeData['group'], 0, 0, 'L', 0);
                  $pdf->Ln();
                  $pdf->Cell(182, 0, 'Employee Name: '.$data[$i]['EMP_LNAME'].', '.$data[$i]['EMP_FNAME'], 0, 0, 'L', 0);
                  $pdf->Cell(85, 0, 'Company: '.$employeeData['company'], 0, 0, 'L', 0);            
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
                  $pdf->Cell(30, 6, 'Date', 1, 0, 'L', 1);
                  $pdf->Cell(25, 6, 'Time From', 1, 0, 'L', 1);
                  $pdf->Cell(25, 6, 'Time To', 1, 0, 'L', 1);
                  $pdf->Cell(32, 6, 'Activity Type', 1, 0, 'L', 1);
                  $pdf->Cell(43, 6, 'Requester', 1, 0, 'L', 1);
                  $pdf->Cell(57, 6, 'Participants', 1, 0, 'L', 1);
                  $pdf->Cell(30, 6, 'Location', 1, 0, 'L', 1);
                  $pdf->Cell(25, 6, 'Status', 1, 0, 'L', 1);
                  $pdf->Ln();
                  
                  $pdf->SetFont('');
                  foreach ($activities as $activity) {
                    $pdf->SetPrintHeader(false);  
            
                    $participants = explode(', ',$activity['PARTICIPANTS']);
                    $visitors = explode(', ',$activity['VISITORS']);
                    $multiplier = 1;

                    if ($participants[0]) {

                        $participant_val = '';

                        $participants_length = count($participants);
                        if ($participants_length > 1) {
                            
                            $chunked = array_chunk($participants,1);
                            $multiplier = count($chunked);

                            foreach($chunked as $employee){

                                $participant_val.= implode('',$employee)."\n";
                            }
                            
                        } else {

                            $participant_val = $participants[0]."\n";
                        }

                    } else {

                        $participant_val = '';
                    }

                    if ($visitors[0]) {

                        $visitor_val = '';

                        $visitors_length = count($visitors);
                        if ($visitors_length > 1) {
                            
                            $chunkedVisitors = array_chunk($visitors,1);
                            $multiplier = $multiplier + count($chunkedVisitors);

                            foreach($chunkedVisitors as $visitor){

                                $visitor_val.= implode('',$visitor)."\n";
                            }
                            
                        } else {

                            $multiplier = $multiplier + 1;
                            $visitor_val = $visitors[0];
                        }

                    } else {

                        $visitor_val = '';
                    }
                                        
                    
                    $h = 4 * $multiplier;
                    $pdf->Cell(30, $h, date("F d, Y",strtotime($activity['ACTIVITY_DATE'])), 1, 0, 'L', 0);
                    $pdf->Cell(25, $h, date("h:i a",strtotime($activity['TIME_FROM'])), 1, 0, 'L', 0);
                    $pdf->Cell(25, $h, date("h:i a",strtotime($activity['TIME_TO'])), 1, 0, 'L', 0);
                    $pdf->Cell(32, $h, $activity['ACTIVITY_TYPE'], 1, 0, 'L', 0);
                    $pdf->Cell(43, $h, $activity['EMP_NAME'], 1, 0, 'L', 0);
                    $pdf->MultiCell(57, $h, $participant_val.$visitor_val,1,'L',0,0);
                    $pdf->Cell(30, $h, $activity['LOCATION'], 1, 0, 'L', 0);
                    $pdf->Cell(25, $h, $activity['STATUS'], 1, 0, 'L', 0);
                    $pdf->Ln();
                    
                  }
                  
            }
            $pdf->Output('DailyActivities.pdf', 'D');

        } else {

            return false;
        }
     }

}
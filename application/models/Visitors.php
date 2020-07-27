<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Html;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class Visitors extends MY_Model {

    public $table = 'nets_visit_log';
    public $primary_key = 'VISITOR_ID';
    public $timestamps = FALSE;
    public $export_title = "Visitor's Log Information";

    public function __construct(){

        $this->return_as = 'array';
        
        parent::__construct();

        $this->load->model('Groups');

        $this->has_one['employee'] = array(

            'foreign_model' => 'Employees',
            'foreign_table' => 'nets_emp_info',
            'foreign_key' => 'EMP_CODE',
            'local_key' => 'PERS_TOVISIT' 
        );
    }

    public function excel($data,$params){

        $spreadsheet = new SpreadSheet();
        $where = '';
        if ($data) {
            
            $data_length = count($data);
            $sheetIndex = 0;
            
            for($i=0; $i < $data_length; $i++){

                if (!isset($data[$i]['EMP_CODE'])) {
                    
                    continue;
                }

                if ($data[$i]['EMP_CODE'] === 0 || !isset($data[$i]['visitors'])) {
                    
                    continue;
                }

                $spreadsheet->createSheet();
                $sheet = $spreadsheet->setActiveSheetIndex($sheetIndex);

                if ($params['date_start'] && $params['date_end']) {
                    
                    $period = 'Period From '.date("F d, Y",strtotime($params['date_start'])).' to '.date("F d, Y",strtotime($params['date_end']));

                } else if($params['date_start']){

                    $period = 'Period From '.date("F d, Y",strtotime($params['date_start'])).'';
                    
                } else {

                    $period = ' ';
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
                $sheet->setCellValue('F3','Group:');
                $sheet->setCellValue('G3',(!$group ? 'No Group' : $group['GRP_NAME']));
                $sheet->setCellValue('F4','Company:');
                $sheet->setCellValue('G4',$data[$i]['company']['COMP_NAME']);

                $sheet->setCellValue('A6',"Date to Visit");
                $sheet->setCellValue('B6',"Checkin Time");
                $sheet->setCellValue('C6',"Checkout Time");
                $sheet->setCellValue('D6',"Visitor's Name");
                $sheet->setCellValue('E6',"Company");
                $sheet->setCellValue('F6',"Company Address");
                $sheet->setCellValue('G6','Email Address');
                $sheet->setCellValue('H6','Mobile No');
                $sheet->setCellValue('I6',"Landline");
                $sheet->setCellValue('J6',"Residential Address");
                $sheet->setCellValue('K6',"Purpose to Visit");
                $sheet->setCellValue('L6',"Person to Visit");
                $sheet->setCellValue('M6',"Body Temperature");
                $sheet->setCellValue('N6',"Do you have the following\nsickness/symptoms?");
                $sheet->setCellValue('O6',"Date when it\nstarted and ended?");
                $sheet->setCellValue('P6',"Travelled from a geographic\nlocation/country with documented\ncases of COVID19?");
                $sheet->setCellValue('Q6',"Travel Dates");
                $sheet->setCellValue('R6',"Exact place of Travel");
                $sheet->setCellValue('S6',"Date of return to\nPH/Metro Manila");
                $sheet->setCellValue('T6','Status');

                $sheetitle = $data[$i]['EMP_LNAME'].' '.$data[$i]['EMP_FNAME'];

                if (strlen($sheetitle) > 31) {
                    
                    $title_change = substr($data[$i]['EMP_FNAME'],0,1).$data[$i]['EMP_LNAME'];

                    $sheetitle = (strlen($title_change) > 31 ? $data[$i]['RUSH_ID'] :$title_change);

                }
                
                $sheet->setTitle($sheetitle);

                $row = 7;
                $visitors = $data[$i]['visitors'];

                foreach($data[$i]['visitors'] as $visitor){

                    $A2_definition = '';

                    if ($visitor['A2']) {

                        $A2 = json_decode($visitor['A2'],true);

                        if (count($A2) > 1) {
                            
                            for ($x=0; $x < count($A2); $x++) { 
                                
                                $A2_definition.= $this->define_sickness($A2[$x]).', ';
                            }
                            
                        } else {
    
                            $A2_definition = $this->define_sickness($A2[0]);
                        }
                        
                    }

                    $sheet->setCellValue('A'.$row,date("F d, Y",strtotime($visitor['VISIT_DATE'])));
                    $sheet->setCellValue('B'.$row,date("h:i:s a",strtotime($visitor['CHECKIN_TIME'])));
                    $sheet->setCellValue('C'.$row,date("h:i:s a",strtotime($visitor['CHECKOUT_TIME'])));
                    $sheet->setCellValue('D'.$row,$visitor['VISIT_LNAME'].' '.$visitor['VISIT_FNAME']);
                    $sheet->setCellValue('E'.$row,$visitor['COMP_NAME']);
                    $sheet->setCellValue('F'.$row,$visitor['COMP_ADDRESS']);
                    $sheet->setCellValue('G'.$row,$visitor['EMAIL_ADDRESS']);
                    $sheet->setCellValue('H'.$row,$visitor['MOBILE_NO']);
                    $sheet->setCellValue('I'.$row,$visitor['TEL_NO']);
                    $sheet->setCellValue('J'.$row,$visitor['RES_ADDRESS']);
                    $sheet->setCellValue('K'.$row,$visitor['VISIT_PURP']);
                    $sheet->setCellValue('L'.$row,$data[$i]['EMP_LNAME'].' '.$data[$i]['EMP_FNAME']);
                    $sheet->setCellValue('M'.$row,$visitor['A1']);
                    $sheet->setCellValue('N'.$row,$A2_definition);
                    $sheet->setCellValue('O'.$row,date("F d, Y",strtotime($visitor['A2DATES'])));
                    $sheet->setCellValue('P'.$row,$visitor['A3']);
                    $sheet->setCellValue('Q'.$row,date("F d, Y",strtotime($visitor['A3TRAVEL_DATES'])));
                    $sheet->setCellValue('R'.$row,$visitor['A3PLACE']);
                    $sheet->setCellValue('S'.$row,date("F d, Y",strtotime($visitor['A3RETURN_DATE'])));
                    $sheet->setCellValue('T'.$row,$this->define_status($visitor['STATUS']));                

                    $row++;
                    
                }
                
                $sheet->mergeCells('A1:G1');
                $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A1')->getFont()->setBold(true);
                $sheet->mergeCells('A2:G2');
                $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('B3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('N6:P6')->getAlignment()->setWrapText(true);
                $sheet->getStyle('S6')->getAlignment()->setWrapText(true);
                $sheet->getStyle('A6:T6')->getFont()->setBold(true);

                $sheet->getColumnDimension('A')->setWidth(17);
                $sheet->getColumnDimension('B')->setWidth(23);
                $sheet->getColumnDimension('C')->setWidth(14);
                $sheet->getColumnDimension('D')->setWidth(23);
                $sheet->getColumnDimension('E')->setWidth(30);
                $sheet->getColumnDimension('F')->setWidth(50);
                $sheet->getColumnDimension('G')->setWidth(28);
                $sheet->getColumnDimension('H')->setWidth(20);
                $sheet->getColumnDimension('I')->setWidth(20);
                $sheet->getColumnDimension('J')->setWidth(50);
                $sheet->getColumnDimension('K')->setWidth(45);
                $sheet->getColumnDimension('L')->setWidth(23);
                $sheet->getColumnDimension('M')->setWidth(17);
                $sheet->getColumnDimension('N')->setAutoSize(true);
                $sheet->getColumnDimension('O')->setWidth(18);
                $sheet->getColumnDimension('P')->setWidth(31);
                $sheet->getColumnDimension('Q')->setWidth(14);
                $sheet->getColumnDimension('R')->setWidth(30);
                $sheet->getColumnDimension('S')->setWidth(17);
                $sheet->getColumnDimension('T')->setWidth(28);               
                
                $sheetIndex++;
            }

            $spreadsheet->setActiveSheetIndex(0);

            if ($params['date_start'] && $params['date_end']) {
                
                $filename = "visitors_".$params['date_start']."_to_".$params['date_end'].".xlsx";

            } else if($params['date_start']){

                $filename = "visitors_".$params['date_start'].".xlsx";
                
            } else {

                $filename = "visitors_".date("Y-m-d").".xlsx";
            }

            
            $writer = IOFactory::createWriter($spreadsheet,'Xlsx');
            header('Content-type: application/vnd.openxmlformats-officedocuments.spreadsheet.sheet');
            header('Content-Disposition: attachment;filename="'.$filename);
            
            $writer->save('php://output');             

        } else {

            return false;
        }

    }

    public function define_status($status){
        
        $definition = false;

        if ($status) {
            
            switch ($status) {
                case 1:
                    $definition = 'For Confirmation';
                    break;
                case 2:
                    $definition = 'Confirmed';
                    break;
                case 3:
                    $definition = 'On-Going';
                    break;
                case 4:
                    $definition = 'Denied';
                    break;
                case 5:
                    $definition = 'Done';
                    break;
                case 6:
                    $definition = 'Cancelled';
                    break;              
                
                default:
                    $definition = ucwords(strtolower($status));
                    break;
            }            
        }



        return $definition;
    }

    public function define_sickness($sickness){

        $definition = false;

        if ($sickness) {

            switch ($sickness) {
                case 1:
                    $definition = 'Dry Cough';
                    break;
                case 2:
                    $definition = 'Sore Throat';
                    break;
                case 3:
                    $definition = 'Colds';
                    break;
                case 4:
                    $definition = 'Shortness of Breath';
                    break;
                case 5:
                    $definition = 'Diarrhea';
                    break;
                case 6:
                    $definition = 'Nausea or vomiting';
                    break;
                case 7:
                    $definition = 'Headache';
                    break;
                case 8:
                    $definition = 'Muscle pain and weakness';
                    break;
                case 9:
                    $definition = 'Decreased ability to smell';
                    break;
                case 10:
                    $definition = 'Decreased ability to taste';
                    break;
                case 11:
                    $definition = 'None';
                    break;
                default:
                    $definition = $sickness;
                    break;
            }
        }

        return $definition;
    }
}
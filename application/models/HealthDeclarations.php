<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Html;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class HealthDeclarations extends MY_Model {

    public $table = 'nets_emp_hdf';
    public $primary_key = 'HDF_ID';
    private $response = false;

    public function __construct(){

        $this->return_as = 'array';

        parent::__construct();

        $this->load->model('Groups');
        $this->load->model('Companies');

        $this->has_one['employee'] = array(

            'foreign_model' => 'Employees',
            'foreign_table' => 'nets_emp-info',
            'foreign_key' => 'EMP_CODE',
            'local_key' => 'EMP_CODE'

        );

        $this->has_many['diseases'] = array(

            'foreign_model' => 'Diseases',
            'foreign_table' => 'nets_hdf_chrnc_disease',
            'foreign_key' => 'ANSKEY',
            'local_key' => 'HDF_ID'            

        );

        $this->has_one['description'] = array(

            'foreign_model' => 'HealthDescriptions',
            'foreign_table' => 'nets_hdf_healthdec',
            'foreign_key' => 'HDF_ID',
            'local_key' => 'HDF_ID'

        );

        $this->has_one['household'] = array(

            'foreign_model' => 'HouseHolds',
            'foreign_table' => 'nets_hdf_hhold',
            'foreign_key' => 'HDF_ID',
            'local_key' => 'HDF_ID'

        );
        
        $this->has_one['info'] = array(

            'foreign_model' => 'OtherInfos',
            'foreign_table' => 'nets_hdf_otherinfo',
            'foreign_key' => 'HDF_ID',
            'local_key' => 'HDF_ID'

        );
        
        $this->has_one['travel'] = array(

            'foreign_model' => 'TravelHistory',
            'foreign_table' => 'nets_hdf_travelhistory',
            'foreign_key' => 'HDF_ID',
            'local_key' => 'HDF_ID'
        );

    }


    public function excel($data,$params){
        
        $spreadsheet = new SpreadSheet();

        if ($data) {
            
            $data_length = count($data);
            $end_ehc = date("Y-m-d",strtotime('-7 days',strtotime($params['cut_off'])));

            $sheet = $spreadsheet->GetActiveSheet();

            $sheet->setCellValue('A1','Health Declaration per Employee');
            $sheet->setCellValue('A2','As of '.date("F d, Y",strtotime($params['cut_off'])));
            
            $sheet->setCellValue('A6',"Last Name");
            $sheet->setCellValue('B6',"First Name");
            $sheet->setCellValue('C6',"Age");
            $sheet->setCellValue('D6',"Gender");
            $sheet->setCellValue('E6',"Civil Status");
            $sheet->setCellValue('F6',"Provincial Address");
            $sheet->setCellValue('G6',"Present Address/Home Address");
            $sheet->setCellValue('H6',"Telephone Number");
            $sheet->setCellValue('I6',"Mobile Number");
            $sheet->setCellValue('J6',"Company");
            //11
            $sheet->setCellValue('K6',"Group");
            $sheet->setCellValue('L6',"Type of current Residence");
            $sheet->setCellValue('M6',"If Renting, How often do you\ngo to your permanent address");
            $sheet->setCellValue('N6',"Total number of person\nin your households (number in figures)");
            $sheet->setCellValue('O6',"Number of Persons in your household\nwith ages 51 and above (number in figures)");
            $sheet->setCellValue('P6',"Do you live with someone diagnosed\nwith chronic diseases");
            $sheet->setCellValue('Q6',"Do you share room\nwith others?");
            $sheet->setCellValue('R6',"If yes, how many are you?");
            $sheet->setCellValue('S6',"Have you experienced\na fever in the last\n14 days?");
            $sheet->setCellValue('T6',"If yes, what is your\nhighest body temperature?");
            //21
            $sheet->setCellValue('U6',"Do you have the following\nsigns and symptoms?");
            $sheet->setCellValue('V6',"If yes, date when it\nstarted and ended");
            $sheet->setCellValue('W6',"What medications did you take?");
            $sheet->setCellValue('X6',"Many people during their lifetime\nwill experience or be treated for medical\nconditions. Please let us know which\nof the following you have\nhad, or been told you had,\nor sought advice or treatment for:");
            $sheet->setCellValue('Y6',"For the past 6 months,\nhave you consulted a medical doctor or\nbeen referred for tests or investigation\nor had any medical test?");
            $sheet->setCellValue('Z6',"If yes, Please specify the reason\nof the medical test");
            $sheet->setCellValue('AA6',"Do you have any health symptoms,\nrecurring or persistent pains, or complaints\nfor which physician has not been\nconsulted or treatment has not been received?");
            $sheet->setCellValue('AB6',"If Yes, Please specify the symptoms/recurring\npain/complaints, and the\nperiod of sickness");
            $sheet->setCellValue('AC6',"Travelled from a geographic/locations with\ndocumented cases of COVID19? (see attached DOH list)");
            $sheet->setCellValue('AD6',"If yes, Please indicate\nTravel dates");
            //31
            $sheet->setCellValue('AE6',"State the exact place of travel");
            $sheet->setCellValue('AF6',"Date of return to\nPH/Metro Manila");
            $sheet->setCellValue('AG6',"Do you have a scheduled trip\nabroad or local for the next 3 months?");
            $sheet->setCellValue('AH6',"If yes, Please state the Travel dates");
            $sheet->setCellValue('AI6',"State the exact place of travel");
            $sheet->setCellValue('AJ6',"Date of return to\nPH/Metro Manila");
            $sheet->setCellValue('AK6',"Close contact to a PUI\nor confirmed case of the disease (COVID 19)? ");
            $sheet->setCellValue('AL6',"If yes, Please state date of contact");
            $sheet->setCellValue('AM6',"History of visit to a HEALTHCARE facility\nin a geographic location/country where documented\ncases of COVID19 have been reported?");
            $sheet->setCellValue('AN6',"If yes, please state the name\nof the Healthcare facility");
            //41
            $sheet->setCellValue('AO6',"Date visited");
            $sheet->setCellValue('AP6',"Exposure with patients who are Probable\nCOVID19 patients who are awaiting results");
            $sheet->setCellValue('AQ6',"If Yes, please state\nthe details of exposure");
            $sheet->setCellValue('AR6',"Exposure from Relatives or Friends\nwith recent travel to location/country\nwith documented cases of COVID19\nand/or had direct exposure with\nconfirmed COVID19 case?");
            $sheet->setCellValue('AS6',"If yes, State the date\nof travel/exposure");
            $sheet->setCellValue('AT6',"Any Signs/Symptoms experienced\nby the person/s?");
            $sheet->setCellValue('AU6',"Have you recently traveled to an\narea with known local spread of Covid-19 \n(e.g. hospital, supermarket, drug store and etc)");
            $sheet->setCellValue('AV6',"If yes, please state the exact place");
            $sheet->setCellValue('AW6',"Are there any frontliners\nin your household?");
            $sheet->setCellValue('AX6',"Type of Frontliner");
            //51
            $sheet->setCellValue('AY6',"How often do you or your family\nmember go out for i.e. for grocery shopping etc");
            $sheet->setCellValue('AZ6',"Who often goes out\nof the house?");

            $sheet->setTitle('Health Declaration Sheet');            
            $healthDeclarations = false;
            $row = 7;
 
            if ($params['emp_code']) {
                
                $where['EMP_CODE'] = $params['emp_code'];
                $id = array('EMP_Code' => $params['emp_code']);
            }
            
            $where['HDF_DATE'] = $params['cut_off'];

            $employees = $this->Employees
            ->where((isset($id) ? $id : ''))
            ->order_by('EMP_LNAME','ASC')
            ->with_healthDeclarations('fields:HDF_ID','where: HDF_DATE="'.$where['HDF_DATE'].'"')
            ->get_all();
            
            $healthDeclarations = $this->where($where)
            ->with_diseases()
            ->with_info()
            ->with_description()
            ->with_household()
            ->with_travel()
            ->with_employee('order_by:EMP_LNAME,asc')
            ->get_all();
            
            foreach($healthDeclarations as $hdf){

                if (!$healthDeclarations) {
                
                    continue;
                }

                if ($params['group']) {
                    
                    if ($hdf['employee']['GRP_CODE'] !== $params['group']) {
                        
                        continue;
                    }
                }

                if ($params['company']) {
                    
                    if ($hdf['employee']['COMP_CODE'] !== $params['company']) {
                        
                        continue;
                    }
                }                

                if (!isset($hdf['household']) || !isset($hdf['description'])) {
                
                    continue;
                }
                
                if (!isset($hdf['travel']) || !isset($hdf['info'])) {
                    
                    continue;
                }

                if (!isset($hdf['diseases'])) {
                    
                    continue;
                }

                $ehc = $this->HealthChecks->where('EMP_CODE',$hdf['EMP_CODE'])
                ->where_between('EHC_DATE',$end_ehc,$params['cut_off'])
                ->fields('A3')->get_all();

                if ($ehc == false) {
                    
                    $A3 = 'None';

                } else {

                    $A3 = [];
                }

                $A3_none = 'None';
                
                if ($A3 !== 'None') {
                    
                    foreach ($ehc as $answer3) {
                    
                        $answers = json_decode($answer3['A3'],true);
    
                        if ($answers[0] === $A3_none) {
                            
                            continue;
                        }
    
                        foreach ($answers as $answer) {
                            
                            if ($answer === $A3_none) {
                                
                                continue;
                            }
    
                            array_push($A3,$answer);
                        }
                        
                    }                    
                }

                $descA3 = json_decode($hdf['description']['A3'],true);
                $infoA3 = json_decode($hdf['info']['A3'],true);

                $disease_list = $hdf['diseases'];
                $diseases = [];

                if ($hdf['employee']['GRP_CODE']) {
                    
                    $id = array('GRP_CODE' => $hdf['employee']['GRP_CODE']);
                    $group = $this->Groups->fields('GRP_NAME')->get($id);

                } else {
                    
                    $group = false;
                }

                if ($hdf['employee']['COMP_CODE']) {
                    
                    $id = array('COMP_CODE' => $hdf['employee']['COMP_CODE']);
                    $company = $this->Companies->fields('COMP_NAME')->get($id);

                } else {
                    
                    $company = false;
                }                

                foreach ($disease_list as $disease_data) {
                    
                    array_push($diseases,$disease_data['DISEASE']);
                }

                $frontliners = json_decode($hdf['info']['A5FRONTLINER'],true);

                $sheet->setCellValue('A'.$row, $hdf['employee']['EMP_LNAME']);
                $sheet->setCellValue('B'.$row, $hdf['employee']['EMP_FNAME']);
                $sheet->setCellValue('C'.$row, $hdf['employee']['AGE']);
                $sheet->setCellValue('D'.$row, $hdf['employee']['GENDER']);
                $sheet->setCellValue('E'.$row, $hdf['employee']['CIVIL_STAT']);
                $sheet->setCellValue('F'.$row, $hdf['employee']['PRESENT_PROV']);
                $sheet->setCellValue('G'.$row, $hdf['employee']['PRESENT_ADDR1']);
                $sheet->setCellValue('H'.$row, $hdf['employee']['TEL_NO']);
                $sheet->setCellValue('I'.$row, $hdf['employee']['MOBILE_NO']);
                $sheet->setCellValue('J'.$row, (!$company ? 'No Company' : $company['COMP_NAME']));
                //
                $sheet->setCellValue('K'.$row, (!$group ? 'No Group' : $group['GRP_NAME']));
                $sheet->setCellValue('L'.$row, $hdf['household']['A1']);
                $sheet->setCellValue('M'.$row, $hdf['household']['A2']);
                $sheet->setCellValue('N'.$row, $hdf['household']['A3']);
                $sheet->setCellValue('O'.$row, $hdf['household']['A4']);
                $sheet->setCellValue('P'.$row, implode(', ',$diseases));
                $sheet->setCellValue('Q'.$row, $hdf['household']['A6']);
                $sheet->setCellValue('R'.$row, $hdf['household']['A6HOWMANY']);
                $sheet->setCellValue('S'.$row, $hdf['description']['A1']);
                $sheet->setCellValue('T'.$row, $hdf['description']['A1TEMP']);
                //
                $sheet->setCellValue('U'.$row, (is_array($A3) ? implode(', ',$A3) : $A3));
                $sheet->setCellValue('V'.$row, $hdf['description']['A5PERIOD']);
                $sheet->setCellValue('W'.$row, $hdf['description']['A2']);
                $sheet->setCellValue('X'.$row, implode(', ',$descA3));
                $sheet->setCellValue('Y'.$row, $hdf['description']['A4']);
                $sheet->setCellValue('Z'.$row, $hdf['description']['A4REASON']);
                $sheet->setCellValue('AA'.$row, $hdf['description']['A5']);
                $sheet->setCellValue('AB'.$row, $hdf['description']['A5SYMPTOMS']);
                $sheet->setCellValue('AC'.$row, $hdf['travel']['A1']);
                $sheet->setCellValue('AD'.$row, $hdf['travel']['A1TRAVEL_DATES']);
                //
                $sheet->setCellValue('AE'.$row, $hdf['travel']['A1PLACE']);
                $sheet->setCellValue('AF'.$row, $hdf['travel']['A1RETURN_DATE']);
                $sheet->setCellValue('AG'.$row, $hdf['travel']['A2']);
                $sheet->setCellValue('AH'.$row, $hdf['travel']['A2TRAVEL_DATES']);
                $sheet->setCellValue('AI'.$row, $hdf['travel']['A2PLACE']);
                $sheet->setCellValue('AJ'.$row, $hdf['travel']['A2RETURN_DATE']);
                $sheet->setCellValue('AK'.$row, $hdf['travel']['A3']);
                $sheet->setCellValue('AL'.$row, $hdf['travel']['A3CONTACT_DATE']);
                $sheet->setCellValue('AM'.$row, $hdf['travel']['A4']);
                $sheet->setCellValue('AN'.$row, $hdf['travel']['A4NAME']);
                //
                $sheet->setCellValue('AO'.$row, $hdf['travel']['A4VISIT_DATE']);
                $sheet->setCellValue('AP'.$row, $hdf['info']['A1']);
                $sheet->setCellValue('AQ'.$row, $hdf['info']['A1DETAILS']);
                $sheet->setCellValue('AR'.$row, $hdf['info']['A2']);
                $sheet->setCellValue('AS'.$row, $hdf['info']['A2EXPOSURE_DATE']);
                $sheet->setCellValue('AT'.$row, implode(', ',$infoA3));
                $sheet->setCellValue('AU'.$row, $hdf['info']['A4']);
                $sheet->setCellValue('AV'.$row, $hdf['info']['A4PLACE']);
                $sheet->setCellValue('AW'.$row, $hdf['info']['A5']);
                $sheet->setCellValue('AX'.$row, ($hdf['info']['A5FRONTLINER'] !== 'null' ? implode(', ',$frontliners) : 'n/a'));
                //
                $sheet->setCellValue('AY'.$row, $hdf['info']['A6']);
                $sheet->setCellValue('AZ'.$row, $hdf['info']['A7']);

                $row++;
            }    

            $sheet->mergeCells('A1:L1');
            $sheet->mergeCells('A2:L2');
            $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A1')->getFont()->setBold(true);

            $sheet->getStyle('M6:Q6')->getAlignment()->setWrapText(true);
            $sheet->getStyle('S6:V6')->getAlignment()->setWrapText(true);
            $sheet->getStyle('X6:AD6')->getAlignment()->setWrapText(true);
            $sheet->getStyle('AF6:AG6')->getAlignment()->setWrapText(true);
            $sheet->getStyle('AJ6:AK6')->getAlignment()->setWrapText(true);
            $sheet->getStyle('AN6')->getAlignment()->setWrapText(true);
            $sheet->getStyle('AP6:AU6')->getAlignment()->setWrapText(true);
            $sheet->getStyle('AW6')->getAlignment()->setWrapText(true);
            $sheet->getStyle('AY6:AZ6')->getAlignment()->setWrapText(true);
            
            $sheet->getColumnDimension('A')->setWidth(15);
            $sheet->getColumnDimension('B')->setWidth(15);
            $sheet->getColumnDimension('D')->setWidth(9);
            $sheet->getColumnDimension('E')->setWidth(13);
            $sheet->getColumnDimension('F')->setWidth(16);
            $sheet->getColumnDimension('G')->setWidth(30);
            $sheet->getColumnDimension('H')->setWidth(23);
            $sheet->getColumnDimension('I')->setWidth(17);
            $sheet->getColumnDimension('J')->setWidth(14);
            $sheet->getColumnDimension('L')->setWidth(31);
            $sheet->getColumnDimension('M')->setWidth(34);
            $sheet->getColumnDimension('N')->setWidth(27);
            $sheet->getColumnDimension('O')->setWidth(31);
            $sheet->getColumnDimension('P')->setWidth(34);
            $sheet->getColumnDimension('Q')->setWidth(22);
            $sheet->getColumnDimension('R')->setWidth(29);
            $sheet->getColumnDimension('S')->setWidth(19);
            $sheet->getColumnDimension('T')->setWidth(22);
            $sheet->getColumnDimension('U')->setWidth(19);
            $sheet->getColumnDimension('V')->setWidth(22);
            $sheet->getColumnDimension('W')->setWidth(30);
            $sheet->getColumnDimension('X')->setWidth(36);
            $sheet->getColumnDimension('Y')->setWidth(43);
            $sheet->getColumnDimension('Z')->setWidth(30);
            $sheet->getColumnDimension('AA')->setWidth(54);
            $sheet->getColumnDimension('AB')->setWidth(29);
            $sheet->getColumnDimension('AC')->setWidth(37);
            $sheet->getColumnDimension('AD')->setWidth(17);
            $sheet->getColumnDimension('AE')->setWidth(24);
            $sheet->getColumnDimension('AF')->setWidth(20);
            $sheet->getColumnDimension('AG')->setWidth(33);
            $sheet->getColumnDimension('AH')->setWidth(31);
            $sheet->getColumnDimension('AI')->setWidth(24);
            $sheet->getColumnDimension('AJ')->setWidth(20);
            $sheet->getColumnDimension('AK')->setWidth(29);
            $sheet->getColumnDimension('AL')->setWidth(26);
            $sheet->getColumnDimension('AN')->setWidth(29);
            $sheet->getColumnDimension('AO')->setWidth(14);
            $sheet->getColumnDimension('AP')->setWidth(48);
            $sheet->getColumnDimension('AQ')->setWidth(27);
            $sheet->getColumnDimension('AR')->setWidth(35);
            $sheet->getColumnDimension('AS')->setWidth(25);
            $sheet->getColumnDimension('AT')->setWidth(39);
            $sheet->getColumnDimension('AU')->setWidth(54);
            $sheet->getColumnDimension('AV')->setWidth(41);
            $sheet->getColumnDimension('AW')->setWidth(28);
            $sheet->getColumnDimension('AX')->setWidth(22);
            $sheet->getColumnDimension('AY')->setWidth(38);
            $sheet->getColumnDimension('AZ')->setWidth(25);           

            
            $sheet->getStyle('A6:AZ6')->getFont()->setBold(true);            

            $filename = "HDF_".$params['cut_off'].".xlsx";
            $writer = IOFactory::createWriter($spreadsheet,'Xlsx');
            header('Content-type: application/vnd.openxmlformats-officedocuments.spreadsheet.sheet');
            header('Content-Disposition: attachment;filename="'.$filename);
            
            $writer->save('php://output');            
        }
    }
}
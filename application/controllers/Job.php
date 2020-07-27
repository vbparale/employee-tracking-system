<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Job extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

    public function __construct() {

        parent::__construct();

        $this->load->library('session');

        // load model
        $this->load->model('job_model');

    }

    public function send_email_notif($data){
        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // More headers
        $headers .= 'From: Employee Tracking System <no-reply-ets@federalland.ph>' . "\r\n";
        $to = $data['recipient'];
        $subject = $data['subject'];
        $msg = $data['msg'];
        // $msg = wordwrap($msg, 70);
        $result = mail($to,$subject,$msg,$headers);
        return $result;
    }

    public function send_sms_notif($data){
        $this->load->library('SMS');
        $result = $this->sms->send([
            'mobile' => $data['recipient'],
            'message' => $data['msg'],
        ]);
        return $result;
    }

    // run every 12AM
    public function reset_user_ehc(){
        $this->job_model->reset_user_ehc();
    }
    
    // run 5 mins before sending ehc reminder
    public function reset_notif(){
        $this->job_model->reset_notif();
    }

    // send reminder to employees with no ehc
    public function get_no_ehc(){

        $data = $this->job_model->get_no_ehc();
        
        for($x = 0; $x < count($data); $x++){
            if(isset($data[$x]['EMAIL_ADDRESS']) || !empty($data[$x]['EMAIL_ADDRESS'])){
                $email_header = array(
                    'recipient' => $data[$x]['EMAIL_ADDRESS'],
                    'subject' => 'ETS – EMPLOYEE HEALTH CHECK Reminder',
                    'msg' => 'Dear '.$data[$x]['EMP_FNAME'].' '.$data[$x]['EMP_LNAME'].':<br><br>This is a gentle reminder to update your Daily Health Check for today, '.date('Y/m/d').'. Kindly update your DHC until 1:00 PM only. <br><br>To update the Daily Health Check, please copy the link below and paste it into your browser’s address bar.<br><br>'.base_url('login').'.<br><br>Any update after the said cutoff will require you to state your reason for late update and will be subject for approval of your Immediate Head and Group/Division Head in Rush.Net. <br><br>Please disregard this message if you already answered the DHC.<br><br>For DHC concerns please send an e-mail to Ms. Jhil Soliman or Ms. Mai Orda.<br><br>Thank you and stay safe!<br><br>Human Resources<br><br>Disclaimer: This communication is intended solely for the individual to whom it is addressed. If you are not the intended recipient of this communication, you may not disseminate, distribute, copy or otherwise disclose or use the contents of this communication without the written authority of Federal Land, Inc (FLI). If you have received this communication in error, please delete and destroy all copies and kindly notify the sender by return email or telephone immediately. Thank you!'
                );
                $email_result = $this->send_email_notif($email_header);

                $this->job_model->reset_sent_notif($data[$x]['EMP_CODE']);
            }
            
            if(isset($data[$x]['MOBILE_NO']) || !empty($data[$x]['MOBILE_NO'])){
                $sms_header = array(
                    'recipient' => $data[$x]['MOBILE_NO'],
                    'msg' => 'Good day, '.$data[$x]['EMP_FNAME'].' '.$data[$x]['EMP_LNAME'].'! This is a gentle reminder to update your Daily Health Check for today, '.date('Y/m/d').'. Kindly update your DHC until 1:00 PM only. Here’s the link to access: '.base_url('login').'. Please disregard this message if you already answered the DHC. Thank you and stay safe!'
                );
                $sms_result = $this->send_sms_notif($sms_header);
                
                $this->job_model->reset_sent_notif($data[$x]['EMP_CODE']);
            }

        }
    }

    // send reminder to group heads
    public function send_ehc_reminder_heads(){
        $heads = $this->job_model->get_div_heads();

        for($x = 0; $x < count($heads); $x++){
            $no_ehc = $this->job_model->get_employees_with_no_ehc_per_div($heads[$x]['GRP_CODE']);

            if(count($no_ehc) > 0){
                $list_of_employees = '<ul>';
                for($y = 0; $y < count($no_ehc); $y++){
                    $list_of_employees .= '<li>'.$no_ehc[$y]['EMP_FNAME'].' '.$no_ehc[$y]['EMP_LNAME'].'</li>';
                }
                $list_of_employees .= '</ul>';

                $message = 'Dear '.$heads[$x]['EMP_FNAME'].' '.$heads[$x]['EMP_LNAME'].':<br><br>Good day!<br><br>As part of our Health and Safety initiative, we encourage our employees to answer the Daily Health Check for a quick health update.<br><br>These are the following employees who haven’t answered the DHC for today, '.date('Y/m/d').': <br><br>'.$list_of_employees.'<br><br>We are hoping for your cooperation in reminding our employees. To update the Daily Health Check, please advise the employees to copy the link below and paste it into your browser’s address bar.<br><br>'.base_url('login').'<br><br>Kindly update the DHC until 1:00 PM only.  Any update after the said cutoff will require the employees to state their reason for late update and will be subject for approval of the Immediate Head and Group/Division Head in Rush.Net. <br><br>For DHC concerns please send an e-mail to Ms. Jhil Soliman or Ms. Mai Orda.<br><br>Thank you and stay safe!<br><br>Human Resources<br><br>Disclaimer: This communication is intended solely for the individual to whom it is addressed. If you are not the intended recipient of this communication, you may not disseminate, distribute, copy or otherwise disclose or use the contents of this communication without the written authority of Federal Land, Inc (FLI). If you have received this communication in error, please delete and destroy all copies and kindly notify the sender by return email or telephone immediately. Thank you!';

                
                // Always set content-type when sending HTML email
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                // More headers
                $headers .= 'From: Employee Tracking System <no-reply-ets@federalland.ph>' . "\r\n";
                // should enable in prod
                $headers .= 'Cc: jdbagalay@federalland.ph' . "\r\n"; 

                $to = $heads[$x]['EMAIL_ADDRESS'];
                $subject = 'ETS - EMPLOYEE HEALTH CHECK - '.$heads[$x]['GRP_CODE'].' REMINDER';
                $msg = $message;
                // $msg = wordwrap($msg, 70);
                $result = mail($to,$subject,$msg,$headers);
            }
        }
    }

    // run every 5 mins 24/7
    public function update_pending_ehc(){
        $this->load->library('rush');
        $rush_tickets = $this->job_model->get_pending_ehc();

        for($x = 0; $x < count($rush_tickets); $x++){
            $rushno = $rush_tickets[$x]['RUSHNO'];
            $status =  $this->rush->rushPOST('GetStatCd',[
                'REQST_NUM' => $rushno
            ]);
            if($status != 'I'){
                $new_status = array(
                    'RUSHNO' => $rushno,
                    'COLUMN' => 'STATUS',
                    'VALUE' => $status
                );
                $this->job_model->update_ehc($new_status);
                $status_date = array(
                    'RUSHNO' => $rushno,
                    'COLUMN' => 'STATUS_DATE',
                    'VALUE' => date("Y/m/d h:i:sa")
                );
                $this->job_model->update_ehc($status_date);
                $last_checked = array(
                    'RUSHNO' => $rushno,
                    'COLUMN' => 'LAST_CHECKED',
                    'VALUE' => date("Y/m/d h:i:sa")
                );
                $this->job_model->update_ehc($last_checked);
            }
            else{
                $last_checked = array(
                    'RUSHNO' => $rushno,
                    'COLUMN' => 'LAST_CHECKED',
                    'VALUE' => date("Y/m/d h:i:sa")
                );
                $this->job_model->update_ehc($last_checked);
            }

        }
    }

    // HDF jobs

    // run at 8:30AM 1 day every 5 mins before submission date
    public function send_notif_day_before(){
        $details = $this->job_model->get_hdf_cutoff_details(date('Y-m-d', strtotime(' +1 day')));
        $details[0]['CUTOFF_TIME'] = date("g:i A", strtotime($details[0]['CUTOFF_TIME']));
        if(count($details) > 0){
            if($details[0]['EMP_FLAG'] == 1){
                $employees = $this->job_model->get_all_emp_info();
                for($x = 0; $x < count($employees); $x++){
                    if(isset($employees[$x]['EMAIL_ADDRESS']) || !empty($employees[$x]['EMAIL_ADDRESS'])){
                        $email_headers = array(
                            'recipient' => $employees[$x]['EMAIL_ADDRESS'],
                            'subject' => 'ETS - HEALTH DECLARATION FORM COMPLETION - REMINDER',
                            'msg' => 'Dear '.$employees[$x]['EMP_FNAME'].' '.$employees[$x]['EMP_LNAME'].':<br><br>This is a gentle reminder to answer the Health Declaration Form.<br>Please submit it on '.$details[0]['SUBMISSION_DATE'].' until '.$details[0]['CUTOFF_TIME'].' only.<br><br>To complete the Health Declaration Form, please copy the link below and paste it into your browser\'s address bar.<br><br>'.base_url('login').'.<br><br>Please disregard this message if you already answered the HDF.<br><br>Thank you and stay safe!<br><br>Human Resources<br><br>Disclaimer: This communication is intended solely for the individual to whom it is addressed. If you are not the intended recipient of this communication, you may not disseminate, distribute, copy or otherwise disclose or use the contents of this communication without the written authority of Federal Land, Inc (FLI). If you have received this communication in error, please delete and destroy all copies and kindly notify the sender by return email or telephone immediately. Thank you!'
                        );
                        $this->send_hdf_email($email_headers);

                        $this->job_model->update_sent_hdf_notif($employees[$x]['EMP_CODE']);
                    }
                    
                    if(isset($employees[$x]['MOBILE_NO']) || !empty($employees[$x]['MOBILE_NO'])){
                        $sms_headers = array(
                            'recipient' => $employees[$x]['MOBILE_NO'],
                            'msg' => 'Good day, '.$employees[$x]['EMP_FNAME'].' '.$employees[$x]['EMP_LNAME'].'! This is a gentle reminder to answer the Health Declaration Form. Please submit it on '.$details[0]['SUBMISSION_DATE'].' until '.$details[0]['CUTOFF_TIME'].' only. Here’s the link to access: '.base_url('login').'. Please disregard this message if you already answered the HDF. Thank you and stay safe!'
                        );
                        $this->send_hdf_sms($sms_headers);
                        
                        $this->job_model->update_sent_hdf_notif($employees[$x]['EMP_CODE']);
                    }
                }
            }
            else if($details[0]['EMP_FLAG'] == 2){
                $login_ids = $this->job_model->get_hdf_required_employee($details[0]['CUTOFFID']);
                $emp_code = array_column($login_ids, 'EMP_CODE');
                $employees = $this->job_model->get_info_required_emps($emp_code);
                for($x = 0; $x < count($employees); $x++){
                    if(isset($employees[$x]['EMAIL_ADDRESS']) || !empty($employees[$x]['EMAIL_ADDRESS'])){
                        $email_headers = array(
                            'recipient' => $employees[$x]['EMAIL_ADDRESS'],
                            'subject' => 'ETS - HEALTH DECLARATION FORM COMPLETION - REMINDER',
                            'msg' => 'Dear '.$employees[$x]['EMP_FNAME'].' '.$employees[$x]['EMP_LNAME'].':<br><br>This is a gentle reminder to answer the Health Declaration Form.<br>Please submit it on '.$details[0]['SUBMISSION_DATE'].' until '.$details[0]['CUTOFF_TIME'].' only. <br><br>To complete the Health Declaration Form, please copy the link below and paste it into your browser\'s address bar.<br>'.base_url('login').'.<br><br>Thank you and stay safe!<br><br>Human Resources<br><br>Disclaimer: This communication is intended solely for the individual to whom it is addressed. If you are not the intended recipient of this communication, you may not disseminate, distribute, copy or otherwise disclose or use the contents of this communication without the written authority of Federal Land, Inc (FLI). If you have received this communication in error, please delete and destroy all copies and kindly notify the sender by return email or telephone immediately. Thank you!'
                        );
                        $this->send_hdf_email($email_headers);

                        $this->job_model->update_sent_hdf_notif($employees[$x]['EMP_CODE']);
                    }

                    if(isset($employees[$x]['MOBILE_NO']) || !empty($employees[$x]['MOBILE_NO'])){
                        $sms_headers = array(
                            'recipient' => $employees[$x]['MOBILE_NO'],
                            'msg' => 'Good day, '.$employees[$x]['EMP_FNAME'].' '.$employees[$x]['EMP_LNAME'].'! This is a gentle reminder to answer the Health Declaration Form. Please submit it on '.$details[0]['SUBMISSION_DATE'].' until '.$details[0]['CUTOFF_TIME'].' only. Here’s the link to access: '.base_url('login').'. Thank you and stay safe!'
                        );
                        $this->send_hdf_sms($sms_headers);
                        $this->job_model->update_sent_hdf_notif($employees[$x]['EMP_CODE']);
                    }
                }
            }
        }
    }

    public function send_notif_submission_date(){
        $details = $this->job_model->get_hdf_cutoff_details(date('Y-m-d'));
        $details[0]['CUTOFF_TIME'] = date("g:i A", strtotime($details[0]['CUTOFF_TIME']));
        if(count($details) > 0){
            if($details[0]['EMP_FLAG'] == 1){
                $employees = $this->job_model->get_all_emp_info();
                for($x = 0; $x < count($employees); $x++){
                    if(isset($employees[$x]['EMAIL_ADDRESS']) || !empty($employees[$x]['EMAIL_ADDRESS'])){
                        $email_headers = array(
                            'recipient' => $employees[$x]['EMAIL_ADDRESS'],
                            'subject' => 'ETS - HEALTH DECLARATION FORM COMPLETION - REMINDER',
                            'msg' => 'Dear '.$employees[$x]['EMP_FNAME'].' '.$employees[$x]['EMP_LNAME'].':<br><br>This is a gentle reminder to answer the Health Declaration Form.<br>Please submit it on '.$details[0]['SUBMISSION_DATE'].' until '.$details[0]['CUTOFF_TIME'].' only.<br><br><br>To complete the Health Declaration Form, please copy the link below and paste it into your browser\'s address bar.<br><br>'.base_url('login').'.<br><br>Please disregard this message if you already answered the HDF.<br><br>Thank you and stay safe!<br><br>Human Resources<br><br>Disclaimer: This communication is intended solely for the individual to whom it is addressed. If you are not the intended recipient of this communication, you may not disseminate, distribute, copy or otherwise disclose or use the contents of this communication without the written authority of Federal Land, Inc (FLI). If you have received this communication in error, please delete and destroy all copies and kindly notify the sender by return email or telephone immediately. Thank you!'
                        );
                        $this->send_hdf_email($email_headers);

                        $this->job_model->update_sent_hdf_notif($employees[$x]['EMP_CODE']);
                    }
                    if(isset($employees[$x]['MOBILE_NO']) || !empty($employees[$x]['MOBILE_NO'])){
                        $sms_headers = array(
                            'recipient' => $employees[$x]['MOBILE_NO'],
                            'msg' => 'Good day, '.$employees[$x]['EMP_FNAME'].' '.$employees[$x]['EMP_LNAME'].'! This is a gentle reminder to answer the Health Declaration Form. Please submit it on '.$details[0]['SUBMISSION_DATE'].' until '.$details[0]['CUTOFF_TIME'].' only. Here’s the link to access: '.base_url('login').'. Please disregard this message if you already answered the HDF. Thank you and stay safe!'
                        );
                        $this->send_hdf_sms($sms_headers);

                        $this->job_model->update_sent_hdf_notif($employees[$x]['EMP_CODE']);
                    }
                }
            }
            else if($details[0]['EMP_FLAG'] == 2){
                $login_ids = $this->job_model->get_hdf_required_employee($details[0]['CUTOFFID']);
                $emp_code = array_column($login_ids, 'EMP_CODE');
                $employees = $this->job_model->get_info_required_emps($emp_code);
                for($x = 0; $x < count($employees); $x++){
                    if(isset($employees[$x]['EMAIL_ADDRESS']) || !empty($employees[$x]['EMAIL_ADDRESS'])){
                        $email_headers = array(
                            'recipient' => $employees[$x]['EMAIL_ADDRESS'],
                            'subject' => 'ETS - HEALTH DECLARATION FORM COMPLETION - REMINDER',
                            'msg' => 'Dear '.$employees[$x]['EMP_FNAME'].' '.$employees[$x]['EMP_LNAME'].':<br><br>This is a gentle reminder to answer the Health Declaration Form.<br>Please submit it on '.$details[0]['SUBMISSION_DATE'].' until '.$details[0]['CUTOFF_TIME'].' only.<br><br><br>To complete the Health Declaration Form, please copy the link below and paste it into your browser\'s address bar.<br><br>'.base_url('login').'.<br><br>Thank you and stay safe!<br><br>Human Resources<br><br>Disclaimer: This communication is intended solely for the individual to whom it is addressed. If you are not the intended recipient of this communication, you may not disseminate, distribute, copy or otherwise disclose or use the contents of this communication without the written authority of Federal Land, Inc (FLI). If you have received this communication in error, please delete and destroy all copies and kindly notify the sender by return email or telephone immediately. Thank you!'
                        );
                        $this->send_hdf_email($email_headers);

                        $this->job_model->update_sent_hdf_notif($employees[$x]['EMP_CODE']);
                    }

                    if(isset($employees[$x]['MOBILE_NO']) || !empty($employees[$x]['MOBILE_NO'])){
                        $sms_headers = array(
                            'recipient' => $employees[$x]['MOBILE_NO'],
                            'msg' => 'Good day, '.$employees[$x]['EMP_FNAME'].' '.$employees[$x]['EMP_LNAME'].'! This is a gentle reminder to answer the Health Declaration Form. Please submit it on '.$details[0]['SUBMISSION_DATE'].' until '.$details[0]['CUTOFF_TIME'].' only. Here’s the link to access: '.base_url('login').'. Thank you and stay safe!'
                        );
                        $this->send_hdf_sms($sms_headers);

                        $this->job_model->update_sent_hdf_notif($employees[$x]['EMP_CODE']);
                    }
                }
            }
        }
    }

    // reset all submitted hdf
    public function reset_submitted_hdf_and_hdf_notif(){
        $details = $this->job_model->get_hdf_cutoff_details(date('Y-m-d'));
        $this->job_model->reset_hdf_notif();
        
        if(count($details) > 0){
            if($details[0]['EMP_FLAG'] == 1){
                $data = null;
                $this->job_model->reset_submitted_hdf($data);
            }
            else if($details[0]['EMP_FLAG'] == 2){
                $data = $this->job_model->get_hdf_required_employee($details[0]['CUTOFFID']);
                for($x = 0; $x < count($data); $x++){
                    $this->job_model->reset_submitted_hdf($data[$x]['EMP_CODE']);
                }
            }
        }
    }

    // reset sent_hdf_notif before sending reminder
    public function reset_sent_hdf_notif(){
        $details = $this->job_model->get_hdf_cutoff_details(date('Y-m-d'));
        
        if(count($details) > 0){
            if($details[0]['EMP_FLAG'] == 1){
                $data = null;
                $this->job_model->reset_hdf_notif_late_submission($data);
            }
            else if($details[0]['EMP_FLAG'] == 2){
                $data = $this->job_model->get_hdf_required_employee($details[0]['CUTOFFID']);
                for($x = 0; $x < count($data); $x++){
                    $this->job_model->reset_hdf_notif_late_submission($data[$x]['EMP_CODE']);
                }
            }
        }
    }

    // send notif if user has not yet submitted hdf run every 5 mins
    public function hdf_reminder_within_day(){
        $details = $this->job_model->get_hdf_cutoff_details(date('Y-m-d'));
        if(count($details) > 0){
            $details[0]['CUTOFF_TIME'] = date("g:i A", strtotime($details[0]['CUTOFF_TIME']));
            $employees = $this->job_model->get_employees_with_no_hdf();
            for($x = 0; $x < count($employees); $x++){
                if(isset($employees[$x]['EMAIL_ADDRESS']) || !empty($employees[$x]['EMAIL_ADDRESS'])){
                    $email_headers = array(
                        'recipient' => $employees[$x]['EMAIL_ADDRESS'],
                        'subject' => 'ETS - HEALTH DECLARATION FORM COMPLETION - REMINDER',
                        'msg' => 'Dear '.$employees[$x]['EMP_FNAME'].' '.$employees[$x]['EMP_LNAME'].':<br><br>Please be advised that you failed to complete the Health Declaration Form for '.$details[0]['SUBMISSION_DATE'].'. You can answer the HDF until '.$details[0]['CUTOFF_TIME'].'.<br><br>Submission after the cutoff time will require you to state your reason for late submission and will be subject for approval of your Immediate Head and Group/Division Head in Rush.Net.<br><br>We are hoping for your cooperation on this matter.<br><br>Please disregard this message if you already complied.<br><br>Thank you and stay safe!<br><br>Human Resources<br><br>Disclaimer: This communication is intended solely for the individual to whom it is addressed. If you are not the intended recipient of this communication, you may not disseminate, distribute, copy or otherwise disclose or use the contents of this communication without the written authority of Federal Land, Inc (FLI). If you have received this communication in error, please delete and destroy all copies and kindly notify the sender by return email or telephone immediately. Thank you!'
                    );
                    $this->send_hdf_email($email_headers);

                    $this->job_model->update_sent_hdf_notif($employees[$x]['EMP_CODE']);
                }

                if(isset($employees[$x]['MOBILE_NO']) || !empty($employees[$x]['MOBILE_NO'])){
                    $sms_headers = array(
                        'recipient' => $employees[$x]['MOBILE_NO'],
                        'msg' => 'Good day, '.$employees[$x]['EMP_FNAME'].' '.$employees[$x]['EMP_LNAME'].'! Please be advised that you failed to answer the Health Declaration Form today, '.$details[0]['SUBMISSION_DATE'].'. Kindly check your e-mail for further details. Please disregard this message if you already complied. Thank you and stay safe!'
                    );
                    $this->send_hdf_sms($sms_headers);

                    $this->job_model->update_sent_hdf_notif($employees[$x]['EMP_CODE']);
                }
            }
        }
    }

    // send hdf reminder to div head
    public function hdf_reminder_heads(){
        $details = $this->job_model->get_hdf_cutoff_details(date('Y-m-d'));
        if(count($details) > 0){
            $details[0]['CUTOFF_TIME'] = date("g:i A", strtotime($details[0]['CUTOFF_TIME']));
            $data = $this->job_model->get_div_heads();
            
            for($x = 0; $x < count($data); $x++){
                $no_hdfs = $this->job_model->get_employees_with_no_hdf_per_div($data[$x]['GRP_CODE']);
                if(count($no_hdfs) > 0){
                    $list_of_employees = '<ul>';
                    for($y = 0; $y < count($no_hdfs); $y++){
                        $list_of_employees .= '<li>'.$no_hdfs[$y]['EMP_FNAME'].' '.$no_hdfs[$y]['EMP_LNAME'].'</li>';
                    }
                    $list_of_employees .= '</ul>';

                    $message = 'Dear '.$data[$x]['EMP_FNAME'].' '.$data[$x]['EMP_LNAME'].':<br><br>Good day!<br><br> As part of our Health and Safety initiative, we encourage our employees to answer the Health Declaration Form for their health update. Unfortunately, there are employees who failed to comply with this requirement.<br>These are the following employees who haven\'t answered the HDF for '.$details[0]['SUBMISSION_DATE'].': <br><br>'.$list_of_employees.'<br><br>They can answer the HDF until '.$details[0]['CUTOFF_TIME'].'.<br><br>Submission after the cutoff time will require the employees to state their reason for late submission and will be subject for the approval of Immediate Head and Group/Division Head in Rush.Net.<br><br>If there are still employees who fail to submit the HDF, they will receive an email notice regarding the failure to comply with the FLI Health and Safety protocols.<br><br>We are hoping for your cooperation on this matter.<br><br>Thank you and stay safe!<br><br>Human Resources<br><br>Disclaimer: This communication is intended solely for the individual to whom it is addressed. If you are not the intended recipient of this communication, you may not disseminate, distribute, copy or otherwise disclose or use the contents of this communication without the written authority of Federal Land, Inc (FLI). If you have received this communication in error, please delete and destroy all copies and kindly notify the sender by return email or telephone immediately. Thank you!';

                    
                    // Always set content-type when sending HTML email
                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                    // More headers
                    $headers .= 'From: Employee Tracking System <no-reply-ets@federalland.ph>' . "\r\n";
                    // should enable in prod
                    $headers .= 'Cc: jdbagalay@federalland.ph' . "\r\n"; 

                    $to = $data[$x]['EMAIL_ADDRESS'];
                    $subject = 'ETS - HEALTH DECLARATION FORM COMPLETION - '.$data[$x]['GRP_CODE'].' REMINDER';
                    $msg = $message;
                    // $msg = wordwrap($msg, 70);
                    $result = mail($to,$subject,$msg,$headers);
                }
            }
        }
    }


    public function send_hdf_email($data){
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // More headers
        $headers .= 'From: Employee Tracking System <no-reply-ets@federalland.ph>' . "\r\n";
        $to = $data['recipient'];
        $subject = $data['subject'];
        $msg = $data['msg'];
        // $msg = wordwrap($msg, 70);
        $result = mail($to,$subject,$msg,$headers);
        return $result;
    }

    public function send_hdf_sms($data){
        $this->load->library('SMS');
        $result = $this->sms->send([
            'mobile' => $data['recipient'],
            'message' => $data['msg'],
        ]);
        return $result;
    }

    // run every 5 mins 24/7
    public function update_pending_hdf(){
        $this->load->library('rush');
        $rush_tickets = $this->job_model->get_pending_hdf();

        for($x = 0; $x < count($rush_tickets); $x++){
            $rushno = $rush_tickets[$x]['RUSHNO'];
            $status =  $this->rush->rushPOST('GetStatCd',[
                'REQST_NUM' => $rushno
            ]);
            if($status != 'I'){
                $new_status = array(
                    'RUSHNO' => $rushno,
                    'COLUMN' => 'STATUS',
                    'VALUE' => $status
                );
                $this->job_model->update_hdf($new_status);
                $status_date = array(
                    'RUSHNO' => $rushno,
                    'COLUMN' => 'STATUS_DATE',
                    'VALUE' => date("Y/m/d h:i:sa")
                );
                $this->job_model->update_hdf($status_date);
                $last_checked = array(
                    'RUSHNO' => $rushno,
                    'COLUMN' => 'LAST_CHECKED',
                    'VALUE' => date("Y/m/d h:i:sa")
                );
                $this->job_model->update_hdf($last_checked);
            }
            else{
                $last_checked = array(
                    'RUSHNO' => $rushno,
                    'COLUMN' => 'LAST_CHECKED',
                    'VALUE' => date("Y/m/d h:i:sa")
                );
                $this->job_model->update_hdf($last_checked);
            }

        }
    }
}
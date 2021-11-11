<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' ); 


class FrontController extends CI_Controller {
	
	public function __construct()
    {
        parent::__construct();
    }

    function isUserLogin() 
    {
        $user_id = $this->session->userdata('front_UserId');
        if(!isset($user_id) && $user_id == '') 
        {
            $this->session->set_flashdata('error', 'Please login to your account.');
            redirect("SignIn");
        }
        else
        {
            $valid_login = $this->crud->check_duplicate("tbl_customer",array("is_delete"=>0,"id"=>$user_id,"status"=>'Y',"is_verified"=>1));
            if($valid_login)
            { 

            }
            else
            {
                $this->session->set_flashdata('error', 'Please login to your account.');
                redirect('logout');
            }
        }
    }

    function generalSetting()
    {
        $sitesetting = $this->SiteSetting_model->getSiteSetting();
        return $sitesetting[0];
    }

    public function EmailSend($data = array())
    {
        include_once APPPATH.'third_party/class.phpmailer.php';
        
        $subject    = $data['Subject'];
        $to_email   = $data['ToEmail'];
        $from_mail  = $data['FromEmail'];
        $from_name  = $data['FromName'];
        $body       = $data['Message'];
        $mail       = new PHPMailer();
    
        $mail->SetFrom($from_mail,$from_name); // From email ID and from name
        if(is_array($to_email) && count($to_email) > 0){
            foreach ($to_email as $key => $email) {
                if($email != '')
                    $mail->AddAddress(stripslashes(trim($email)));
            }
        } else {
            $mail->AddAddress(stripslashes(trim($to_email)));
        }
        $mail->Subject = $subject;
        $mail->MsgHTML($body);
        
        //$mail->SMTPDebug = 3;
        $result = $mail->Send();
        return $result;
    }

    public function send_mail_global($from_email,$to_email,$subject,$message) 
    {
        $config = array();
        $config['smtp_port']= "465";
        $config['mailtype'] = 'html';
        $config['charset']  = "utf-8";
        $config['newline']  = "\r\n";
        $config['smtp_timeout']='30';
        $config['wordwrap'] = TRUE;
        // load Email Library 
        $this->load->library('email');

        $this->email->initialize($config);
        $this->email->from($from_email, SITE_NAME);
        $this->email->to($to_email);
        $this->email->subject($subject);
        $this->email->message($message);    

        //Send mail 
        if($this->email->send()) 
            return true;
        else
            return $this->email->print_debugger();
    }

    function paginationCompress($link, $count, $perPage = 10, $segment = SEGMENT) 
    {
		$this->load->library ( 'pagination' );

		$config ['base_url'] = base_url () . $link;
		$config ['total_rows'] = $count;
		$config ['uri_segment'] = $segment;
		$config ['per_page'] = $perPage;
		$config ['num_links'] = 5;
		$config ['full_tag_open'] = '<nav><ul class="pagination">';
		$config ['full_tag_close'] = '</ul></nav>';
		$config ['first_tag_open'] = '<li class="arrow">';
		$config ['first_link'] = 'First';
		$config ['first_tag_close'] = '</li>';
		$config ['prev_link'] = 'Previous';
		$config ['prev_tag_open'] = '<li class="arrow">';
		$config ['prev_tag_close'] = '</li>';
		$config ['next_link'] = 'Next';
		$config ['next_tag_open'] = '<li class="arrow">';
		$config ['next_tag_close'] = '</li>';
		$config ['cur_tag_open'] = '<li class="active"><a href="#">';
		$config ['cur_tag_close'] = '</a></li>';
		$config ['num_tag_open'] = '<li>';
		$config ['num_tag_close'] = '</li>';
		$config ['last_tag_open'] = '<li class="arrow">';
		$config ['last_link'] = 'Last';
		$config ['last_tag_close'] = '</li>';
	
		$this->pagination->initialize ( $config );
		$page = $config ['per_page'];
		$segment = $this->uri->segment ( $segment );
	
		return array (
				"page" => $page,
				"segment" => $segment
		);
	}
	
    public function week_day_array()
    {
        $WEEK_DAY_ARRAY = array("1"=>"MONDAY","2"=>"TUESDAY","3"=>"WEDNESDAY","4"=>"THURSDAY","5"=>"FRIDAY","6"=>"SATURDAY","7"=>"SUNDAY");

        return $WEEK_DAY_ARRAY;
    }
}
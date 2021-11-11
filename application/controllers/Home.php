<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/FrontController.php';
class Home extends FrontController {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('Crud', 'crud'); 
    }

    public function index()
    {   
        $data = array();
        $data['pageTitle'] = 'Home';
        // echo "asas"; exit();

    	$this->load->view(FRONTEND."home_page",$data);
    }

    public function view_privacy() 
    {
        $data['pageTitle'] = "Privacy & Policies";
        $this->load->view(FRONTEND."cms/cms_privacy",$data);
    }

    public function view_terms() 
    {
        $data['pageTitle'] = "Terms & Conditions";
        $this->load->view(FRONTEND."cms/cms_terms",$data);
    }

    function contact_us()
    {
        $post = $this->input->post();
        // print_r($post);exit;
        $this->form_validation->set_rules('name','Name *','trim|required');
        $this->form_validation->set_rules('email','Email *','trim|valid_email|required');
        // $this->form_validation->set_rules('phone','Phone *','trim|numeric|required');
        $this->form_validation->set_rules('subject','Subject *','trim|required');
        $this->form_validation->set_rules('message','Message *','trim|required');

        if($this->form_validation->run() == FALSE)
        {
            echo 'Something went wrong';
        }
        else
        {
            $fieldInfo = array(
                'name'                   =>  $post['name'],
                'email'                  =>  $post['email'],
                'phone'                  =>  $post['phone'],
                'subject'                =>  $post['subject'],
                'message'                =>  $post['message'],
                'status'                 =>  'Y',
                'created_at'             => date('Y-m-d H:i:s'),
            );

            $result = $this->crud->insert("contactform",$fieldInfo);
            // echo $this->db->last_query(); die();

            if($result > 0)
            {   
                $admin_login_link = base_url(ADMIN."login");

                /* General setting common from all email start */
                $general_setting            = $this->generalSetting(); 
                $mail_data['site_name']     = $general_setting->site_name;
                $mail_data['site_title']    = $general_setting->site_title;
                $mail_data['site_email']    = $general_setting->email;
                $mail_data['site_logo']     = base_url('public/front/images/logo/'.$general_setting->site_logo );
                $mail_data['address']       = $general_setting->address;
                $mail_data['fb_link']       = $general_setting->fb_link;
                $mail_data['twitter_link']  = $general_setting->twitter_link;
                $mail_data['instagram_link'] = $general_setting->instagram_link;
                /* General setting common from all email end */

                $mail_data['name']         = $post['name'];
                $mail_data['email']        = $post['email'];
                $mail_data['phone']        = $post['phone'];
                $mail_data['subject']      = $post['subject'];
                $mail_data['message']      = $post['message'];
                $mail_data['created_at']   = date("Y-m-d h:i:s");

                $message = $this->load->view('mail_template/contact_inquiry_mail_template', $mail_data, TRUE);
                
                $mailbody['ToEmail']    = CONTACT_INQ_TO_EMAIL;
                $mailbody['FromName']   = $general_setting->site_name;
                $mailbody['FromEmail']  = $general_setting->site_from_email;
                $mailbody['Subject']    = $general_setting->site_name." - New Inquiry Received";
                $mailbody['Message']    = $message;
    
                $mail_result = $this->EmailSend($mailbody);
                
                //Notifications to admin
                $user = $this->crud->get_data_row_by_id("tbl_users", "email", $post['email']);
                $userId = ($user->id) ? $user->id : 0;
                $notificationArray = ['type' => 'super_admin', 'user_id' => $userId, 'text' => 'New inquiry request received', 'read' => 0, 'created_at' => date("Y-m-d h:i:s"), 'updated_at' => date("Y-m-d h:i:s")];
                $notifications = $this->crud->insert('notifications', $notificationArray);

                $this->session->set_flashdata('success', 'Your request has been successfully received.');
                echo "1";
            }
            else
            {
                echo 'Something went wrong';
            } 
        }
    }
}

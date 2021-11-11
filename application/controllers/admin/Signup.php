<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Signup extends BaseController
{
    /**
     * This is default constructor of the class
    */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Crud', 'crud');
        $this->table = 'tbl_users';
        $sitesetting = $this->SiteSetting_model->getSiteSetting();

        $this->logo = $sitesetting[0]->site_logo;
        $this->favicon = $sitesetting[0]->site_favicon;
        $this->name = $sitesetting[0]->site_name;
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        $this->isLoggedIn();
    }
    
    /**
     * This function used to check the user is logged in or not
     */
    function isLoggedIn()
    {
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            $data["site_logo"] = $this->logo;
            $data["site_favicon"] = $this->favicon;
            $data["site_name"] = $this->name;
            $this->load->view(ADMIN.'signup', $data);
        }
        else
        {
            $data["site_logo"] = $this->logo;
            $data["site_favicon"] = $this->favicon;
            $data["site_name"] = $this->name;
            //$this->load->view(ADMIN.'login', $data);
            redirect(ADMIN.'dashboard');
        }
    }
    
    
    public function signup_process()
    {
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('fname', 'First Name', 'required|trim');
        $this->form_validation->set_rules('lname', 'Last Name', 'required|trim');
        $this->form_validation->set_rules('mobile', 'Mobile Number', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[128]|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|max_length[32]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->index();
        }
        else
        {
            $fname = $this->security->xss_clean($this->input->post('fname'));
            $lname = $this->security->xss_clean($this->input->post('lname'));
            $email = $this->security->xss_clean($this->input->post('email'));
            $mobile = $this->security->xss_clean($this->input->post('mobile'));
            $password = $this->input->post('password');
            
            $check_duplicate = $this->crud->check_duplicate($this->table,array('email'=>$email));
            $check_duplicate_phone = $this->crud->check_duplicate($this->table,array('mobile'=>$mobile));
            if($check_duplicate)
            {
                $this->session->set_flashdata('error', 'Your email id is already registered with us.');
                redirect(ADMIN.'signup');
            }
            else if($check_duplicate_phone)
            {
                $this->session->set_flashdata('error', 'Phone number is already exists.');
                redirect(ADMIN.'signup');
            }
            else
            {
                $fieldInfo = array(
                    'fname'                  =>  $fname,
                    'lname'                  =>  $lname,
                    'email'                  =>  $email,
                    'mobile'                 =>  $mobile,
                    'password'               =>  getHashedPassword($password),
                );

                $result = $this->crud->insert($this->table,$fieldInfo);

                if($result > 0)
                {
                    $admin_login_link = base_url(ADMIN."login");
                    $admin_role_link = base_url(ADMIN."manage-admin/edit/".$result);

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

                    $mail_data['fname']         = $fname;
                    $mail_data['email']         = $email;
                    $mail_data['password']      = $password;
                    $mail_data['url']           = $admin_login_link;
                    $mail_data['role_url']      = $admin_role_link;

                    $message = $this->load->view('mail_template/register_thankyou_mail_template', $mail_data, TRUE);
                    $mailbody['ToEmail']    = $email;
                    $mailbody['FromName']   = $general_setting->site_name;
                    $mailbody['FromEmail']  = $general_setting->site_from_email;
                    $mailbody['Subject']    = $general_setting->site_name." - Thank you for Joining";
                    $mailbody['Message']    = $message;
        
                    $mail_result = $this->EmailSend($mailbody);
                    
                    //Notifications to user
                    $user = $this->crud->get_data_row_by_id("tbl_users", "email", $email);
                    if (!empty($user)) {
                        $notificationArray = ['type' => 'user', 'user_id' => $user->id, 'text' => 'Thank you for Joining', 'read' => 0, 'created_at' => date("Y-m-d h:i:s"), 'updated_at' => date("Y-m-d h:i:s")];
                        $notifications = $this->crud->insert('notifications', $notificationArray);
                    }

                    $admin_message = $this->load->view('mail_template/register_new_admin_mail_template', $mail_data, TRUE);

                    $admin_mailbody['ToEmail']    = $general_setting->site_from_email;
                    $admin_mailbody['FromName']   = $general_setting->site_name;
                    $admin_mailbody['FromEmail']  = $general_setting->site_from_email;
                    $admin_mailbody['Subject']    = $general_setting->site_name." - Registered new user";
                    $admin_mailbody['Message']    = $admin_message;
                    $admin_mail_result = $this->EmailSend($admin_mailbody);
                    
                    //Notifications to admin
                    $user = $this->crud->get_data_row_by_id("tbl_users", "email", $email);
                    if (!empty($user)) {
                        $notificationArray = ['type' => 'super_admin', 'user_id' => $user->id, 'text' => 'New user registered', 'read' => 0, 'created_at' => date("Y-m-d h:i:s"), 'updated_at' => date("Y-m-d h:i:s")];
                        $notifications = $this->crud->insert('notifications', $notificationArray);
                    }

                    if($mail_result)
                    {
                        $this->session->set_flashdata('success', 'You have successfully registered to '.SITE_NAME);
                    }
                    else
                    {
                        $this->session->set_flashdata('error','Some error occured while send mail.');
                    }
                }
                else
                {
                    $this->session->set_flashdata('error', 'Something went wrong');
                }

                redirect(ADMIN.'login');
            }
        }
    }
}

?>
<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Login extends BaseController
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
            $this->load->view(ADMIN.'login', $data);
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
    
    
    /**
     * This function used to logged in user
     */
    public function loginMe()
    {
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[128]|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|max_length[32]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->index();
        }
        else
        {
            $email = $this->security->xss_clean($this->input->post('email'));
            $password = $this->input->post('password');
            
            $result    = $this->crud->get_row_by_id($this->table,array('email'=>$email,'isDeleted'=>0));

            if(verifyHashedPassword($password, $result['password']))
            {
                if($result['roleId']!=0)
                {
                    $sessionArray = array(
                                        'userId'        =>  $result['id'],                    
                                        'isLoggedIn'    =>  TRUE
                                    );

                    $this->session->set_userdata($sessionArray);

                    unset($sessionArray['userId'], $sessionArray['isLoggedIn']);

                    redirect(ADMIN.'dashboard');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Your account not assigned role yet.Will update you soon once role added.');
                    redirect(ADMIN.'login');
                }
            }
            else
            {
                $this->session->set_flashdata('error', 'Email or password mismatch');
                redirect(ADMIN.'login');
            }
        }
    }

    public function forgotpassword() 
    {
        if ($this->session->userdata('isLoggedIn')) 
        {
            $this->index();
        } 
        else 
        {
            $data["site_logo"] = $this->logo;
            $data["site_favicon"] = $this->favicon;
            $data["site_name"] = $this->name;

            $this->load->view(ADMIN."forgot_password",$data);
        }
    }

    public function forgot_password() 
    {
        
        $data = array();
        if(!empty($_POST))
        {
            $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');

            if ($this->form_validation->run()) 
            {
                $email = $_POST['email'];

                $check_duplicate = $this->crud->check_duplicate($this->table,array('email'=>$email,'isDeleted'=>0));
                if($check_duplicate)
                {
                    $token                      = $this->crud->generateRandomString(15);
                    $post_data['token']         = $token;
                    $result = $this->crud->update($this->table, $post_data, array('email'=>$email,'isDeleted'=>0));

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

                    $mail_data['url'] = base_url('admin/reset-password/'.$token);
                    $message = $this->load->view('mail_template/forgot_password_mail_template', $mail_data, TRUE);

                    $mailbody['ToEmail']    = $email;
                    $mailbody['FromName']   = $general_setting->site_name;
                    $mailbody['FromEmail']  = $general_setting->site_from_email;
                    $mailbody['Subject']    = $general_setting->site_name." - Reset Password";
                    $mailbody['Message']    = $message;

                    $mail_result = $this->EmailSend($mailbody);
                    
                    //Notifications to user
                    $user = $this->crud->get_data_row_by_id("tbl_users", "email", $email);
                    if (!empty($user)) {
                        $notificationArray = ['type' => 'user', 'user_id' => $user->id, 'text' => 'Your password reset successfully.', 'read' => 0, 'created_at' => date("Y-m-d h:i:s"), 'updated_at' => date("Y-m-d h:i:s")];
                        $notifications = $this->crud->insert('notifications', $notificationArray);
                    }
                    
                    if($mail_result)
                    {
                        $this->session->set_flashdata('success','Please check your email for reset password.');
                        redirect(APP_URL.'admin/forgot-password');

                    }
                    else
                    {
                        $this->session->set_flashdata('error','Some error occured while send forgot password mail. Please try again.');
                        redirect(APP_URL.'admin/forgot-password');
                    }
                }
                else
                {
                    $this->session->set_flashdata('error','You are not register with us.');
                    redirect(APP_URL.'admin/forgot-password');
                }
            } 
            else 
            {
                redirect(APP_URL.'admin/forgot-password');
            }

        }
        else
        {            
            $this->session->set_flashdata('error','Something went wrong. Please try again.');
            redirect(APP_URL.'admin/forgot-password');
        }
    }

    public function reset_password($str)
    {
        if ($this->session->userdata('isLoggedIn')) 
        {
            $this->index();
        } 
        else 
        {
            $result    = $this->crud->get_row_by_id($this->table,array('token'=>$str,'isDeleted'=>0));
            if($result)
            {
                $data['pageTitle']  = "Set New Password";
                $data['user_id']    = $result['id'];
                $data['token']      = $str;

                $data["site_logo"] = $this->logo;
                $data["site_favicon"] = $this->favicon;
                $data["site_name"] = $this->name;

                $this->load->view(ADMIN."set_new_password",$data);
            }
            else
            {
                $this->session->set_flashdata('error','Something went wrong. Please try again.');
                redirect(APP_URL.'admin/forgot-password');       
            }
        }
    }

    public function reset($token) 
    {
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');

        if ($this->form_validation->run()) 
        {
            $post_data  = $this->input->post();
           
            $user_id    = $post_data['user_id'];
            $password   = getHashedPassword($post_data['password']);

            $update = array('password'=>$password,'token' => NULL);            
            $reset = $this->crud->update($this->table, $update, array('id'=>$user_id,'isDeleted'=>0));

            if($reset==true) 
            {
                $this->session->set_flashdata('success','Password reset successfully.');
                redirect(APP_URL.'admin/login');
            }
            else 
            {
                $this->session->set_flashdata('error','Something went wrong. Please try again.');
                redirect(APP_URL.'admin/reset-password/'.$token);
            }
        }
        else 
        {
            redirect(APP_URL.'admin/reset-password/'.$token);
        }

    }
    // for extention
    public function extention_login()
    {
        // echo "<pre>";
        // print_r($_REQUEST); exit;
        $email = $this->security->xss_clean($this->input->post('email'));
        $password = $this->input->post('password');
        
        $result    = $this->crud->get_row_by_id($this->table,array('email'=>$email,'isDeleted'=>0));

        if(verifyHashedPassword($password, $result['password']))
        {
            if($result['roleId']!=0)
            {
                $sessionArray = array(
                                    'userId'        =>  $result['id'],                    
                                    'isLoggedIn'    =>  TRUE
                                );

                $this->db->query("DELETE FROM `extention_authtoken` WHERE `extention_authtoken`.`userId` = ".$result['id']."");
                
                $fieldInfo = array(
                    'userId'                  =>  $result['id'],
                    'token'                  =>  $this->generateRandomString(),
                );

                $result = $this->crud->insert("extention_authtoken",$fieldInfo);

                $fieldInfo['status'] = "200";

                print_r(json_encode($fieldInfo));
            }
            else
            {

                $fieldInfo = array(
                    'status'                  =>  401,
                    'massage'                 =>  'Your account not assigned role yet.Will update you soon once role added.'
                );
                print_r(json_encode($fieldInfo));
            }
        }
        else
        {
            $fieldInfo = array(
                'status'                  =>  401,
                'massage'                 =>  'Email or password mismatch'
            );
            print_r(json_encode($fieldInfo));
        }
    }

    function generateRandomString($length = 50) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

?>
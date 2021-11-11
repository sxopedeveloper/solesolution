<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseController.php';

class ExtentionController extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Crud', 'crud');
        $this->table = 'card_data';
        $sitesetting = $this->SiteSetting_model->getSiteSetting();
        $this->name = $sitesetting[0]->site_name;
    }

    public function index()
    {
    }

    public function signup_process()
    {
        $fname = $this->security->xss_clean($this->input->post('fname'));
        $lname = $this->security->xss_clean($this->input->post('lname'));
        $email = $this->security->xss_clean($this->input->post('email'));
        $mobile = $this->security->xss_clean($this->input->post('mobile'));
        $password = $this->input->post('password');
        
        $check_duplicate = $this->crud->check_duplicate("tbl_users",array('email'=>$email));
        $check_duplicate_phone = $this->crud->check_duplicate("tbl_users",array('mobile'=>$mobile));
        if($check_duplicate)
        {
            $return = array(
                'status'                  =>  401,
                'massage'                 =>  'Your email id is already registered with us.'
            );
            print_r(json_encode($return));
        }
        else if($check_duplicate_phone)
        {
            $return = array(
                'status'                  =>  401,
                'massage'                 =>  'Phone number is already exists.'
            );
            print_r(json_encode($return));
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

            $result = $this->crud->insert("tbl_users",$fieldInfo);

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
                    $notificationArray = ['type' => 'super_admin', 'user_id' => 0, 'text' => 'New user registered from extention', 'read' => 0, 'created_at' => date("Y-m-d h:i:s"), 'updated_at' => date("Y-m-d h:i:s")];
                    $notifications = $this->crud->insert('notifications', $notificationArray);
                }

                if($mail_result)
                {
                    $return = array(
                        'status'                  =>  200,
                        'massage'                 =>  'You have successfully registered to '.SITE_NAME
                    );
                    print_r(json_encode($return));
                }
                else
                {
                    $return = array(
                        'status'                  =>  200,
                        'massage'                 =>  'Some error occured while send mail.'
                    );
                    print_r(json_encode($return));
                }
            }
            else
            {
                $return = array(
                    'status'                  =>  200,
                    'massage'                 =>  'Something went wrong'
                );
                print_r(json_encode($return));
            }
        }
    }

     public function ex_add_fevourite()
    {
        $post = $this->input->post();
        // echo "<pre>";
        // print_r($post); exit;
        // $user_id = $this->check_ex_token($post['auth_token']);
        $user_id = $post['id'];
        if ($user_id > 0) {

            $fieldInfo = array(
                'added_by' => $user_id,
                'image' => $post['image'],
                'title' => $post['title'],
                'brand' => $post['brand'],
                'price' => $post['price'],
            );
            $insert_result = $this->crud->insert('extention_fevourit_product', $fieldInfo);
            $fieldInfo = array(
                'status' => 200,
                'massage' => 'Product added to fevourite list.',
            );
            print_r(json_encode($fieldInfo));
        } else {
            $fieldInfo = array(
                'status' => 401,
                'massage' => 'your auth token is expired please try again',
            );
            print_r(json_encode($fieldInfo));
        }
    }

    public function ex_delete_fevourite()
    {
        $post = $this->input->post();
        // echo "<pre>";
        // print_r($post); exit;
        // $user_id = $this->check_ex_token($post['auth_token']);
        $user_id = $post['id'];
        if ($user_id > 0) {
            $this->crud->execuetSQL("DELETE FROM `extention_fevourit_product` WHERE `extention_fevourit_product`.`id` = " . $post['id'] . "");
            $fieldInfo = array(
                'status' => 200,
                'massage' => 'Product Removed from fevourite list.',
            );
            print_r(json_encode($fieldInfo));
        } else {
            $fieldInfo = array(
                'status' => 401,
                'massage' => 'your auth token is expired please try again',
            );
            print_r(json_encode($fieldInfo));
        }
    }
    
    
    public function ex_deleteAll_fevourite()
    {
        $post = $this->input->post();
        // echo "<pre>";
        // print_r($post); exit;
        // $user_id = $this->check_ex_token($post['auth_token']);
        $user_id = $post['uid'];
        if ($user_id > 0) {
            $this->crud->execuetSQL("DELETE FROM `extention_fevourit_product` WHERE `extention_fevourit_product`.`added_by` = " . $post['uid'] . "");
            $fieldInfo = array(
                'status' => 200,
                'massage' => 'All Product Removed from fevourite list.',
            );
            print_r(json_encode($fieldInfo));
        } else {
            $fieldInfo = array(
                'status' => 401,
                'massage' => 'your auth token is expired please try again',
            );
            print_r(json_encode($fieldInfo));
        }
    }

    public function favList(){
        $post = $this->input->post();
        // $user_id = $this->check_ex_token($post['auth_token']);
        $user_id = $post['id'];
        if ($user_id > 0) {
            $data  = $this->crud->getFromSQL("SELECT * FROM `extention_fevourit_product` WHERE `extention_fevourit_product`.`added_by` = " . $post['id'] . "");
            $fieldInfo = array(
                'status' => 200,
                'massage' => 'Product from fevourite list.',
                'data' => $data
            );
            print_r(json_encode($fieldInfo));
        } else {
            $fieldInfo = array(
                'status' => 401,
                'massage' => 'your auth token is expired please try again',
            );
            print_r(json_encode($fieldInfo));
        }

    }

    public function loginCheck(){
        $post = $this->input->post();
        $data  = $this->crud->getFromSQL("SELECT * FROM extention_authtoken WHERE userId = ".$post['id']." AND token = '".$post['auth_token']."' ");
        if($data){
             $fieldInfo = array(
                'status' => 200,
                'massage' => 'Login Status Check.',
            );
            print_r(json_encode($fieldInfo));
        }else{
            $fieldInfo = array(
                'status' => 401,
                'massage' => 'your auth token is expired please try again',
            );
            print_r(json_encode($fieldInfo));
        }
    }
}

<?php if(!defined('BASEPATH')) exit('No direct script access allowed');


/**
 * This function is used to print the content of any data
 */
function pre($data)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

function SocialMedia() {
    
}

function FrontSiteInfo(){
    $CI =& get_instance();
    $CI->load->model('SiteSetting_model');
    $sitesetting = $CI->SiteSetting_model->getSiteSetting();
    $siteDetails = array();
    $headerInfo['navTab']      = "home";
    $headerInfo['site_logo']   = $sitesetting[0]->site_logo;
    $headerInfo['site_sticky_logo']   = $sitesetting[0]->site_sticky_logo;
    $headerInfo['site_favicon'] = $sitesetting[0]->site_favicon;
    $headerInfo['pageTitle']   = $sitesetting[0]->site_name;
    $headerInfo['about_description']   = $sitesetting[0]->about_description;
    $headerInfo['fb_link']   = $sitesetting[0]->fb_link;
    $headerInfo['instagram_link']   = $sitesetting[0]->instagram_link;
    $headerInfo['twitter_link']   = $sitesetting[0]->twitter_link;
    $headerInfo['pinterest_link']   = $sitesetting[0]->pinterest_link;
    $headerInfo['google_plus_link']   = $sitesetting[0]->google_plus_link;
    $headerInfo['site_address']   = $sitesetting[0]->address;
    $headerInfo['site_phone']   = $sitesetting[0]->phone;
    $headerInfo['site_email']   = $sitesetting[0]->email;


    /*$headerInfo['site_logo']            = $sitesetting[0]->site_logo;
    $headerInfo['site_favicon']         = $sitesetting[0]->site_favicon;
    $headerInfo['site_name']            = $sitesetting[0]->site_name;
    $headerInfo['site_title']           = $sitesetting[0]->site_title;
    $headerInfo['meta_tag']             = $sitesetting[0]->meta_tag;
    $headerInfo['meta_keyword']         = $sitesetting[0]->meta_keyword;
    $headerInfo['meta_description']     = $sitesetting[0]->meta_description;
    $headerInfo['fb_link']              = $sitesetting[0]->fb_link;
    $headerInfo['instagram_link']       = $sitesetting[0]->instagram_link;
    $headerInfo['address']              = $sitesetting[0]->address;
    $headerInfo['email']                = $sitesetting[0]->email;
    $headerInfo['phone']                = $sitesetting[0]->phone;*/
    
    return $headerInfo;
}

/**
 * This function used to get the CI instance
 */
if(!function_exists('get_instance'))
{
    function get_instance()
    {
        $CI = &get_instance();
    }
}

/**
 * This function used to generate the hashed password
 * @param {string} $plainPassword : This is plain text password
 */
if(!function_exists('getHashedPassword'))
{
    function getHashedPassword($plainPassword)
    {
        return password_hash($plainPassword, PASSWORD_DEFAULT);
    }
}

/**
 * This function used to generate the hashed password
 * @param {string} $plainPassword : This is plain text password
 * @param {string} $hashedPassword : This is hashed password
 */
if(!function_exists('verifyHashedPassword'))
{
    function verifyHashedPassword($plainPassword, $hashedPassword)
    {
        return password_verify($plainPassword, $hashedPassword) ? true : false;
    }
}

/**
 * This method used to get current browser agent
 */
if(!function_exists('getBrowserAgent'))
{
    function getBrowserAgent()
    {
        $CI = get_instance();
        $CI->load->library('user_agent');

        $agent = '';

        if ($CI->agent->is_browser())
        {
            $agent = $CI->agent->browser().' '.$CI->agent->version();
        }
        else if ($CI->agent->is_robot())
        {
            $agent = $CI->agent->robot();
        }
        else if ($CI->agent->is_mobile())
        {
            $agent = $CI->agent->mobile();
        }
        else
        {
            $agent = 'Unidentified User Agent';
        }

        return $agent;
    }
}

if(!function_exists('setProtocol'))
{
    function setProtocol()
    {
        $CI = &get_instance();
                    
        $CI->load->library('email');
        
        $config['protocol'] = PROTOCOL;
        $config['mailpath'] = MAIL_PATH;
        $config['smtp_host'] = SMTP_HOST;
        $config['smtp_port'] = SMTP_PORT;
        $config['smtp_user'] = SMTP_USER;
        $config['smtp_pass'] = SMTP_PASS;
        $config['charset'] = "utf-8";
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";
        
        $CI->email->initialize($config);
        
        return $CI;
    }
}

if(!function_exists('emailConfig'))
{
    function emailConfig()
    {
        $CI->load->library('email');
        $config['protocol'] = PROTOCOL;
        $config['smtp_host'] = SMTP_HOST;
        $config['smtp_port'] = SMTP_PORT;
        $config['mailpath'] = MAIL_PATH;
        $config['charset'] = 'UTF-8';
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";
        $config['wordwrap'] = TRUE;
    }
}

if(!function_exists('resetPasswordEmail'))
{
    function resetPasswordEmail($detail)
    {
        $data["data"] = $detail;
        // pre($detail);
        // die;
        
        $CI = setProtocol();        
        
        $CI->email->from(EMAIL_FROM, FROM_NAME);
        $CI->email->subject("Reset Password");
        $CI->email->message($CI->load->view('email/resetPassword', $data, TRUE));
        $CI->email->to($detail["email"]);
        $status = $CI->email->send();
        
        return $status;
    }
}

if(!function_exists('setFlashData'))
{
    function setFlashData($status, $flashMsg)
    {
        $CI = get_instance();
        $CI->session->set_flashdata($status, $flashMsg);
    }
}

function create_thumb_gallery($upload_data, $source_img, $new_img, $width, $height)
{
    $CI =& get_instance();
    //Copy Image Configuration
    $config['image_library'] = 'gd2';
    $config['source_image'] = $source_img;
    $config['create_thumb'] = FALSE;
    $config['new_image'] = $new_img;
    $config['quality'] = '100%';

    $CI->load->library('image_lib');
    $CI->image_lib->initialize($config);

    if ( ! $CI->image_lib->resize() )
    {
    echo $CI->image_lib->display_errors();
    }
    else
    {
        //Images Copied
        //Image Resizing Starts
        $config['image_library'] = 'gd2';
        $config['source_image'] = $source_img;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['quality'] = '100%';
        $config['new_image'] = $new_img;
        $config['overwrite'] = TRUE;
        $config['width'] = $width;
        $config['height'] = $height;
        if(!empty($upload_data['image_height'])){
            $dim = (intval($upload_data['image_width']) / intval($upload_data['image_height'])) - ($config['width'] / $config['height']);
            $config['master_dim'] = ($dim > 0)? 'height' : 'width';
        }
        $CI->image_lib->clear();
        $CI->image_lib->initialize($config);

        if ( ! $CI->image_lib->resize())
        {
            echo $CI->image_lib->display_errors();
        }
        else
        {
        //echo 'Thumnail Created';
        return true;
        }
    }

}

if(!function_exists('get_time_ago'))
{
    function get_time_ago( $time )
    {
        $time_difference = time() - $time;

        if( $time_difference < 1 ) { return 'less than 1 second ago'; }
        $condition = array( 12 * 30 * 24 * 60 * 60 =>  'year',
                    30 * 24 * 60 * 60       =>  'month',
                    24 * 60 * 60            =>  'day',
                    60 * 60                 =>  'hour',
                    60                      =>  'minute',
                    1                       =>  'second'
        );

        foreach( $condition as $secs => $str )
        {
            $d = $time_difference / $secs;

            if( $d >= 1 )
            {
                $t = round( $d );
                return $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago';
            }
        }
    }
}

if(!function_exists('changeDateFormatUtcToPst'))
{
    function changeDateFormatUtcToPst($date='', $timezone = 'America/Los_Angeles')
    {
        $timestamp = strtotime($date);
        $date = new DateTime();
        $date->setTimestamp($timestamp);
        $date->setTimezone(new \DateTimeZone($timezone));
        return $date;
    }
}

if(!function_exists('changeDateFormatPstToUtc'))
{
    function changeDateFormatPstToUtc($date='', $timezone = 'UTC')
    {
        $timestamp = strtotime($date);
        $date = new DateTime($date);
        $date->setTimestamp($timestamp);
        $date->setTimezone(new DateTimeZone($timezone));
        return $date->format('Y-m-d H:i:s');
    }
}

?>
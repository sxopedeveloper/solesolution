<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';
require_once('application/libraries/simplehtmldom/simple_html_dom_new.blade.php');

class RangeOrderNotify extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Crud', 'crud'); 
        $this->table = 'email_notify';
        $sitesetting = $this->SiteSetting_model->getSiteSetting();
    }

    function index()
    {
        $html = '';   
        $datas = $this->crud->get_all_with_where($this->table,'id','asc',array("isDelete"=>0));
        if( count($datas) )
        {
            foreach ($datas as $data) {
                $store = $data->seller_id == "" ? "--" : $this->crud->getFromSQL('SELECT `name` FROM `store` WHERE `AmazonSellerId` = "'.$data->seller_id.'"');
                if($store != "--" && !empty($store)){
                    $store = $store[0]->name;
                }else{
                    $store = "--"; 
                }
                $html = $this->getASINRecord($data->notify_asin, $data->min_amount, $data->max_amount);
                if($html != ""){
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

                    $mail_data['email']         = $data->notify_email;
                    $mail_data['product_list']  = $html;
                    $mail_data['asin']  = $data->notify_asin;
                    $mail_data['min_amount']  = $data->min_amount;
                    $mail_data['max_amount']  = $data->max_amount;
                    $mail_data['store_name'] = $store;
                    $message = $this->load->view('mail_template/notify_mail', $mail_data, TRUE);
                    // print $message;
                    // die();
                    $mailbody['ToEmail']    = json_decode($data->notify_email);
                    $mailbody['FromName']   = $general_setting->site_name;
                    $mailbody['FromEmail']  = $general_setting->site_from_email;
                    $mailbody['Subject']    = $general_setting->site_name." - Range order notification";
                    $mailbody['Message']    = $message;
        
                    // print $general_setting->site_name . '<br />' . $general_setting->site_from_email . '<br />' . $data->notify_email;
                    // die();
                    $mail_result = $this->EmailSend($mailbody);

                    // set isDelete = 1, so duplicate email won't be sent
                    $rows = array(
                        'isDelete' => 1,
                    );
                    $where = array('id'=>$data->id);
                    //$update_result = $this->crud->update($this->table, $rows, $where);
                }
            }
        }
    }

    function getASINRecord($asin, $min_amount, $max_amount)
    {
        /*$asin = "B001E0DVIS";
        $min_amount = 5;
        $max_amount = 30;*/
        error_reporting(0);
        //$post = $this->input->post();
        error_reporting(E_ALl);
        $str_html = '';

        if(isset($asin) && $asin!="")
        {
            $generate_url = 'https://www.amazon.com/gp/aod/ajax/ref=dp_aod_NEW_mbc?asin='.$asin.'&m=&pinnedofferhash=&qid=&smid=&sourcecustomerorglistid=&sourcecustomerorglistitemid=&sr=&pc=dp';

            $generate_url = myCleanData($generate_url);
            $html = file_get_html($generate_url);
            if($html!="")
            {
                // $str_html .= "<h3>" . $html->find('div#all-offers-display-scroller h5#aod-asin-title-text')[0]->plaintext." (Total other seller :- ".$html->find('#aod-total-offer-count')[0]->value." )" . "</h3>";

                $str_html .= "<h3>" . $html->find('div#all-offers-display-scroller h5#aod-asin-title-text')[0]->plaintext."</h3>";

                $per_page = 10;
                $total_page = ceil($html->find('#aod-total-offer-count')[0]->value/$per_page);
                //$str_html .= "Total page :- ".$total_page."<br>===================";

                $str_html .= "<table class='table table-responsive' cellpadding='3' cellspacing='0' style='width: 100%;border-bottom: 1px solid #ccc;border-left: 1px solid #ccc;'>
                                <thead>
                                    <tr style='background-color: #eaeaea;'>
                                        <th width='20%' align='left' style='border-top: 1px solid #ccc;border-right: 1px solid #ccc;'>Price</th>
                                        <th width='30%' align='left' style='border-top: 1px solid #ccc;border-right: 1px solid #ccc;'>Sold By</th>
                                        <th width='20%' align='left' style='border-top: 1px solid #ccc;border-right: 1px solid #ccc;'>Delivery Fees</th>
                                        <th width='30%' align='left' style='border-top: 1px solid #ccc;border-right: 1px solid #ccc;'>Rating</th>
                                    </tr>
                                </thead>
                                <tbody>";
                        $flag = 0;
                        $price = str_replace("$","",$html->find('span.a-offscreen')[0]->plaintext);
                        if( $price >= $min_amount && $price <= $max_amount )
                        {
                            $str_html .= "<tr>
                                            <td style='border-top: 1px solid #ccc;border-right: 1px solid #ccc;'>" . $html->find('span.a-offscreen')[0]->plaintext . "</td>
                                            <td style='border-top: 1px solid #ccc;border-right: 1px solid #ccc;'>" . $html->find('div.a-fixed-left-grid-col.a-col-right .a-size-small.a-link-normal')[0]->plaintext . "</td>
                                            <td style='border-top: 1px solid #ccc;border-right: 1px solid #ccc;'>" . $html->find('div#delivery-message')[0]->plaintext . "</td>
                                            <td style='border-top: 1px solid #ccc;border-right: 1px solid #ccc;'>" . $html->find('div#aod-asin-reviews span#aod-asin-reviews-count-title')[0]->plaintext . "</td>
                                        </tr>";
                            $flag = 1;
                        }
                        for ($i=1; $i <= $total_page; $i++) 
                        { 
                            $url = $generate_url.'&pageno='.$i;

                            //$str_html .= $url .'=====';

                            $html = file_get_html($url); 
                            //print '<pre>'; print_r($html);
                            foreach($html->find('div#aod-offer') as $e1)
                            { 
                                $price = $e1->find('span.a-offscreen')[0]->plaintext;

                                //echo $price; exit;
                                $sold_by = $e1->find('a.a-size-small.a-link-normal')[0]->plaintext;
                                //$delivery_fees = $e1->find('span.a-color-secondary.a-size-base')[0]->plaintext;
                                $delivery_fees = $e1->find('div#delivery-message')[0]->plaintext;
                                $rating = $e1->find('div#aod-offer-seller-rating span#seller-rating-count-{iter}')[0]->plaintext;

                                $price1 = str_replace("$","",$e1->find('span.a-offscreen')[0]->plaintext);
                                
                                if( $price1 >= $min_amount && $price1 <= $max_amount )
                                {
                                    
                                $str_html .= "<tr>
                                                <td style='border-top: 1px solid #ccc;border-right: 1px solid #ccc;'>" . $price . "</td>
                                                <td style='border-top: 1px solid #ccc;border-right: 1px solid #ccc;'>" . $sold_by . "</td>
                                                <td style='border-top: 1px solid #ccc;border-right: 1px solid #ccc;'>" . $delivery_fees . "</td>
                                                <td style='border-top: 1px solid #ccc;border-right: 1px solid #ccc;'>" . $rating . "</td>
                                            </tr>";
                                            $flag = 1;
                                }
                            }
                        }
                $str_html .= "</tbody>
                        </table>";
            }
            if(isset($flag) && $flag == 1){
                $str_html = $str_html;
            }else{
                $str_html = "";
            }
  
            return $str_html;
        }
    }
}
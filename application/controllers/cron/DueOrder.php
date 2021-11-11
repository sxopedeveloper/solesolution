<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';
require_once('application/libraries/simplehtmldom/simple_html_dom_new.blade.php');
require_once 'application/libraries/spapi/vendor/autoload.php';

class DueOrder extends BaseController
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

        $this->logo = $sitesetting[0]->site_logo;
        $this->favicon = $sitesetting[0]->site_favicon;
        $this->name = $sitesetting[0]->site_name;
    }
    
    public function index()
    {
        $sql = "SELECT ao.AmazonOrderId,ao.ASIN_NO,ao.AmazonSellerId,s.name FROM amazon_orders as ao JOIN store as s ON ao.AmazonSellerId=s.AmazonSellerId WHERE ao.isDelete = 0 AND DATE_FORMAT(ao.EarliestShipDate, '%Y/%m/%d') = '".date("Y/m/d")."' ORDER by ao.order_id DESC";
        
        //$sql = "SELECT ao.AmazonOrderId,ao.ASIN_NO,ao.AmazonSellerId,s.name FROM amazon_orders as ao JOIN store as s ON ao.AmazonSellerId=s.AmazonSellerId WHERE ao.isDelete = 0 AND DATE_FORMAT(ao.EarliestShipDate, '%Y/%m/%d') = '2021/06/18' ORDER by ao.order_id DESC";
         $order_datas = $this->crud->getFromSQL($sql);

        $stores = array();
         foreach($order_datas as $order_data){
            $stores[$order_data->AmazonSellerId][store_name] = $order_data->name;
            $stores[$order_data->AmazonSellerId][order][] = array(
                    "order_id" => $order_data->AmazonOrderId,
                    "Asin_no" => $order_data->ASIN_NO
                );
         }
         
        foreach($stores as $key => $store){
            
                $store_name = $store['store_name'];
                $orders = $store['order'];

                $to_email = $this->getEmailFromSeller($key);
                $html = $this->getHtml($orders);
                
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
    
                $mail_data['email']         = $to_email;
                $mail_data['html']  = $html;
                $mail_data['store_name'] = $store_name;
                $message = $this->load->view('mail_template/due_date_mail', $mail_data, TRUE);
                // print $message;
                // die();
                $mailbody['ToEmail']    = json_decode($data->notify_email);
                $mailbody['FromName']   = $general_setting->site_name;
                $mailbody['FromEmail']  = $general_setting->site_from_email;
                $mailbody['Subject']    = "Due date orders of store ".$store_name."";
                $mailbody['Message']    = $message;
    
                // print $general_setting->site_name . '<br />' . $general_setting->site_from_email . '<br />' . $data->notify_email;
                // die();
                $mail_result = $this->EmailSend($mailbody);
        }
    }
    
    public function getEmailFromSeller($id)
    {
        $sql = "SELECT tu.email FROM tbl_users as tu JOIN store as s ON FIND_IN_SET(s.id, tu.store_id) WHERE (tu.roleId = 2 or tu.roleId = 3 or tu.roleId = 4) AND s.AmazonSellerId = '".$id."' AND tu.isDeleted = 0";
        $emails = $this->crud->getFromSQL($sql);
        $temp = array();
        foreach($emails as $email){
            $temp[] = $email->email;
        }
        
        
        return $temp;
    }
    
    public function getHtml($orders)
    {
        
        $str_html = "<table class='table table-responsive' cellpadding='3' cellspacing='0' style='width: 100%;border-bottom: 1px solid #ccc;border-left: 1px solid #ccc;'>
                        <thead>
                            <tr style='background-color: #eaeaea;'>
                                <th width='50%' align='left' style='border-top: 1px solid #ccc;border-right: 1px solid #ccc;'>Order Id</th>
                                <th width='50%' align='left' style='border-top: 1px solid #ccc;border-right: 1px solid #ccc;'>Asin No.</th>
                            </tr>
                        </thead>
                        <tbody>";
                        
                        foreach($orders as $order){
                        $str_html .= "<tr>
                                        <td style='border-top: 1px solid #ccc;border-right: 1px solid #ccc;'>" . $order['order_id'] . "</td>
                                        <td style='border-top: 1px solid #ccc;border-right: 1px solid #ccc;'>" . $order['Asin_no'] . "</td
                                    </tr>";
                        }

                            
        $str_html .= "</tbody>
                </table>";
                
        return $str_html;
    }

    public function getRecord()
    {   
        $data["site_logo"] = $this->logo;
        $data["site_favicon"] = $this->favicon;
        $data["site_name"] = $this->name;
        $this->load->view(ADMIN.'getreord1', $data);
    }

    public function getRecordSubmit()
    {   
        $post = $this->input->post();
        // echo "<pre>";
        // print_r($post); exit;
        error_reporting(E_ALL);


        $curron_count = 1;

        $sellerid = $post['SellerId'];
        $refresh_token = $post['refresh_token'];
        $client_id = $post['client_id'];
        $client_secret = $post['client_secret'];
        $start_date = $post['start_date'];
        $end_date = $post['end_date'];

        $check_array = array(
            "store_id" => $sellerid,
        );

        $store_cron = $this->crud->get_all_with_where('order_cron_data1', 'store_id', 'asc', $check_array);
        $inserted = 0;
        if (!empty($store_cron)) {
            $inserted = $store_cron['0']->inserted_record;
        }
        $store_duplicate = $this->crud->check_duplicate('order_cron_data1', $check_array);
        if (!$store_duplicate) {
            $insert_result = $this->crud->insert("order_cron_data1", $check_array);
        }

        $config = [
            //Guzzle configuration
            'http' => [
                'verify' => false, //<--- NOT SAFE FOR PRODUCTION
                //'debug' => true       //<--- NOT SAFE FOR PRODUCTION
            ],

            //LWA: Keys needed to obtain access token from Login With Amazon Service
            'refresh_token' => $refresh_token,
            'client_id' => $client_id,
            'client_secret' => $client_secret,

            //STS: Keys of the IAM role which are needed to generate Secure Session
            // (a.k.a Secure token) for accessing and assuming the IAM role
            'access_key' => 'AKIATJORSRJFWPH7Z4A3',
            'secret_key' => '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',
            'role_arn' => 'arn:aws:iam::226462173771:role/SoleSolution_Role',

            //API: Actual configuration related to the SP API :)
            'region' => 'us-east-1',
            'host' => 'sellingpartnerapi-na.amazon.com',
        ];

        file_put_contents("aws-tokens", "");
        //Create token storage which will store the temporary tokens
        $tokenStorage = new DoubleBreak\Spapi\SimpleTokenStorage('aws-tokens');

        //Create the request signer which will be automatically used to sign all of the
        //requests to the API
        $signer = new DoubleBreak\Spapi\Signer();

        //Create Credentials service and call getCredentials() to obtain
        //all the tokens needed under the hood

        $credentials = new DoubleBreak\Spapi\Credentials($tokenStorage, $signer, $config);
        $cred = $credentials->getCredentials();

        $reportClient = new DoubleBreak\Spapi\Api\Orders($cred, $config);
        // echo "<pre>";
        // print_r($reportClient); exit;
        $result = $reportClient->getOrders([
            'MarketplaceIds' => 'A1AM78C64UM0Y8,A2EUQ1WTGCTBG2,ATVPDKIKX0DER',
            'CreatedAfter' => date('Y-m-d', strtotime($start_date)),
            'CreatedBefore' => date('Y-m-d', strtotime($end_date)),
        ]);

        

        $order_count = count($result['payload']['Orders']);
        if($order_count >= 100){
            echo "Please <a href='../cron/getrecord'>Click Here</a> to change date range it's exist 100 records. "; exit;
        }

        $com_flag = 1;
        foreach ($result['payload']['Orders'] as $order) {

            $AmazonOrderId = $order['AmazonOrderId'];

            $check_duplicate = $this->crud->check_duplicate("amazon_orders", array('AmazonOrderId' => $AmazonOrderId, 'isDelete' => 0));
            if (!$check_duplicate && $curron_count <= 10) {
                $curron_count++;

                $order_d = $reportClient->getOrder($AmazonOrderId);
                $buyer_d = $reportClient->getOrderBuyerInfo($AmazonOrderId);
                $address_d = $reportClient->getOrderAddress($AmazonOrderId);
                $order_item = $reportClient->getOrderItems($AmazonOrderId);

                unset($order_item['payload']['AmazonOrderId']);
                $AmazonSellerId = isset($sellerid) ? $sellerid : "";
                $AmazonOrderId = isset($AmazonOrderId) ? $AmazonOrderId : "";
                $BuyerEmail = isset($buyer_d['payload']['BuyerEmail']) ? $buyer_d['payload']['BuyerEmail'] : "";
                $DefaultShipFromLocationAddress__AddressLine1 = isset($order_d['payload']['DefaultShipFromLocationAddress']['AddressLine1']) ? $order_d['payload']['DefaultShipFromLocationAddress']['AddressLine1'] : "";
                $DefaultShipFromLocationAddress__AddressLine3 = isset($order_d['payload']['DefaultShipFromLocationAddress']['AddressLine2']) ? $order_d['payload']['DefaultShipFromLocationAddress']['AddressLine2'] : "";
                $DefaultShipFromLocationAddress__City = isset($order_d['payload']['DefaultShipFromLocationAddress']['City']) ? $order_d['payload']['DefaultShipFromLocationAddress']['City'] : "";
                $DefaultShipFromLocationAddress__CountryCode = isset($order_d['payload']['DefaultShipFromLocationAddress']['CountryCode']) ? $order_d['payload']['DefaultShipFromLocationAddress']['CountryCode'] : "";
                $DefaultShipFromLocationAddress__Name = isset($order_d['payload']['DefaultShipFromLocationAddress']['Name']) ? $order_d['payload']['DefaultShipFromLocationAddress']['Name'] : "";
                $DefaultShipFromLocationAddress__Phone = isset($order_d['payload']['DefaultShipFromLocationAddress']['Phone']) ? $order_d['payload']['DefaultShipFromLocationAddress']['Phone'] : "";
                $DefaultShipFromLocationAddress__PostalCode = isset($order_d['payload']['DefaultShipFromLocationAddress']['PostalCode']) ? $order_d['payload']['DefaultShipFromLocationAddress']['PostalCode'] : "";
                $DefaultShipFromLocationAddress__StateOrRegion = isset($order_d['payload']['DefaultShipFromLocationAddress']['StateOrRegion']) ? $order_d['payload']['DefaultShipFromLocationAddress']['StateOrRegion'] : "";
                $DefaultShipFromLocationAddress__isAddressSharingConfidential = isset($order_d['payload']['DefaultShipFromLocationAddress']['isAddressSharingConfidential']) ? $order_d['payload']['DefaultShipFromLocationAddress']['isAddressSharingConfidential'] : "";
                $EarliestDeliveryDate = isset($order_d['payload']['EarliestDeliveryDate']) ? $order_d['payload']['EarliestDeliveryDate'] : "";
                $EarliestShipDate = isset($order_d['payload']['EarliestShipDate']) ? $order_d['payload']['EarliestShipDate'] : "";
                $FulfillmentChannel = isset($order_d['payload']['FulfillmentChannel']) ? $order_d['payload']['FulfillmentChannel'] : "";
                $IsBusinessOrder = isset($order_d['payload']['IsBusinessOrder']) ? $order_d['payload']['IsBusinessOrder'] : "";
                $IsGlobalExpressEnabled = isset($order_d['payload']['IsGlobalExpressEnabled']) ? $order_d['payload']['IsGlobalExpressEnabled'] : "";
                $IsISPU = isset($order_d['payload']['IsISPU']) ? $order_d['payload']['IsISPU'] : "";
                $IsPremiumOrder = isset($order_d['payload']['IsPremiumOrder']) ? $order_d['payload']['IsPremiumOrder'] : "";
                $IsPrime = isset($order_d['payload']['IsPrime']) ? $order_d['payload']['IsPrime'] : "";
                $IsReplacementOrder = isset($order_d['payload']['IsReplacementOrder']) ? $order_d['payload']['IsReplacementOrder'] : "";
                $IsSoldByAB = isset($order_d['payload']['IsSoldByAB']) ? $order_d['payload']['IsSoldByAB'] : "";
                $LastUpdateDate = isset($order_d['payload']['LastUpdateDate']) ? $order_d['payload']['LastUpdateDate'] : "";
                $LatestDeliveryDate = isset($order_d['payload']['LatestDeliveryDate']) ? $order_d['payload']['LatestDeliveryDate'] : "";
                $LatestShipDate = isset($order_d['payload']['LatestShipDate']) ? $order_d['payload']['LatestShipDate'] : "";
                $MarketplaceId = isset($order_d['payload']['MarketplaceId']) ? $order_d['payload']['MarketplaceId'] : "";
                $NumberOfItemsShipped = isset($order_d['payload']['NumberOfItemsShipped']) ? $order_d['payload']['NumberOfItemsShipped'] : "";
                $NumberOfItemsUnshipped = isset($order_d['payload']['NumberOfItemsUnshipped']) ? $order_d['payload']['NumberOfItemsUnshipped'] : "";
                $OrderItems = isset($order_item['payload']) ? json_encode($order_item['payload']) : "";
                $OrderStatus = isset($order_d['payload']['OrderStatus']) ? $order_d['payload']['OrderStatus'] : "";
                $OrderTotal__Amount = isset($order_d['payload']['OrderTotal']['Amount']) ? $order_d['payload']['OrderTotal']['Amount'] : "";
                $OrderTotal__CurrencyCode = isset($order_d['payload']['OrderTotal']['CurrencyCode']) ? $order_d['payload']['OrderTotal']['CurrencyCode'] : "";
                $OrderType = isset($order_d['payload']['OrderType']) ? $order_d['payload']['OrderType'] : "";
                $PaymentMethod = isset($order_d['payload']['PaymentMethod']) ? $order_d['payload']['PaymentMethod'] : "";
                $PaymentMethodDetails__PaymentMethodDetail = isset($order_d['payload']['PaymentMethodDetails'][0]) ? $order_d['payload']['PaymentMethodDetails'][0] : "";
                $PurchaseDate = isset($order_d['payload']['PurchaseDate']) ? $order_d['payload']['PurchaseDate'] : "";
                $SalesChannel = isset($order_d['payload']['SalesChannel']) ? $order_d['payload']['SalesChannel'] : "";
                $ShipServiceLevel = isset($order_d['payload']['ShipServiceLevel']) ? $order_d['payload']['ShipServiceLevel'] : "";
                $ShipmentServiceLevelCategory = isset($order_d['payload']['ShipmentServiceLevelCategory']) ? $order_d['payload']['ShipmentServiceLevelCategory'] : "";
                $ShippingAddress__City = isset($address_d['payload']['ShippingAddress']['City']) ? $address_d['payload']['ShippingAddress']['City'] : "";
                $ShippingAddress__CountryCode = isset($address_d['payload']['ShippingAddress']['CountryCode']) ? $address_d['payload']['ShippingAddress']['CountryCode'] : "";
                $ShippingAddress__PostalCode = isset($address_d['payload']['ShippingAddress']['PostalCode']) ? $address_d['payload']['ShippingAddress']['PostalCode'] : "";
                $ShippingAddress__StateOrRegion = isset($address_d['payload']['ShippingAddress']['StateOrRegion']) ? $address_d['payload']['ShippingAddress']['StateOrRegion'] : "";
                $ShippingAddress__isAddressSharingConfidential = isset($address_d['payload']['ShippingAddress']['isAddressSharingConfidential']) ? $address_d['payload']['ShippingAddress']['isAddressSharingConfidential'] : "";

                $order_data = array(
                    "AmazonSellerId" => $AmazonSellerId,
                    "AmazonOrderId" => $AmazonOrderId,
                    "BuyerEmail" => $BuyerEmail,
                    "DefaultShipFromLocationAddress__AddressLine1" => $DefaultShipFromLocationAddress__AddressLine1,
                    "DefaultShipFromLocationAddress__AddressLine3" => $DefaultShipFromLocationAddress__AddressLine3,
                    "DefaultShipFromLocationAddress__City" => $DefaultShipFromLocationAddress__City,
                    "DefaultShipFromLocationAddress__CountryCode" => $DefaultShipFromLocationAddress__CountryCode,
                    "DefaultShipFromLocationAddress__Name" => $DefaultShipFromLocationAddress__Name,
                    "DefaultShipFromLocationAddress__Phone" => $DefaultShipFromLocationAddress__Phone,
                    "DefaultShipFromLocationAddress__PostalCode" => $DefaultShipFromLocationAddress__PostalCode,
                    "DefaultShipFromLocationAddress__StateOrRegion" => $DefaultShipFromLocationAddress__StateOrRegion,
                    "DefaultShipFromLocationAddress__isAddressSharingConfidential" => $DefaultShipFromLocationAddress__isAddressSharingConfidential,
                    "EarliestDeliveryDate" => $EarliestDeliveryDate,
                    "EarliestShipDate" => $EarliestShipDate,
                    "FulfillmentChannel" => $FulfillmentChannel,
                    "IsBusinessOrder" => $IsBusinessOrder,
                    "IsGlobalExpressEnabled" => $IsGlobalExpressEnabled,
                    "IsISPU" => $IsISPU,
                    "IsPremiumOrder" => $IsPremiumOrder,
                    "IsPrime" => $IsPrime,
                    "IsReplacementOrder" => $IsReplacementOrder,
                    "IsSoldByAB" => $IsSoldByAB,
                    "LastUpdateDate" => $LastUpdateDate,
                    "LatestDeliveryDate" => $LatestDeliveryDate,
                    "LatestShipDate" => $LatestShipDate,
                    "MarketplaceId" => $MarketplaceId,
                    "NumberOfItemsShipped" => $NumberOfItemsShipped,
                    "NumberOfItemsUnshipped" => $NumberOfItemsUnshipped,
                    "OrderItems" => $OrderItems,
                    "OrderStatus" => $OrderStatus,
                    "OrderTotal__Amount" => $OrderTotal__Amount,
                    "OrderTotal__CurrencyCode" => $OrderTotal__CurrencyCode,
                    "OrderType" => $OrderType,
                    "PaymentMethod" => $PaymentMethod,
                    "PaymentMethodDetails__PaymentMethodDetail" => $PaymentMethodDetails__PaymentMethodDetail,
                    "PurchaseDate" => $PurchaseDate,
                    "SalesChannel" => $SalesChannel,
                    "ShipServiceLevel" => $ShipServiceLevel,
                    "ShipmentServiceLevelCategory" => $ShipmentServiceLevelCategory,
                    "ShippingAddress__City" => $ShippingAddress__City,
                    "ShippingAddress__CountryCode" => $ShippingAddress__CountryCode,
                    "ShippingAddress__PostalCode" => $ShippingAddress__PostalCode,
                    "ShippingAddress__StateOrRegion" => $ShippingAddress__StateOrRegion,
                    "ShippingAddress__isAddressSharingConfidential" => $ShippingAddress__isAddressSharingConfidential,
                    "id" => $AmazonOrderId,
                    "add_from" => 1,
                );
                echo $AmazonOrderId."<br>";
                $insert_result = $this->crud->insert("amazon_orders", $order_data);
                $com_flag = 0;
                //update crone inserted record count
                $inserted++;
                $post = array(
                    "inserted_record" => $inserted,
                    "is_Complite" => $inserted == $order_count ? "1" : "0",
                );
                $update_result = $this->crud->update("order_cron_data1", $post, $check_array);
            }
        }
        if ($com_flag == 1) {
            $post = array(
                "is_Complite" => "1",
            );
            $update_result = $this->crud->update("order_cron_data1", $post, $check_array);

            echo "all ORDERS from ".$start_date." to ".$end_date." are inserted. <a href='../cron/getrecord'>Click Here</a> to change the date range."; exit;
        }
        echo $inserted. " orders are inserted successfully, please press (F5 / CTRL+R) for resubmit the form to add new record."; exit;
    }
    
    public function updateOrder(){
        
        $sql = "SELECT ao.AmazonOrderId,s.refresh_token,s.client_id,s.client_secret FROM amazon_orders as ao left join store as s on ao.AmazonSellerId = s.AmazonSellerId WHERE ao.isDelete = 0 AND DATE_FORMAT(ao.PurchaseDate, '%Y/%m/%d %H:%i:%s') >= '".date("Y/m/d H:i:s", strtotime("-30 minutes"))."' AND s.refresh_token is NOT null AND s.client_id is not null AND s.client_secret ORDER by ao.order_id Asc";
        $order_datas = $this->crud->getFromSQL($sql);
        // echo "<pre>";
        // print_r($order_datas); exit;
        
        foreach($order_datas as $data){
            
            $order_id = $data->AmazonOrderId;
            $refresh_token = $data->refresh_token;
            $client_id = $data->client_id;
            $client_secret = $data->client_secret;
            
            
            $config = [
                //Guzzle configuration
                'http' => [
                    'verify' => false, //<--- NOT SAFE FOR PRODUCTION
                    //'debug' => true       //<--- NOT SAFE FOR PRODUCTION
                ],

                //LWA: Keys needed to obtain access token from Login With Amazon Service
                'refresh_token' => $refresh_token,
                'client_id' => $client_id,
                'client_secret' => $client_secret,

                //STS: Keys of the IAM role which are needed to generate Secure Session
                // (a.k.a Secure token) for accessing and assuming the IAM role
                'access_key' => 'AKIATJORSRJFWPH7Z4A3',
                'secret_key' => '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',
                'role_arn' => 'arn:aws:iam::226462173771:role/SoleSolution_Role',

                //API: Actual configuration related to the SP API :)
                'region' => 'us-east-1',
                'host' => 'sellingpartnerapi-na.amazon.com',
            ];


            $tokenStorage = new DoubleBreak\Spapi\SimpleTokenStorage('aws-tokens');

            $signer = new DoubleBreak\Spapi\Signer();

            $credentials = new DoubleBreak\Spapi\Credentials($tokenStorage, $signer, $config);
            $cred = $credentials->getCredentials();

            $reportClient = new DoubleBreak\Spapi\Api\Orders($cred, $config);
            
            $result = $reportClient->getOrders([
                'MarketplaceIds' => 'A1AM78C64UM0Y8,A2EUQ1WTGCTBG2,ATVPDKIKX0DER',
                'CreatedAfter' => date("Y-m-d", strtotime("-2 days")),
            ]);
            // echo '<pre>'; print_r($result); echo '</pre>'; exit;
            //echo $order_id;

            $order_d = $reportClient->getOrder($order_id);
            
            $status = isset($order_d['payload']['OrderStatus']) ? $order_d['payload']['OrderStatus'] : "";
            
            if($status == "Canceled"){
                $info = array(
                        "OrderItems" => $status
                    );
                $this->crud->update("amazon_orders", $info, array("AmazonOrderId" => $order_id));
            }
        }
    }
}
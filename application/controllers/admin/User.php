<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class User extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->isLoggedIn();   
        $this->load->model('Crud', 'crud');
    }
    
    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $data = array();
        $day30_ago_date = date('Y-m-d', strtotime('-30 days'));
        $month_to_date = date('Y-m');
        $today_date = date('Y-m-d');

        $login_user_role =  $this->crud->get_column_value_by_id("tbl_users","roleId","id = '".$this->global['vendorId']."'");
       
        if($login_user_role == 1 || $login_user_role == 2)
        {
            if($this->session->userdata('store') && $this->session->userdata('store') > 0){
                $active_store = $this->crud->get_row_by_id('store',' id = '.$this->session->userdata('store').'');

                $data['total_unshipped_orders'] = $this->crud->get_num_rows_with_where("amazon_orders",array("isDelete"=>0,"OrderStatus"=>'Unshipped',"AmazonSellerId" => $active_store['AmazonSellerId']));

                $data['total_pending_orders'] = $this->crud->get_num_rows_with_where("amazon_orders",array("isDelete"=>0,"OrderStatus"=>'Pending', 'DATE_FORMAT(PurchaseDate, "%Y-%m-%d")>=' => $day30_ago_date, 'DATE_FORMAT(PurchaseDate, "%Y-%m-%d")<=' => $today_date,"AmazonSellerId" => $active_store['AmazonSellerId']));
    
                $data['total_month_to_orders'] = $this->crud->get_num_rows_with_where("amazon_orders",array("isDelete"=>0,"OrderStatus"=>'Pending', 'DATE_FORMAT(PurchaseDate, "%Y-%m")=' => $month_to_date,"AmazonSellerId" => $active_store['AmazonSellerId']));
            }else{
                $data['total_unshipped_orders'] = $this->crud->get_num_rows_with_where("amazon_orders",array("isDelete"=>0,"OrderStatus"=>'Unshipped'));

                $data['total_pending_orders'] = $this->crud->get_num_rows_with_where("amazon_orders",array("isDelete"=>0,"OrderStatus"=>'Pending', 'DATE_FORMAT(PurchaseDate, "%Y-%m-%d")>=' => $day30_ago_date, 'DATE_FORMAT(PurchaseDate, "%Y-%m-%d")<=' => $today_date));
    
                $data['total_month_to_orders'] = $this->crud->get_num_rows_with_where("amazon_orders",array("isDelete"=>0,"OrderStatus"=>'Pending', 'DATE_FORMAT(PurchaseDate, "%Y-%m")=' => $month_to_date)); 
            }

        }
        else
        {
            //  print_r($this->session->userdata('store'));
            //     die();

            if($this->session->userdata('store') && $this->session->userdata('store') > 0){
                $active_store = $this->crud->get_row_by_id('store',' id = '.$this->session->userdata('store').'');

                $data['total_unshipped_orders'] = $this->crud->get_num_rows_with_where("amazon_orders",array("isDelete"=>0,"OrderStatus"=>'Unshipped',"AmazonSellerId" => $active_store['AmazonSellerId']));

                $data['total_pending_orders'] = $this->crud->get_num_rows_with_where("amazon_orders",array("isDelete"=>0,"OrderStatus"=>'Pending', 'DATE_FORMAT(PurchaseDate, "%Y-%m-%d")>=' => $day30_ago_date, 'DATE_FORMAT(PurchaseDate, "%Y-%m-%d")<=' => $today_date,"AmazonSellerId" => $active_store['AmazonSellerId']));
     
                $data['total_month_to_orders'] = $this->crud->get_num_rows_with_where("amazon_orders",array("isDelete"=>0,"OrderStatus"=>'Pending', 'DATE_FORMAT(PurchaseDate, "%Y-%m")=' => $month_to_date,"AmazonSellerId" => $active_store['AmazonSellerId']));
            }else{
                // $data['total_unshipped_orders'] = $this->crud->get_num_rows_with_where("amazon_orders",array("isDelete"=>0,"OrderStatus"=>'Unshipped'));

                // $data['total_pending_orders'] = $this->crud->get_num_rows_with_where("amazon_orders",array("isDelete"=>0,"OrderStatus"=>'Pending', 'DATE_FORMAT(PurchaseDate, "%Y-%m-%d")>=' => $day30_ago_date, 'DATE_FORMAT(PurchaseDate, "%Y-%m-%d")<=' => $today_date));
     
                // $data['total_month_to_orders'] = $this->crud->get_num_rows_with_where("amazon_orders",array("isDelete"=>0,"OrderStatus"=>'Pending', 'DATE_FORMAT(PurchaseDate, "%Y-%m")=' => $month_to_date));
            }



        }
        $data['total_stores'] =  $this->crud->get_num_rows_with_where("store",array("userId" => $this->global['vendorId'],"isDelete" => 0));

        // get graph data 

        $join['select'] = 'avg(OrderTotal__Amount) as OrderTotal__Amount , avg(PricePayed) as PricePayed , DATE_FORMAT(ao.PurchaseDate, "%M") as month';
        //$join['select'] = 'DATE_FORMAT(ao.PurchaseDate, "%m/%d/%Y") as PurchaseDateNew, ao.*, REGEXP_REPLACE(OrderItems, \'[^\\x20-\\x7E]\', "") as OrderItems1';
        $join['table'] = 'amazon_orders ao';

        //echo date("Y/m", strtotime ( '-7 month')); exit;

        if($this->session->userdata('store') && $this->session->userdata('store') > 0){
            $active_store = $this->crud->get_row_by_id('store',' id = '.$this->session->userdata('store').'');
            
            $wh = array("ao.isDelete" => '0', "ao.AmazonSellerId" => $active_store['AmazonSellerId'] ,'DATE_FORMAT(ao.PurchaseDate, "%Y/%m") >='=> date("Y/m", strtotime ( '-6 month'))); 

        }else{
            // $wh = array("ao.isDelete" => '0','DATE_FORMAT(ao.PurchaseDate, "%Y/%m") >=' => date("Y/m", strtotime ( '-6 month'))); 
        }
        
        $params['GroupBy']   = 'DATE_FORMAT(ao.PurchaseDate, "%m")';

        $params['ShortBy']   = "ao.order_id";
        $params['ShortOrder'] = "desc";

        $all_total_details = $this->crud->get_join($join,$wh,$params);

        $graph_data = array();

        if($login_user_role == 1 || $login_user_role == 2){
             foreach($all_total_details as $avg_data){ 

                if($avg_data['OrderTotal__Amount']!=0 && $avg_data['PricePayed']!=0)
                {
                    $amazon_fees = (0.15 * $avg_data['OrderTotal__Amount']);
                    $price_diff =  ($avg_data['OrderTotal__Amount'] - $avg_data['PricePayed']);
                    $cal_profit =  round($price_diff - $amazon_fees,2);
                }
                else
                {
                    $amazon_fees = 0;
                    $cal_profit =  "0.00";
                }
    
    
                $data_temp = array(
                    "profit" => $cal_profit,
                    'month' => $avg_data['month']
                );
                array_push($graph_data,$data_temp);
    
            }     
        }
       
        $data['graph_data'] = $graph_data;
 
        // // get graph data - Revenue
        // $join1 = array();
        // $wh1 = array();
        // $params1 = array();
        // $join1['select'] = 'count(*), AVG(`OrderTotal__Amount`), DATE_FORMAT(ao.PurchaseDate, "%D") as day';
        // //$join['select'] = 'DATE_FORMAT(ao.PurchaseDate, "%m/%d/%Y") as PurchaseDateNew, ao.*, REGEXP_REPLACE(OrderItems, \'[^\\x20-\\x7E]\', "") as OrderItems1';
        // $join1['table'] = 'amazon_orders ao';

        // //echo date("Y/m", strtotime ( '-7 month')); exit;

        // if($this->session->userdata('store') && $this->session->userdata('store') > 0){
        //     $active_store = $this->crud->get_row_by_id('store',' id = '.$this->session->userdata('store').'');
            
        //     $wh1 = array("ao.isDelete" => '0', "ao.AmazonSellerId" => $active_store['AmazonSellerId'] ,'DATE_FORMAT(ao.PurchaseDate, "%m/%d") >=' => date("m/d", strtotime ( '-14 days'))); 

        // }else{
        //     $wh1 = array("ao.isDelete" => '0','DATE_FORMAT(ao.PurchaseDate, "%m/%d") >='=> date("m/d", strtotime ( '-14 days'))); 
        // }

        // $params1['GroupBy']   = 'DATE_FORMAT(ao.PurchaseDate, "%m/%d")';
        
        // $params1['ShortBy']   = "ao.order_id";
        // $params1['ShortOrder'] = "desc";

        // $all_total_details = $this->crud->get_join($join1,$wh1,$params1);
        // //echo $this->db->last_query();
        
        // $data['graph_data_revenue'] = $all_total_details;
       
        // get graph data - Revenue
        $join = array();
        $where = array();
        $params = array();
        $join['select'] = 'count(*), AVG(`OrderTotal__Amount`), DATE_FORMAT(ao.PurchaseDate, "%D") as day,s.AmazonSellerId,s.name';
        //$join['select'] = 'DATE_FORMAT(ao.PurchaseDate, "%m/%d/%Y") as PurchaseDateNew, ao.*, REGEXP_REPLACE(OrderItems, \'[^\\x20-\\x7E]\', "") as OrderItems1';
        $join['table'] = 'amazon_orders ao';

        $join['joins'][] = array(
            'join_table' => 'store s', 
            'join_by' => 's.AmazonSellerId = ao.AmazonSellerId', 
            'join_type' => 'inner');

        //echo date("Y/m", strtotime ( '-7 month')); exit;

        if($this->session->userdata('store') && $this->session->userdata('store') > 0){
            $active_store = $this->crud->get_row_by_id('store',' id = '.$this->session->userdata('store').'');           
            $where = array("ao.isDelete" => '0', "ao.AmazonSellerId" => $active_store['AmazonSellerId'] ,'DATE_FORMAT(ao.PurchaseDate, "%m/%d") >=' => date("m/d", strtotime ( '-14 days'))); 
            //$where = array("ao.isDelete" => '0', "ao.AmazonSellerId" => $active_store['AmazonSellerId'] ,'DATE_FORMAT(ao.PurchaseDate, "%m/%d") >=' => date("m/d", strtotime ( '-54 days'))); 
        }else{
            // $where = array("ao.isDelete" => '0','DATE_FORMAT(ao.PurchaseDate, "%m/%d") >='=> date("m/d", strtotime ( '-14 days'))); 

            
            //$where = array("ao.isDelete" => '0','DATE_FORMAT(ao.PurchaseDate, "%m/%d") >='=> date("m/d", strtotime ( '-54 days'))); 
        }

        $params['GroupBy']   = 'AmazonSellerId,DATE_FORMAT(ao.PurchaseDate, "%m/%d")';
        
        $params['ShortBy']   = 'ao.PurchaseDate';
        $params['ShortOrder'] = "Asc";

        $all_total_details = $this->crud->get_join($join, $where, $params);

        if($login_user_role == 1 || $login_user_role == 2){
            $data['graph_data_revenue'] = $all_total_details; 
        }
        
        $this->global['pageTitle'] = ' : Dashboard';
        $this->loadViews(ADMIN."dashboard", $this->global, $data , NULL);
    }

    function filter(){
        $data = array();

        $day30_ago_date = date('Y-m-d', strtotime('-30 days'));
        $today_date = date('Y-m-d');

        $month_to_date = date('Y-m');
        
        $wh_date = array();
        if(isset($_REQUEST['StartDate']) && isset($_REQUEST['EndDate']))
        {
            $wh_date['DATE_FORMAT(PurchaseDate, "%Y/%m/%d") >='] = date("Y/m/d",strtotime($_REQUEST['StartDate']));
            $wh_date['DATE_FORMAT(PurchaseDate, "%Y/%m/%d") <='] = date("Y/m/d",strtotime($_REQUEST['EndDate']));
        }

        $login_user_role =  $this->crud->get_column_value_by_id("tbl_users","roleId","id = '".$this->global['vendorId']."'");

        if($login_user_role == ROLE_SUPER_ADMIN)
        {
            if($this->session->userdata('store') && $this->session->userdata('store') > 0){
                $active_store = $this->crud->get_row_by_id('store',' id = '.$this->session->userdata('store').'');

                $wh = array_merge(array("isDelete"=>0,"OrderStatus"=>'Unshipped',"AmazonSellerId" => $active_store['AmazonSellerId']),$wh_date);
                $data['total_unshipped_orders'] = $this->crud->get_num_rows_with_where("amazon_orders",$wh);

                $wh = array_merge(array("isDelete"=>0,"OrderStatus"=>'Pending',"AmazonSellerId" => $active_store['AmazonSellerId']),$wh_date);
                $data['total_pending_orders'] = $this->crud->get_num_rows_with_where("amazon_orders",$wh);
    
                $wh = array_merge(array("isDelete"=>0,"OrderStatus"=>'Pending', 'DATE_FORMAT(PurchaseDate, "%Y-%m")=' => $month_to_date,"AmazonSellerId" => $active_store['AmazonSellerId']),$wh_date);
                $data['total_month_to_orders'] = $this->crud->get_num_rows_with_where("amazon_orders",$wh);
            }else{

                $wh = array_merge(array("isDelete"=>0,"OrderStatus"=>'Unshipped'),$wh_date);
                $data['total_unshipped_orders'] = $this->crud->get_num_rows_with_where("amazon_orders",array("isDelete"=>0,"OrderStatus"=>'Unshipped'));

                $wh = array_merge(array("isDelete"=>0,"OrderStatus"=>'Pending'),$wh_date);
                $data['total_pending_orders'] = $this->crud->get_num_rows_with_where("amazon_orders",$wh);
                
                $wh = array_merge(array("isDelete"=>0,"OrderStatus"=>'Pending', 'DATE_FORMAT(PurchaseDate, "%Y-%m")=' => $month_to_date),$wh_date);
                $data['total_month_to_orders'] = $this->crud->get_num_rows_with_where("amazon_orders",$wh); 
            }

        }
        else
        {
            if($this->session->userdata('store') && $this->session->userdata('store') > 0){
                $active_store = $this->crud->get_row_by_id('store',' id = '.$this->session->userdata('store').'');

                $wh = array_merge(array("isDelete"=>0,"OrderStatus"=>'Unshipped',"AmazonSellerId" => $active_store['AmazonSellerId']),$wh_date);
                $data['total_unshipped_orders'] = $this->crud->get_num_rows_with_where("amazon_orders",$wh);

                $wh = array_merge(array("isDelete"=>0,"OrderStatus"=>'Pending', "AmazonSellerId" => $active_store['AmazonSellerId']),$wh_date);
                $data['total_pending_orders'] = $this->crud->get_num_rows_with_where("amazon_orders",$wh);
     
                $wh = array_merge(array("isDelete"=>0,"OrderStatus"=>'Pending', 'DATE_FORMAT(PurchaseDate, "%Y-%m")=' => $month_to_date,"AmazonSellerId" => $active_store['AmazonSellerId']),$wh_date);
                $data['total_month_to_orders'] = $this->crud->get_num_rows_with_where("amazon_orders",$wh);
            }else{
                $wh = array_merge(array("isDelete"=>0,"OrderStatus"=>'Unshipped'),$wh_date);
                $data['total_unshipped_orders'] = $this->crud->get_num_rows_with_where("amazon_orders",$wh);

                $wh = array_merge(array("isDelete"=>0,"OrderStatus"=>'Pending', ),$wh_date);
                $data['total_pending_orders'] = $this->crud->get_num_rows_with_where("amazon_orders",$wh);
     
                $wh = array_merge(array("isDelete"=>0,"OrderStatus"=>'Pending', 'DATE_FORMAT(PurchaseDate, "%Y-%m")=' => $month_to_date),$wh_date);
                $data['total_month_to_orders'] = $this->crud->get_num_rows_with_where("amazon_orders",$wh);
            }
        }

        $data['total_stores'] =  $this->crud->get_num_rows_with_where("store",array("userId" => $this->global['vendorId'],"isDelete" => 0));
        $data['day_diff'] = $this->diffday(date("Y/m/d",strtotime($_REQUEST['StartDate'])),date("Y/m/d",strtotime($_REQUEST['EndDate'])));

        echo json_encode($data);
    }

    function diffday($start,$end){

        $now = strtotime($end); // or your date as well
        $your_date = strtotime($start);
        $datediff = $now - $your_date;
        
        return round($datediff / (60 * 60 * 24));
    }
    

}

?>
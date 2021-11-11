<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';


class ManageReport extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->isLoggedIn();  
        $this->load->model('Crud', 'crud'); 
        $this->table = 'amazon_orders';

        $sitesetting = $this->SiteSetting_model->getSiteSetting();
        $this->name = $sitesetting[0]->site_name;
    }

    function profit()
    {
        //die(ADMIN);
        $data = array();

        $this->global['pageTitle'] = ' : Manage Report: Profit';
        $data['user_role'] = $this->loggedInUserRole();
        $data["site_name"] = $this->name;

        if($this->session->userdata('store') && $this->session->userdata('store') > 0){
            $active_store = $this->crud->get_row_by_id('store',' id = '.$this->session->userdata('store').'');
        }
        $data['total_stores'] =  $this->crud->get_num_rows_with_where("store",array("userId" => $this->global['vendorId'],"isDelete" => 0));

        //echo $data['total_stores'];
        // get graph data 

        $join['select'] = 'avg(OrderTotal__Amount) as OrderTotal__Amount , avg(PricePayed) as PricePayed , DATE_FORMAT(ao.PurchaseDate, "%M") as month';
        //$join['select'] = 'DATE_FORMAT(ao.PurchaseDate, "%m/%d/%Y") as PurchaseDateNew, ao.*, REGEXP_REPLACE(OrderItems, \'[^\\x20-\\x7E]\', "") as OrderItems1';
        $join['table'] = 'amazon_orders ao';

        //echo date("Y/m", strtotime ( '-7 month')); exit;

        if($this->session->userdata('store') && $this->session->userdata('store') > 0){
            $active_store = $this->crud->get_row_by_id('store',' id = '.$this->session->userdata('store').'');
            
            $wh = array("ao.isDelete" => '0', "ao.AmazonSellerId" => $active_store['AmazonSellerId'] ,'DATE_FORMAT(ao.PurchaseDate, "%Y/%m") >='=> date("Y/m", strtotime ( '-8 month'))); 

        }else{
            $wh = array("ao.isDelete" => '0','DATE_FORMAT(ao.PurchaseDate, "%Y/%m") >=' => date("Y/m", strtotime ( '-7 month'))); 
        }
        
        $params['GroupBy']   = 'DATE_FORMAT(ao.PurchaseDate, "%m")';

        $params['ShortBy']   = "ao.order_id";
        $params['ShortOrder'] = "desc";

        $all_total_details = $this->crud->get_join($join,$wh,$params);


        $graph_data = array();
        foreach($all_total_details as $avg_data)
        { 
            if($avg_data['OrderTotal__Amount']!=0 && $avg_data['PricePayed']!=0)
            {
                $amazon_fees = (AMAZON_FEE * $avg_data['OrderTotal__Amount']);
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
        $data['graph_data'] = $graph_data;
        $this->loadViews(ADMIN."report/profit", $this->global, $data, NULL);
    }

    function revenue()
    {
        //die(ADMIN);
        $data = array();

        $this->global['pageTitle'] = ' : Manage Report: Revenue';
        $data['user_role'] = $this->loggedInUserRole();
        $data["site_name"] = $this->name;

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
            $where = array("ao.isDelete" => '0','DATE_FORMAT(ao.PurchaseDate, "%m/%d") >='=> date("m/d", strtotime ( '-14 days'))); 

            
            //$where = array("ao.isDelete" => '0','DATE_FORMAT(ao.PurchaseDate, "%m/%d") >='=> date("m/d", strtotime ( '-54 days'))); 
        }

        $params['GroupBy']   = 'AmazonSellerId,DATE_FORMAT(ao.PurchaseDate, "%m/%d")';
        
        $params['ShortBy']   = 'ao.PurchaseDate';
        $params['ShortOrder'] = "Asc";

        $all_total_details = $this->crud->get_join($join, $where, $params);

        
        $data['graph_data_revenue'] = $all_total_details;        
        $this->loadViews(ADMIN."report/revenue", $this->global, $data, NULL);
    }
}
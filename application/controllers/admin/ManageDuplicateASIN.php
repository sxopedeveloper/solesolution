<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';


class ManageDuplicateASIN extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->isLoggedIn();  
        $this->load->model('Crud', 'crud'); 
        $this->table = 'cron_order_log';

        $sitesetting = $this->SiteSetting_model->getSiteSetting();
        $this->name = $sitesetting[0]->site_name;
    }

    function index()
    {
        $data = array();

        $this->global['pageTitle'] = ' : Manage Duplicate ASIN';
        $data['user_role'] = $this->loggedInUserRole();
        $data["site_name"] = $this->name;
        $this->loadViews(ADMIN."manage_duplicate_ASIN", $this->global, $data, NULL);
    }


    function ajax_datatable()
    {
        $tblId      = "order_id";
        $tblgroupId = "ASIN_NO";
        $tblName    = "amazon_orders";
        $tablename  = base64_encode($tblName);
        $tableId    = base64_encode($tblId);

        $config['select'] = 'DISTINCT(name) as SellerName, ASIN_NO';
        $config['table'] = $tblName;
        
        $config['joins'][] = array(
            'join_table' => 'store',
            'join_by' => 'store.AmazonSellerId = amazon_orders.AmazonSellerId ', 
            'join_type' => 'inner');

        $config['column_order'] = array($tblName.'.ASIN_NO');
        $config['column_search'] = array($tblName.'.ASIN_NO');

        if($this->loggedInUserRole() == 1 || $this->loggedInUserRole() == 2)
        {
           $config['custom_where'] = array('amazon_orders.isDelete'=>0);
        }         
        $config['group_by'] = 'amazon_orders.ASIN_NO';


        $this->load->library('datatables', $config, 'datatable');
        $records = $this->datatable->get_datatables();

        $data = array();
        foreach ($records as $record) 
        {  
            $row = array();
            $row[] = $record->ASIN_NO;                
            $row[] = $record->SellerName;              
            $data[] = $row;           
        }
        $output = array(
            "draw" => $_POST['draw'],
            // "recordsTotal" => $this->datatable->count_all(),
            "recordsFiltered" => $this->datatable->count_filtered(),
            "data" => $data,
        );

        echo json_encode($output);
    }

    function deleteLog() {

        $check_array = array('isDelete' => '0');
        $logs = $this->crud->get_all_with_where($this->table, 'amazonSellerId', 'asc', $check_array);
        
        foreach($logs as $log) {
            $data_delete = array('isDelete' => '1');
            $where_array = array('id' => $log->id);
            $result = $this->crud->update($this->table, $data_delete, $where_array);            
        }
        
        if ($result > 0) { 
            echo(json_encode(array('status'=>TRUE))); 
        }
        else { 
            echo(json_encode(array('status'=>FALSE))); 
        }
    }
}
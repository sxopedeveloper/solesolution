<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';


class ManageLog extends BaseController
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

        $this->global['pageTitle'] = ' : Manage Log';
        $data['user_role'] = $this->loggedInUserRole();
        $data["site_name"] = $this->name;
        $this->loadViews(ADMIN."manage_log", $this->global, $data, NULL);
    }


    function ajax_datatable()
    {
        $tblId      = "id";
        $tblName    = "cron_order_log";
        $tablename  = base64_encode($tblName);
        $tableId    = base64_encode($tblId);

        $config['select'] = $tblName.'.*';
        $config['table'] = $tblName;
        $config['column_order'] = array($tblName.'.created_at');
        $config['column_search'] = array($tblName.'.amazonSellerId');         
        if($this->loggedInUserRole() == 1 || $this->loggedInUserRole() == 2)
        {
            $config['custom_where'] = array('isDelete'=>0);
        }         
        $config['order'] = array($tblId => 'desc');


        $this->load->library('datatables', $config, 'datatable');
        $records = $this->datatable->get_datatables();

        // echo '<pre>'; print_r($this->db->last_query()); echo '</pre>'; exit;
        $data = array();
        foreach ($records as $record) 
        {
            if ($record->isDelete == 0) {
                $store = $this->crud->get_row_by_id('store'," AmazonSellerId = '".$record->amazonSellerId."' ");
                $action = '';
                if($this->loggedInUserRole() <= 3)
                {
                    $action .= '<div class="d-flex">';
                    if($this->loggedInUserRole() <= 2)
                        $action .= '<a href="javascript:void(0);" class="mr-2 rowDelete" title="Delete" data-id="'.$record->$tblId.'" data-td="'.$tablename.'" data-i="'.$tableId.'"> <i class="far fa-trash-alt"></i> </a> ';   
                
                    $action .= '</div>';
                }
                $row = array();
                $row[] = $record->amazonSellerId;
                $row[] = $store['name'];
                if ($record->responce_code == 200) {
                    $code = '<i class="far fa-check-circle" style="color: green"></i> '.$record->responce_code;
                } else {
                    $code = '<i class="far fa-times-circle" style="color: red"></i> '.$record->responce_code;
                }
                $row[] = $code;
                $row[] = $record->response;
                $row[] = date('d/m/Y', strtotime($record->created_at));
                $row[] = $action;
                $data[] = $row;
            }
        }
        
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->datatable->count_all(),
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
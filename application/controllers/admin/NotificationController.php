<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';


class NotificationController extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->isLoggedIn();  
        $this->load->model('Crud', 'crud'); 
        $this->table = 'notifications';

        $sitesetting = $this->SiteSetting_model->getSiteSetting();
        $this->name = $sitesetting[0]->site_name;
    }

    function index()
    {
        $data = array();

        $this->global['pageTitle'] = ' : Manage Store';
        $data['user_role'] = $this->loggedInUserRole();
        $data["site_name"] = $this->name;
        $this->loadViews(ADMIN."ManageNotifications", $this->global, $data, NULL);
    }

    function ajax_datatable()
    {
        $tblId      = "id";
        $tblName    = "notifications";
        $tablename  = base64_encode($tblName);
        $tableId    = base64_encode($tblId);

        $config['select'] = $tblName.'.*';
        $config['table'] = $tblName;
        $config['column_order'] = array($tblName.'.created_at');
        $config['column_search'] = array($tblName.'.text');         
        $config['order'] = array($tblId => 'desc');

        if($this->loggedInUserRole() == 1) {
            $type = 'super_admin';
            $config['custom_where'] = array('isDelete' => 0, 'type' => 'super_admin');
        } else {
            $config['custom_where'] = array('isDelete' => 0, 'type' => 'user' , 'user_id' => $this->session->userdata('userId'));
        }
    
        $this->load->library('datatables', $config, 'datatable');
        $records = $this->datatable->get_datatables();
        $data = array();
        foreach ($records as $key => $record) 
        {
            $action = '';
            $action .= '<div class="d-flex">';            
                $action .= '<a href="javascript:void(0);" class="mr-2 rowDelete" title="Delete" data-id="'.$record->$tblId.'" data-td="'.$tablename.'" data-i="'.$tableId.'"> <i class="far fa-trash-alt"></i> </a> ';   
            $action .= '</div>';
            

            $row = array();
            $row[] = $key + 1;
            $row[] = $record->text;
            $row[] = $record->type;
            $user_data = $this->crud->get_row_by_id('tbl_users'," id = '".$record->user_id."' ");
            $row[] = ($user_data['fname']. ''. $user_data['lname']) ? $user_data['fname']. ' '. $user_data['lname'] : '';
            $row[] = $record->read == 0 ? 'N' : 'Y';
            $row[] = $action;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->datatable->count_all(),
            "recordsFiltered" => $this->datatable->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    function notificationRead() {
        $user = $this->crud->get_data_row_by_id("tbl_users", "id", $this->session->userdata('userId'));
        if($this->loggedInUserRole() == 1) {
            $type = "";
            $notifications = $this->getAdminNotifications('super_admin', 0, 5);
        } else {
            $notifications = $this->getUserNotifications('user', 0, 5);
        }
        
        foreach ($notifications as $key => $notification) {
            $this->crud->execuetSQL("UPDATE `notifications` SET `read`='1' WHERE `id` = '".$notification->id."'");
        }

        echo json_encode(['success' => true]);
    }
}
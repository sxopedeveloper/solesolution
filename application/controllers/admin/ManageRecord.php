<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';
require APPPATH . '/libraries/csvimport.php';


class ManageRecord extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->isLoggedIn();  
        $this->load->model('Crud', 'crud'); 
        $this->table = 'manage_files';

        $sitesetting = $this->SiteSetting_model->getSiteSetting();
        $this->name = $sitesetting[0]->site_name;
    }

    function index()
    {
        $data = array();

        $this->global['pageTitle'] = ' : Manage Record';
        $data['user_role'] = $this->loggedInUserRole();
        $data["site_name"] = $this->name;
        $data["stores"] = $this->crud->get_all_with_where('store','name','asc',array('status'=>'Y','isDelete' => '0'));
        $this->loadViews(ADMIN."ManageRecord", $this->global, $data, NULL);
    }


    function ajax_datatable()
    {   

        // echo "<pre>"; 
        // print_r($this->session->userdata('userId')); exit;
        $tblId      = "id";
        $tblName    = $this->table;
        $tablename  = base64_encode($tblName);
        $tableId    = base64_encode($tblId);

        $config['select'] = $tblName.'.*';
        $config['table'] = $tblName;
        $config['column_order'] = array($tblName.'.file_name');
        $config['column_search'] = array($tblName.'.file_name');          
        $config['order'] = array($tblId => 'desc');
        $config['custom_where'] = array('isDelete'=>0);

    
        $this->load->library('datatables', $config, 'datatable');
        $records = $this->datatable->get_datatables();
        $data = array();
        foreach ($records as $record) 
        {
            $action = '';

            $action .= '<div class="d-flex">';
            $action .= '<a target="_blank" href="../'.UPLOAD_DIR.PRODUCT_RECORD_CSV.$record->file_name.'" class="mr-2" title="Download"> <i class="fas fa-download"></i> </a> ';
            $action .= '<a onclick="return isConfirm()" href="'.ADMIN_LINK.'manage-record/delete/'.$record->id.'"> <i class="far fa-trash-alt"></i></a>';
            $action .= '</div>';

            $row = array();
            $row[] = $record->file_name;
            $active_store = $this->crud->get_row_by_id('store',' id = '.$record->store_id.'');
            $row[] = $active_store['name'];
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

    function store() 
    {

        $post = $this->input->post();
        

        $table_name = base64_decode($this->input->post('td')); 
        $field      = base64_decode($this->input->post('i')); 
        $type       = $this->input->post('type'); 
        $editid     = $this->input->post('editid');
        
        unset($post["editid"]);
        unset($post["type"]);
        unset($post["td"]);
        unset($post["i"]);

        $config['upload_path']      = UPLOAD_DIR.PRODUCT_RECORD_CSV;
        $config['allowed_types']    = 'csv';
        $config['max_size']         = '1000';
        $this->load->library('upload', $config);
        $this->upload->do_upload('recordfile');
        $file_data =  $this->upload->data();
        
        $post['file_name'] =  $file_data['file_name'];
        $post['created_at'] = date('Y-m-d H:i:s');

        $is_duplicate = $this->crud->check_duplicate($table_name,array("store_id"=>$post['store_id'],"file_name"=>$file_data['file_name'],"isDelete"=>"0"));
        if($is_duplicate)
        {
            $data["msg"]        = 'Record already exists. Please try another.';
        }
        else
        {
            $result = $this->crud->insert($table_name,$post);
            if($result > 0)
            {
                $data["msg"]        = 'Record Added successfully';
            }
            else
            {
                $data["msg"]        = 'Something went wrong';
            }
        }      
        echo json_encode($data);
        exit;
    }

    function delete($id) 
    {
        $data = array( "isDelete" => 1);
        $result = $this->crud->update($this->table,$data,array("id"=>$id));
     
        redirect(ADMIN.'manage-record');
    }
}
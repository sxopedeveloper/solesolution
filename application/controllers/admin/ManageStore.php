<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';


class ManageStore extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->isLoggedIn();  
        $this->load->model('Crud', 'crud'); 
        $this->table = 'store';

        $sitesetting = $this->SiteSetting_model->getSiteSetting();
        $this->name = $sitesetting[0]->site_name;
    }

    function index()
    {
        $data = array();

        $this->global['pageTitle'] = ' : Manage Store';
        $data['user_role'] = $this->loggedInUserRole();
        $data["site_name"] = $this->name;
        $this->loadViews(ADMIN."ManageStore", $this->global, $data, NULL);
    }

    function add_card_form()
    {
        $data = array();

        $this->global['pageTitle'] = ' : Manage card';
        $data['user_role'] = $this->loggedInUserRole();
        $data["site_name"] = $this->name;
        $this->loadViews(ADMIN."add_card", $this->global, $data, NULL);
    }

    function ManageCard($id)
    {   
        $data = array();

        $this->global['pageTitle'] = ' : Manage Card';
        $data['user_role'] = $this->loggedInUserRole();
        $data["site_name"] = $this->name;
        $data['store_id'] = $id;
        $this->loadViews(ADMIN."ManageCard", $this->global, $data, NULL);
    }

    function ajax_datatable()
    {
        $tblId      = "id";
        $tblName    = "store";
        $tablename  = base64_encode($tblName);
        $tableId    = base64_encode($tblId);

        $config['select'] = $tblName.'.*';
        $config['table'] = $tblName;
        $config['column_order'] = array($tblName.'.created_at');
        $config['column_search'] = array($tblName.'.name');         
        $config['order'] = array($tblId => 'desc');

        if($this->loggedInUserRole() == 1 || $this->loggedInUserRole() == 2)
        {
            $config['custom_where'] = array('isDelete'=>0);
        }
        else
        {
            $config['custom_where'] = array('isDelete' => 0);
            $user_store = $this->crud->get_column_value_by_id("tbl_users","store_id","id = '".$this->session->userdata('userId')."'");
            $user_store = $user_store != "" ? $user_store : "";
            // echo "<pre>";
            // print_r($user_store); exit;
            if(!empty($user_store)){
                $config['custom_where'] = array('isDelete' => 0);
                $config['where_in'] = $user_store;
                $config['where_in_column'] = "id";
            }else{
                $config['custom_where'] = array('isDelete' => 0 ,'id' => 0);
            }
        } 


        $this->load->library('datatables', $config, 'datatable');
        $records = $this->datatable->get_datatables();
        //echo $this->db->last_query(); exit;
        $data = array();
        foreach ($records as $record) 
        {
            $user_data = $this->crud->get_row_by_id('tbl_users'," id = '".$this->vendorId."' ");

            $action = '';
            if($this->loggedInUserRole() <= 3)
            {
                $action .= '<div class="d-flex">';
                $action .= '<a href="javascript:void(0);" class="mr-2 rowEdit" title="Edit" data-id="'.$record->$tblId.'" data-td="'.$tablename.'" data-i="'.$tableId.'"> <i class="far fa-edit"></i> </a> ';
                if($this->loggedInUserRole() <= 2)
                    $action .= '<a href="javascript:void(0);" class="mr-2 rowDelete" title="Delete" data-id="'.$record->$tblId.'" data-td="'.$tablename.'" data-i="'.$tableId.'"> <i class="far fa-trash-alt"></i> </a> ';   
                    
                if($this->loggedInUserRole() == 3)
                    $action .= '<a href="javascript:void(0);" class="mr-2 addmanager " title="Add Manager" data-id="'.$record->$tblId.'" data-td="'.$tablename.'" data-i="'.$tableId.'"> <i class="anticon font-size-16 anticon-user"></i> </a> ';    
                // $action .= '<a href="javascript:void(0);" class="btn btn-primary btn-sm connectStore" data-id="'.$record->$tblId.'" data-td="'.$tablename.'" data-i="'.$tableId.'"> Connect Store </a> ';
                // $action .= '<a href="manage-card/edit/'.$record->$tblId.'" class="btn btn-primary btn-sm ml-5"> Edit Card Detail </a> ';
                // $action .= '<button class="btn btn-primary mr-2 rowFetchOrder" title="View" data-id="'.$record->$tblId.'" data-td="'.$tablename.'" data-i="'.$tableId.'"> Fetch order </button> ';
                $action .= '<input type="text" name="daterange" onfocus="initDateRange(this)" data-id="'.$record->$tblId.'" placeholder="Select date range" class="dateRange'.$record->$tblId.' mr-2"/>
                            <button class="btn btn-primary mr-2 rowFetchOrderByDate" title="View" data-id="'.$record->$tblId.'" data-td="'.$tablename.'" data-i="'.$tableId.'"> Fetch order By Date </button>';
                $action .= '</div>';
            }
            else
            {
                $action .= '<div class="d-flex">';
                $action .= '<a href="javascript:void(0);" class="mr-2 rowEdit" title="View" data-id="'.$record->$tblId.'" data-td="'.$tablename.'" data-i="'.$tableId.'"> <i class="far fa-eye"></i> </a> ';
                // $action .= '<a href="javascript:void(0);" class="btn btn-primary mr-2 rowFetchOrder" title="View" data-id="'.$record->$tblId.'" data-td="'.$tablename.'" data-i="'.$tableId.'"> Fetch order </a> ';
                $action .= '<input type="text" name="daterange" onfocus="initDateRange(this)" data-id="'.$record->$tblId.'" placeholder="Select date range" class="dateRange'.$record->$tblId.' mr-2"/><button class="btn btn-primary mr-2 rowFetchOrderByDate" title="View" data-id="'.$record->$tblId.'" data-td="'.$tablename.'" data-i="'.$tableId.'"> Fetch order By Date </button>';
                $action .= '</div>';
            }
            
            $ischecked = $record->status == 'Y' ? 'checked="checked"' : '';
            $status = $record->status == 'N' ? 'N' : 'Y';

            $row = array();
            $row[] = $record->name;

            if($this->loggedInUserRole() == 1 || $this->loggedInUserRole() == 2)
            {
                $details_url = base_url().'admin/manage-admin/edit/'.$record->userId;
                $row[] = "<a href='".$details_url."'>".ucwords($user_data['fname']." ".$user_data['lname'])."</a>";

                $row[] = '<div class="form-group d-flex align-items-center mb-0">
                        <div class="switch m-r-10">
                            <input type="checkbox" class="changeStatus" data-id="'.$record->$tblId.'" data-status="'.$status.'" data-td="'.$tablename.'" data-i="'.$tableId.'" id="switch'.$record->$tblId.'" name="isActive" '.$ischecked.'>
                            <label for="switch'.$record->$tblId.'"></label>
                        </div>
                    </div>';

            }
            else
            {
                if($record->status == 'Y')
                {
                    $dis_status = '<span class="badge badge-pill badge-cyan">Approved</span>';
                }
                else
                {
                    $dis_status = '<span class="badge badge-pill badge-red">Pending</span>';
                }

                $row[] = $dis_status;
            }
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

    function ajax_get_card_datatable($id)
    {
        $tblId      = "id";
        $tblName    = "card_data";
        $tablename  = base64_encode($tblName);
        $tableId    = base64_encode($tblId);

        $config['select'] = $tblName.'.*';
        $config['table'] = $tblName;
        $config['column_order'] = array($tblName.'.card_name');
        $config['column_search'] = array($tblName.'.card_name');         
        $config['order'] = array($tblId => 'desc');

        if($this->loggedInUserRole() == 1)
        {
            $config['custom_where'] = array('isDelete'=>0,'store_id' => $id);
        }
        else
        {
            $config['custom_where'] = array('isDelete' => 0,'store_id' => $id,'userId' => $this->vendorId);
        } 

        $this->load->library('datatables', $config, 'datatable');

        $records = $this->datatable->get_datatables();

        $data = array();
        
        foreach ($records as $record) 
        {
            $user_data = $this->crud->get_row_by_id('tbl_users'," id = '".$this->vendorId."' ");

            $action = '<div class="d-flex">';
            $action .= '<a href="javascript:void(0);" class="mr-2 rowEdit" data-id="'.$record->$tblId.'" data-td="'.$tablename.'" data-i="'.$tableId.'"> <i class="far fa-edit"></i> </a> ';

            $action .= '<a href="javascript:void(0);" class="mr-2 rowDelete" data-id="'.$record->$tblId.'" data-td="'.$tablename.'" data-i="'.$tableId.'"> <i class="far fa-trash-alt"></i> </a> ';

            //$action .= '<a href="javascript:void(0);" class="btn btn-primary btn-sm connectStore" data-id="'.$record->$tblId.'" data-td="'.$tablename.'" data-i="'.$tableId.'"> Connect Store </a> ';

            $action .= '</div>';
            
            // $ischecked = $record->status == 'Y' ? 'checked="checked"' : '';
            // $status = $record->status == 'N' ? 'N' : 'Y';

            $row = array();
            $row[] = $record->card_name;
            $row[] = $record->card_limit;

            // if($this->loggedInUserRole() == 1)
            // {
            //     $details_url = base_url().'admin/manage-admin/edit/'.$record->userId;
            //     $row[] = "<a href='".$details_url."'>".ucwords($user_data['fname']." ".$user_data['lname'])."</a>";

            //     // $row[] = '<div class="form-group d-flex align-items-center mb-0">
            //     //         <div class="switch m-r-10">
            //     //             <input type="checkbox" class="changeStatus" data-id="'.$record->$tblId.'" data-status="'.$status.'" data-td="'.$tablename.'" data-i="'.$tableId.'" id="switch'.$record->$tblId.'" name="isActive" '.$ischecked.'>
            //     //             <label for="switch'.$record->$tblId.'"></label>
            //     //         </div>
            //     //     </div>';

            // }
            // else
            // {
            //     if($record->status == 'Y')
            //     {
            //         $dis_status = '<span class="badge badge-pill badge-cyan">Approved</span>';
            //     }
            //     else
            //     {
            //         $dis_status = '<span class="badge badge-pill badge-red">Pending</span>';
            //     }

            //     $row[] = $dis_status;
            // }

            
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

    function showform($id="")
    {
        
    }

    function store() 
    {
        $post = $this->input->post();
        $this->load->library('form_validation');            
        $this->form_validation->set_rules('name','Store Name ','trim|required');
        $this->form_validation->set_rules('AmazonSellerId','Amazon SellerId ','trim|required');
        
        if($this->form_validation->run() == FALSE)
        {
            $data["msg"]        = validation_errors();
            $data["msg_type"]   = 'error';
            echo json_encode($data);
            exit;
        }
        else
        {
            $table_name = base64_decode($this->input->post('td')); 
            $field      = base64_decode($this->input->post('i')); 
            $type       = $this->input->post('type'); 
            $editid     = $this->input->post('editid');
            $slug       = $this->slug->create_slug($post['name']);
            
            unset($post["editid"]);
            unset($post["type"]);
            unset($post["td"]);
            unset($post["i"]);

            $post['slug']       = $slug;
            $post['created_at'] = date('Y-m-d H:i:s');

            if($type == "add")
            {   
                $is_duplicate = $this->crud->check_duplicate($table_name,array("slug"=>$slug,"userId"=>$post['userId'],"isDelete"=>"0"));
                if($is_duplicate)
                {
                    $data["msg"]        = 'Record already exists. Please try another.';
                }
                else
                {
                    $result = $this->crud->insert($table_name,$post);
                    //echo $this->db->last_query();die();

                    if($result > 0)
                    {
                        $data["msg"]        = 'Record Added successfully';
                    }
                    else
                    {
                        $data["msg"]        = 'Something went wrong';
                    }
                }
            }

            if($type == "edit")
            {
                $editid = $this->input->post('editid'); 
                $is_duplicate = $this->crud->check_duplicate($table_name,array($field."!="=>$editid,"slug"=>$slug,"userId"=>$post['userId'],"isDelete"=>"0"));
                if($is_duplicate)
                {
                    $data["msg"]        = 'Record already exists. Please try another.';
                }
                else
                {
                    $where_array = array($field=>$editid);
                    $result = $this->crud->update($table_name,$post,$where_array);

                    if($result > 0)
                    {
                        $data["msg"]        = 'Record Updated successfully';
                    }
                    else
                    {
                        $data["msg"]        = 'Something went wrong';
                    }
                }
            }
          
            echo json_encode($data);
            exit;
        }
    }

    function storecard() 
    {
        $post = $this->input->post();
        $this->load->library('form_validation');            
        $this->form_validation->set_rules('card_name','Card Name ','trim|required');
        $this->form_validation->set_rules('card_limit','card limit ','trim|required');
        
        if($this->form_validation->run() == FALSE)
        {
            $data["msg"]        = validation_errors();
            $data["msg_type"]   = 'error';
            echo json_encode($data);
            exit;
        }
        else
        {
            //$table_name = base64_decode($this->input->post('td')); 
            $table_name = "card_data"; 
            $field      = base64_decode($this->input->post('i')); 
            $type       = $this->input->post('type'); 
            $editid     = $this->input->post('editid');
            $slug       = $this->slug->create_slug($post['card_name']);
            
            unset($post["editid"]);
            unset($post["type"]);
            unset($post["td"]);
            unset($post["i"]);

            $post['slug']       = $slug;
            $post['created_at'] = date('Y-m-d H:i:s');

            if($type == "add")
            {   
                $is_duplicate = $this->crud->check_duplicate($table_name,array("slug"=>$slug,"userId"=>$post['userId'],"isDelete"=>"0"));
                if($is_duplicate)
                {
                    $data["msg"]        = 'Record already exists. Please try another.';
                }
                else
                {
                    $result = $this->crud->insert($table_name,$post);
                    //echo $this->db->last_query();die();

                    if($result > 0)
                    {
                        $data["msg"]        = 'Record Added successfully';
                    }
                    else
                    {
                        $data["msg"]        = 'Something went wrong';
                    }
                }
            }

            if($type == "edit")
            {
                $editid = $this->input->post('editid'); 
                $is_duplicate = $this->crud->check_duplicate($table_name,array($field."!="=>$editid,"slug"=>$slug,"userId"=>$post['userId'],"isDelete"=>"0"));
                if($is_duplicate)
                {
                    $data["msg"]        = 'Record already exists. Please try another.';
                }
                else
                {
                    $where_array = array($field=>$editid);
                    $result = $this->crud->update($table_name,$post,$where_array);

                    if($result > 0)
                    {
                        $data["msg"]        = 'Record Updated successfully';
                    }
                    else
                    {
                        $data["msg"]        = 'Something went wrong';
                    }
                }
            }
          
            echo json_encode($data);
            exit;
        }
    }

    function delete($id) 
    {
        $data = array( "isDeleted" => 1);
        $result = $this->crud->update($this->table,$data,array("id"=>$id));
        if($result) 
        {
            $update_data1 =  array(
                "isDeleted"  => '1',
            );
            $wh_data1 = array("id"=>$id);
            $this->crud->update($this->table,$update_data1,$wh_data1);
            
            $this->session->set_flashdata('success', 'Record deleted successfully');
        } 
        else 
        {
            $this->session->set_flashdata('error', 'Something went wrong.');            
        }      
        redirect(ADMIN.'manage-admin');
    }

    function delete_card($id) 
    {
        $data = array( "isDeleted" => 1);
        $result = $this->crud->update($this->table,$data,array("id"=>$id));
        if($result) 
        {
            $update_data1 =  array(
                "isDeleted"  => '1',
            );
            $wh_data1 = array("id"=>$id);
            $this->crud->update($this->table,$update_data1,$wh_data1);
            
            $this->session->set_flashdata('success', 'Record deleted successfully');
        } 
        else 
        {
            $this->session->set_flashdata('error', 'Something went wrong.');            
        }      
        redirect(ADMIN.'manage-admin');
    }

    function chnagestatus($id){
        if($id == "all"){
            $this->session->unset_userdata('store');
        }else{
            $this->session->set_userdata('store', $id);
        }
        
        //redirect(ADMIN.'dashboard');
    }

    function getManager(){
        $s_manager_data = $this->crud->getFromSQL('SELECT id FROM `tbl_users` where  roleId = 4 and store_id in ('.$_REQUEST['id'].')');

        $temp = array();
        foreach($s_manager_data as $s_m){
            $temp[] = $s_m->id;    
        }
        $manager_datas =  $this->crud->get_all_with_where('tbl_users','fname','asc',array('roleId'=>4,'isDeleted'=>0));
        $html = "";
        foreach($manager_datas as $manager){
            $selected = "";
            if(in_array($manager->id, $temp)){
                $selected = "selected";
            }
            $html .= '<option value="'.$manager->id.'" '.$selected.'>'.$manager->fname.' '.$manager->lname.'</option>'; 
        }
        echo $html;
    }

    function setManager(){
        $store_id = $_REQUEST['editid'];
        $manager_ids = isset($_REQUEST['manager']) ? $_REQUEST['manager'] : "";

        //$this->crud->update('tbl_users',$post,$where_array);
        if(!empty($manager_ids)){
                foreach($manager_ids as $m_id){
                    $store = $this->crud->get_column_value_by_id('tbl_users','store_id',"id = ".$m_id."");
                    if(!empty($store)){
                        $store = $store.','.$store_id;
                        $post['store_id']  = $store;
                    }else{
                        $post['store_id']  = $store_id;
                    }
                    $where_array = array('id'=>$m_id);
                    $this->crud->update('tbl_users',$post,$where_array);
                }
        }
        $data["msg"]  = 'Manager Added successfully';
        echo json_encode($data);
        exit;
    }
}
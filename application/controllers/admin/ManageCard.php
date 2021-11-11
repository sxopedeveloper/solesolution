<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';


class ManageCard extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->isLoggedIn();  
        $this->load->model('Crud', 'crud'); 
        $this->table = 'card_data';

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


    function showform($id="")
    {   
        $this->global['pageTitle'] = ' : Manage card';
        $data['user_role'] = $this->loggedInUserRole();
        $data["site_name"] = $this->name;
        if($id!="" && $id > 0){
            $data['card_data'] = $this->crud->get_all_with_where($this->table,'','',array("store_id"=>$id,"isDelete"=>"0"));
            $data['store_id'] = $id;
            $this->loadViews(ADMIN."edit_card", $this->global, $data, NULL);
        }else{
            $this->loadViews(ADMIN."add_card", $this->global, $data, NULL);
        }
    }

    function store() 
    {
        $post = $this->input->post();
        $count = count($post['card_name']);
        for($i=0;$i<$count;$i++){
            $slug       = $this->slug->create_slug($post['card_name'][$i]);
            $is_duplicate = $this->crud->check_duplicate($this->table,array("slug"=>$slug,"store_id"=>$post['store'],"isDelete"=>"0"));
            if(!$is_duplicate){
                $card['slug']       = $slug;
                $card['card_name'] = $post['card_name'][$i];
                $card['card_number'] = $post['card_number'][$i];
                $card['card_expiry_month'] = $post['card_expiry_month'][$i];
                $card['card_expiry_year'] = $post['card_expiry_year'][$i];
                $card['card_cvv'] = $post['card_cvv'][$i];
                $card['card_limit'] = $post['card_limit'][$i];
                $card['store_id'] = $post['store'];
                $card['created_at'] = date('Y-m-d H:i:s');
                $this->crud->insert($this->table,$card);
            }
            $this->session->set_flashdata('success', 'card added successfully');
        }
        redirect(ADMIN.'manage-store');
    }

    function update($id="") 
    {
        $post = $this->input->post();
        $count = count($post['card_name']);
        for($i=0;$i<$count;$i++){
            $slug       = $this->slug->create_slug($post['card_name'][$i]);
            $is_duplicate = $this->crud->check_duplicate($this->table,array("slug"=>$slug,"store_id"=>$id,"isDelete"=>"0"));
            if(!$is_duplicate){
                $card['slug']       = $slug;
                $card['card_name'] = $post['card_name'][$i];
                $card['card_number'] = $post['card_number'][$i];
                $card['card_expiry_month'] = $post['card_expiry_month'][$i];
                $card['card_expiry_year'] = $post['card_expiry_year'][$i];
                $card['card_cvv'] = $post['card_cvv'][$i];
                $card['card_limit'] = $post['card_limit'][$i];
                $card['store_id'] = $id;
                $card['created_at'] = date('Y-m-d H:i:s');
                $this->crud->insert($this->table,$card);
            }else{
                $card['slug']       = $slug;
                $card['card_name'] = $post['card_name'][$i];
                $card['card_number'] = $post['card_number'][$i];
                $card['card_expiry_month'] = $post['card_expiry_month'][$i];
                $card['card_expiry_year'] = $post['card_expiry_year'][$i];
                $card['card_cvv'] = $post['card_cvv'][$i];
                $card['card_limit'] = $post['card_limit'][$i];
                $card['store_id'] = $id;

                $editid = $this->crud->get_one_value($this->table,array("slug"=>$slug,"store_id"=>$id,"isDelete"=>"0"),"id");

                $where_array = array('id'=>$editid);
                $update_result = $this->crud->update($this->table,$card,$where_array);
            }
            $this->session->set_flashdata('success', 'card updated successfully');
        }
        redirect(ADMIN.'manage-store');
    }

    function delete($id) 
    {
        $data = array( "isDelete" => 1);
        $this->crud->update($this->table,$data,array("id"=>$id));
    }
}
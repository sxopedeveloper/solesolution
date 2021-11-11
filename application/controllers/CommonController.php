  <?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';


class CommonController extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {

        parent::__construct();
        //$this->isLoggedIn();  
        $this->load->model('Crud', 'crud'); 
        $this->table = 'city';
    }


    function changeStatus()
    {   
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        $table_name = base64_decode( $this->input->post('td') );
        $field = base64_decode( $this->input->post('i') );
        $data_array = array('status'=> $status);
        $where_array = array($field => $id);
        $result = $this->crud->update($table_name,$data_array,$where_array);

        if ($result > 0) {
            echo(json_encode(array('status'=>TRUE))); 
        }
        else { 
            echo(json_encode(array('status'=>FALSE))); 
        }
        
    }

    function deleteData()
    {
        $id = $this->input->post('id');
        $table_name = base64_decode( $this->input->post('td') );
        $field = base64_decode( $this->input->post('i') );
        
        $where_array = array($field => $id);

        $data_delete = array('isDelete' => '1');

        $result = $this->crud->update($table_name,$data_delete,$where_array);
        //$result = $this->crud->delete($table_name,$where_array);
        
        if ($result > 0) { 
            echo(json_encode(array('status'=>TRUE))); 
        }
        else { 
            echo(json_encode(array('status'=>FALSE))); 
        }
    }

    function getEditRecord()
    {
        $field = base64_decode( $this->input->post('i') );
        $id = $this->input->post('id');
        $table_name = base64_decode( $this->input->post('td') );
        $result = $this->crud->get_row_by_id($table_name,' '.$field.' = '.$id.'  '); 

        if(isset($result['PricePayed']))
            $this->session->set_userdata('PricePayed', $result['PricePayed']);
        
        if(isset($result['ShipmentTrackingNumber'])){
            $this->session->set_userdata('ShipmentTrackingNumber', $result['ShipmentTrackingNumber']);
        
            if($result['shippedby_id'] > 0){
                $user_data = $this->crud->get_row_by_id("tbl_users","id = ".$result['shippedby_id']."");
                $result['shippedby_name'] = $user_data['fname']." ".$user_data['lname'];
            }else{
                $result['shippedby_name'] = "";
            }
        }
        echo json_encode($result);
    }

    function insertRecord()
    {
        $post = $this->input->post();
        $this->load->library('form_validation');            
        $this->form_validation->set_rules('name','Name ','trim|required');
        
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
            $isActive   = ( isset($post['isActive']) && $post['isActive'] == 'on' ? 'Y' : 'N');
            $slug       = $this->slug->create_slug($post['name']);

            unset($post["editid"]);
            unset($post["type"]);
            unset($post["isActive"]);
            unset($post["td"]);
            unset($post["i"]);

            $post['slug']       = $slug;
            $post['created_at'] = date('Y-m-d H:i:s');
            $post['status']     = $isActive;

            if($type == "add")
            {
                $is_duplicate = $this->crud->check_duplicate($table_name,array("slug"=>$slug,"isDelete"=>"0"));
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
            }

            if($type == "edit")
            {
                $editid = $this->input->post('editid'); 
                $is_duplicate = $this->crud->check_duplicate($table_name,array($field."!="=>$editid,"slug"=>$slug,"isDelete"=>"0"));
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

    function getCityByState()
    {
        $id = $this->input->post('id');
        $result = $this->crud->get_all_with_where('city','name','asc',array('status'=>'Y','state_id'=>$id));
        if(!empty($result)){
            echo json_encode($result);
        }else{
            echo json_encode('blank');            
        }
       
    }
   
    function getCityAreaByCity()
    {
        $id = $this->input->post('id');
        $result = $this->crud->get_all_with_where('city_area','name','asc',array('status'=>'Y','city_id'=>$id))  ;
        if(!empty($result)){
            echo json_encode($result);
        }else{
            echo json_encode('blank');            
        }
       
    }

    function isUserLogin() 
    {
        $user_id = $this->session->userdata('front_UserId');
        if(!isset($user_id) && $user_id == '') 
        {
            $this->session->set_flashdata('error', 'Please login to your account.');
            redirect("SignIn");
        }
    }

    function Favorites()
    {
        $this->isUserLogin();
        $pid = $this->input->post('pid');
        $type = $this->input->post('type');
        $status = $this->input->post('status');
        $user_id = $this->session->userdata('front_UserId');

        if(isset($pid) && $pid > 0 && $type!='')
        {
            $DataInfo = array(
                'user_id'                   =>  $user_id,
                'product_id'                =>  $pid,
                'type'                      =>  $type,
            
            );

            if($status=='0')
            {
                 $result = $this->crud->insert('favorites',$DataInfo);
                // echo $this->db->last_query(); die();

                if($result > 0)
                {
                    echo(json_encode(array('status'=>TRUE))); 
                }
                else
                {
                    $this->session->set_flashdata('error', 'Something went wrong');
                }
            }
        
            else
            {
                $result = $this->crud->delete('favorites',$where);
                // echo $this->db->last_query(); die();

                if($result > 0)
                {
                   echo(json_encode(array('status'=>FALSE))); 
                }
                else
                {
                    $this->session->set_flashdata('error', 'Something went wrong');
                }
            }
        
        }

        
    }
    
}
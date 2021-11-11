<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';
require APPPATH . '/libraries/csvimport.php';

class ProductController extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->isLoggedIn();  
        $this->load->model('Crud', 'crud'); 
        $this->table = 'product';
        $this->load->library('csvimport');
        $this->load->library('Ajax_pagination.php');
        $this->perPage = 10; 
    }

    function index()
    {   
        $data = array();
        $param = array();

        $data["user_lists"] = $this->crud->getFromSQL("select fname,id from tbl_users where isDeleted = 0 and (roleId = 4 OR roleId = 5)");

        $param['Select'] = "brand";
        $param['GroupBy'] = "brand";
        $merchant_lists = $this->crud->get_data('product',array('status'=>'Y','isDelete' => '0','brand!=' => ''),$param);
        $data["merchant_lists"]   = $merchant_lists;

        $this->global['pageTitle'] = ' : Manage Product';
        $this->loadViews(ADMIN."ManageProduct", $this->global, $data, NULL);
    }
    
    function ajaxPaginationData()
    {
        $user_id = $this->session->userdata('userId');

        $params = array();
        $page = $this->input->post('page');

        if(!$page) { $offset = 0; } else { $offset = $page; }
      
        $perpage = $this->input->post('perpage');
        $this->perPage = $perpage;

        $join['select'] = 'p.*';
        $join['table'] = 'product p';
               
        if($this->session->userdata('store') && $this->session->userdata('store') > 0){
            $active_store = $this->crud->get_row_by_id('store',' id = '.$this->session->userdata('store').'');
            
            //$wh = array("p.isDelete" => '0', "p.AmazonSellerId" => $active_store['AmazonSellerId']); 
            $wh = array("p.isDelete" => '0'); 

        }else{
            $wh = array("p.isDelete" => '0'); 
        }
        
        if(isset($_REQUEST['SearchTerm']))
        {
            $SearchTerm = $_REQUEST['SearchTerm'];
        }

        if(!empty($SearchTerm))
        {
          $params['like'] = array("`brand`" => $SearchTerm,'`sku`' => $SearchTerm,'`product-id`' => $SearchTerm,'`product-id-type`' => $SearchTerm,'`price`' => $SearchTerm,'`minimum-seller-allowed-price`' => $SearchTerm,'`maximum-seller-allowed-price`' => $SearchTerm,'`item-condition`' => $SearchTerm,'`quantity`' => $SearchTerm,'`add-delete`' => $SearchTerm,'`will-ship-internationally`' => $SearchTerm,'`expedited-shipping`' => $SearchTerm,'`standard-plus`' => $SearchTerm,'`item-note`' => $SearchTerm);
        }

        if(isset($_REQUEST['merchant']))
        {
            $merchant = $_REQUEST['merchant'];
        }

        if(!empty($merchant))
        {
            $wh["p.brand"]= $merchant;
        }

        if(isset($_REQUEST['ListedBy']))
        {
            $ListedBy = $_REQUEST['ListedBy'];
        }

        if(!empty($ListedBy))
        {
            $wh["p.userId"]= $ListedBy;
        }
        else
        {
            $wh["p.userId"]= $user_id;
        }

        $totalRec = count($this->crud->get_join($join,$wh,$params));
        //echo $this->db->last_query();die();
        $config['target']      = '#resultList';
        $config['base_url']    = base_url().'admin/ProductController/ajaxPaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['uri_segment'] = 4;
        $config['link_func']   = "searchFilter";

        $this->ajax_pagination->initialize($config);
       
        $params['ShortBy']   = "p.id";
        $params['ShortOrder'] = "desc";
        $data['all_total_details'] = $this->crud->get_join($join,$wh,$params);

        $params['start']     = $offset;
        $params['Limit']     = $this->perPage;
        $data['posts'] = $this->crud->get_join($join,$wh,$params);
        //print_r($data);die();
        //echo $this->db->last_query();
        $this->load->view(ADMIN."product_ajax_data",$data);
    }

    // function store() 
    // {
    //     $post = $this->input->post();
    //     $type = $post['type'];

    //     $brand                     = $post['brand'];
            
    //     $fieldInfo = array(
    //         'brand'                     => $brand,
    //         'updated_at'                => date("Y-m-d h:i:s"),
    //     );

    //     if($type == "add")
    //     {
    //         //$insert_result = $this->crud->insert($this->table,$fieldInfo);
    //     }

    //     if($type == "edit")
    //     {
    //         $editid = $this->input->post('editid'); 
    //         $where_array = array('id'=>$editid);
    //         $update_result = $this->crud->update($this->table,$fieldInfo,$where_array);
    //     }

    //     if($insert_result > 0)
    //     {
    //         $this->session->set_flashdata('success', 'Details inserted successfully');
    //     }
    //     else if($update_result > 0)
    //     {
    //         $this->session->set_flashdata('success', 'Details updated successfully');
    //     }
    //     else
    //     {
    //         $this->session->set_flashdata('error', 'Something went wrong.');
    //     }

    //     redirect(ADMIN.'manage-product');
    // }

    function store() 
    {
        $post = $this->input->post();
        $type = $post['type'];

        $brand                     = $post['brand'];
        $brand                                          = $post['brand'];
        $brand_slug                                     = $this->slug->create_slug($brand);
        $sku                                            = $post['sku'];
        $product_id                                     = $post['product-id'];
        $product_id_type                                = $post['product-id-type'];
        $price                                          = $post['price'];
        $minimum_seller_allowed_price                   = $post['minimum-seller-allowed-price'];
        $maximum_seller_allowed_price                   = $post['maximum-seller-allowed-price'];
        $item_condition                                 = $post['item-condition'];
        $quantity                                       = $post['quantity'];
        $add_delete                                     = $post['add-delete'];
        $will_ship_internationally                      = $post['will-ship-internationally'];
        $expedited_shipping                             = $post['expedited-shipping'];
        $standard_plus                                  = $post['standard-plus'];
        $item_note                                      = $post['item-note'];
        $fulfillment_center_id                          = $post['fulfillment-center-id'];
        $product_tax_code                               = $post['product-tax-code'];
        $handling_time                                  = $post['handling-time'];
        $merchant_shipping_group_name                   = $post['merchant_shipping_group_name'];
        $batteries_required                             = $post['batteries_required'];
        $are_batteries_included                         = $post['are_batteries_included'];
        $battery_cell_composition                       = $post['battery_cell_composition'];
        $battery_type                                   = $post['battery_type'];
        $number_of_batteries                            = $post['number_of_batteries'];
        $battery_weight                                 = $post['battery_weight'];
        $number_of_lithium_ion_cells                    = $post['number_of_lithium_ion_cells'];
        $number_of_lithium_metal_cells                  = $post['number_of_lithium_metal_cells'];
        $lithium_battery_packaging                      = $post['lithium_battery_packaging'];
        $lithium_battery_energy_content                 = $post['lithium_battery_energy_content'];
        $lithium_battery_weight                         = $post['lithium_battery_weight'];
        $hazmat_united_nations_regulatory_id            = $post['hazmat_united_nations_regulatory_id'];
        $safety_data_sheet_url                          = $post['safety_data_sheet_url'];
        $item_weight                                    = $post['item_weight'];
        $item_volume                                    = $post['item_volume'];
        $flash_point                                    = $post['flash_point'];
        $ghs_classification_class1                      = $post['ghs_classification_class1'];
        $ghs_classification_class2                      = $post['ghs_classification_class2'];
        $ghs_classification_class3                      = $post['ghs_classification_class3'];
        $item_weight_unit_of_measure                    = $post['item_weight_unit_of_measure'];
        $item_volume_unit_of_measure                    = $post['item_volume_unit_of_measure'];
        $lithium_battery_energy_content_unit_of_measure = $post['lithium_battery_energy_content_unit_of_measure'];
        $lithium_battery_weight_unit_of_measure         = $post['lithium_battery_weight_unit_of_measure'];
        $supplier_declared_dg_hz_regulation1            = $post['supplier_declared_dg_hz_regulation1'];
        $supplier_declared_dg_hz_regulation2            = $post['supplier_declared_dg_hz_regulation2'];
        $supplier_declared_dg_hz_regulation3            = $post['supplier_declared_dg_hz_regulation3'];
        $supplier_declared_dg_hz_regulation4            = $post['supplier_declared_dg_hz_regulation4'];
        $supplier_declared_dg_hz_regulation5            = $post['supplier_declared_dg_hz_regulation5'];
        $battery_weight_unit_of_measure                 = $post['battery_weight_unit_of_measure'];
        $california_proposition_65_compliance_type      = $post['california_proposition_65_compliance_type'];
        $california_proposition_65_chemical_names1      = $post['california_proposition_65_chemical_names1'];
        $california_proposition_65_chemical_names2      = $post['california_proposition_65_chemical_names2'];
        $california_proposition_65_chemical_names3      = $post['california_proposition_65_chemical_names3'];
        $california_proposition_65_chemical_names4      = $post['california_proposition_65_chemical_names4'];
        $california_proposition_65_chemical_names5      = $post['california_proposition_65_chemical_names5'];

        if($minimum_seller_allowed_price == "" || $maximum_seller_allowed_price == "")
        {
            $this->session->set_flashdata('error', 'Please add minimum_seller_allowed_price and maximum_seller_allowed_price.');
            redirect(ADMIN.'manage-product');
        }

        if($sku == '')
        {
            $this->session->set_flashdata('error', 'Please add sku.');
            redirect(ADMIN.'manage-product');
        }

        if($fulfillment_center_id == 'AMAZON_NA')
        {
            if($batteries_required == '')
            {
                $this->session->set_flashdata('error', 'Please add batteries_required.');
                redirect(ADMIN.'manage-product');
            }
        }

        if($batteries_required == 'TRUE')
        {
            if($are_batteries_included == "")
            {
                $this->session->set_flashdata('error', 'Please add are_batteries_included.');
                redirect(ADMIN.'manage-product');
            }
        }

        if($are_batteries_included == 'TRUE')
        {
            if($battery_cell_composition == "")
            {
                $this->session->set_flashdata('error', 'Please add battery_cell_composition.');
                redirect(ADMIN.'manage-product');
            }
        }

        if($battery_cell_composition == "Lithium Variants")
        {
            if($battery_type == "")
            {
                $this->session->set_flashdata('error', 'Please add battery_type.');
                redirect(ADMIN.'manage-product');
            }

            if($number_of_batteries == "")
            {
                $this->session->set_flashdata('error', 'Please add number_of_batteries.');
                redirect(ADMIN.'manage-product');
            }

            if($battery_weight == "")
            {
                $this->session->set_flashdata('error', 'Please add battery_weight.');
                redirect(ADMIN.'manage-product');
            }

            if($number_of_lithium_ion_cells == "")
            {
                $this->session->set_flashdata('error', 'Please add number_of_lithium_ion_cells.');
                redirect(ADMIN.'manage-product');
            }

            if($number_of_lithium_metal_cells == "")
            {
                $this->session->set_flashdata('error', 'Please add number_of_lithium_metal_cells.');
                redirect(ADMIN.'manage-product');
            }

            if($lithium_battery_packaging == "")
            {
                $this->session->set_flashdata('error', 'Please add lithium_battery_packaging.');
                redirect(ADMIN.'manage-product');
            }
        }

        if($battery_cell_composition == "Lithium Ion Variants")
        {
            if($lithium_battery_energy_content == "")
            {
                $this->session->set_flashdata('error', 'Please add lithium_battery_energy_content.');
                redirect(ADMIN.'manage-product');
            }
        }

        if($battery_cell_composition == "Lithium Metal Variants")
        {
            if($lithium_battery_weight == "")
            {
                $this->session->set_flashdata('error', 'Please add lithium_battery_weight.');
                redirect(ADMIN.'manage-product');
            }
        }

        if($supplier_declared_dg_hz_regulation1 == "transportation" || $supplier_declared_dg_hz_regulation2 == "transportation" || $supplier_declared_dg_hz_regulation3 == "transportation" || $supplier_declared_dg_hz_regulation4 == "transportation" || $supplier_declared_dg_hz_regulation5 == "transportation")
        {
            if($hazmat_united_nations_regulatory_id == "")
            {
                $this->session->set_flashdata('error', 'Please add hazmat_united_nations_regulatory_id.');
                redirect(ADMIN.'manage-product');
            }
        }

        if($supplier_declared_dg_hz_regulation1 == "ghs" || $supplier_declared_dg_hz_regulation2 == "ghs" || $supplier_declared_dg_hz_regulation3 == "ghs" || $supplier_declared_dg_hz_regulation4 == "ghs" || $supplier_declared_dg_hz_regulation5 == "ghs")
        {
            if($safety_data_sheet_url == "")
            {
                $this->session->set_flashdata('error', 'Please add safety_data_sheet_url.');
                redirect(ADMIN.'manage-product');
            }
        }

        if($supplier_declared_dg_hz_regulation1 == "IN" || $supplier_declared_dg_hz_regulation2 == "IN" || $supplier_declared_dg_hz_regulation3 == "IN" || $supplier_declared_dg_hz_regulation4 == "IN" || $supplier_declared_dg_hz_regulation5 == "IN")
        {
            if($item_weight == "")
            {
                $this->session->set_flashdata('error', 'Please add item_weight.');
                redirect(ADMIN.'manage-product');
            }
        }

        if($supplier_declared_dg_hz_regulation1 == "ghs" || $supplier_declared_dg_hz_regulation2 == "ghs" || $supplier_declared_dg_hz_regulation3 == "ghs" || $supplier_declared_dg_hz_regulation4 == "ghs" || $supplier_declared_dg_hz_regulation5 == "ghs")
        {
            if($ghs_classification_class1 == "" )
            {
                $this->session->set_flashdata('error', 'Please add ghs_classification_class1.');
                redirect(ADMIN.'manage-product');
            }
            if($ghs_classification_class2 == "" )
            {
                $this->session->set_flashdata('error', 'Please add ghs_classification_class2.');
                redirect(ADMIN.'manage-product');
            }
            if($ghs_classification_class3 == "" )
            {
                $this->session->set_flashdata('error', 'Please add ghs_classification_class3.');
                redirect(ADMIN.'manage-product');
            }
        }

        if (strpos($california_proposition_65_compliance_type, 'food') !== false || strpos($california_proposition_65_compliance_type, 'furniture') !== false || strpos($california_proposition_65_compliance_type, 'chemical') !== false) 
        {
            if($california_proposition_65_chemical_names1 == "")
            {
                $this->session->set_flashdata('error', 'Please add california_proposition_65_chemical_names1.');
                redirect(ADMIN.'manage-product');
            }

            if($california_proposition_65_chemical_names2 == "")
            {
                $this->session->set_flashdata('error', 'Please add california_proposition_65_chemical_names2.');
                redirect(ADMIN.'manage-product');
            }

            if($california_proposition_65_chemical_names3 == "")
            {
                $this->session->set_flashdata('error', 'Please add california_proposition_65_chemical_names3.');
                redirect(ADMIN.'manage-product');
            }

            if($california_proposition_65_chemical_names4 == "")
            {
                $this->session->set_flashdata('error', 'Please add california_proposition_65_chemical_names4.');
                redirect(ADMIN.'manage-product');
            }

            if($california_proposition_65_chemical_names5 == "")
            {
                $this->session->set_flashdata('error', 'Please add california_proposition_65_chemical_names5.');
                redirect(ADMIN.'manage-product');
            }
        }
            
        // $fieldInfo = array(
        //     'brand'                     => $brand,
        //     'updated_at'                => date("Y-m-d h:i:s"),
        // );

        $fieldInfo = array(
            'brand'                                         => $brand,
            'sku'                                           => $sku,
            'product-id'                                    => $product_id,
            'product-id-type'                               => $product_id_type,
            'price'                                         => $price,
            'minimum-seller-allowed-price'                  => $minimum_seller_allowed_price,
            'maximum-seller-allowed-price'                  => $maximum_seller_allowed_price,
            'item-condition'                                => $item_condition,
            'quantity'                                      => $quantity,
            'add-delete'                                    => $add_delete,
            'will-ship-internationally'                     => $will_ship_internationally,
            'expedited-shipping'                            => $expedited_shipping,
            'standard-plus'                                 => $standard_plus,
            'item-note'                                     => $item_note,
            'fulfillment-center-id'                         => $fulfillment_center_id,
            'product-tax-code'                              => $product_tax_code,                       
            'handling-time'                                 => $handling_time,                                     
            'merchant_shipping_group_name'                  => $merchant_shipping_group_name,                   
            'batteries_required'                            => $batteries_required,                             
            'are_batteries_included'                        => $are_batteries_included,                         
            'battery_cell_composition'                      => $battery_cell_composition,                       
            'battery_type'                                  => $battery_type,                                   
            'number_of_batteries'                           => $number_of_batteries,                            
            'battery_weight'                                => $battery_weight,                                 
            'number_of_lithium_ion_cells'                   => $number_of_lithium_ion_cells,                    
            'number_of_lithium_metal_cells'                 => $number_of_lithium_metal_cells,                  
            'lithium_battery_packaging'                     => $lithium_battery_packaging,                      
            'lithium_battery_energy_content'                => $lithium_battery_energy_content,                 
            'lithium_battery_weight'                        => $lithium_battery_weight,                         
            'hazmat_united_nations_regulatory_id'           => $hazmat_united_nations_regulatory_id,            
            'safety_data_sheet_url'                         => $safety_data_sheet_url,                          
            'item_weight'                                   => $item_weight,                                    
            'item_volume'                                   => $item_volume,                                    
            'flash_point'                                   => $flash_point,                                    
            'ghs_classification_class1'                     => $ghs_classification_class1,                      
            'ghs_classification_class2'                     => $ghs_classification_class2,                      
            'ghs_classification_class3'                     => $ghs_classification_class3,                      
            'item_weight_unit_of_measure'                   => $item_weight_unit_of_measure,                    
            'item_volume_unit_of_measure'                   => $item_volume_unit_of_measure,                    
            'lithium_battery_energy_content_unit_of_measure' => $lithium_battery_energy_content_unit_of_measure, 
            'lithium_battery_weight_unit_of_measure'        => $lithium_battery_weight_unit_of_measure,         
            'supplier_declared_dg_hz_regulation1'           => $supplier_declared_dg_hz_regulation1,            
            'supplier_declared_dg_hz_regulation2'           => $supplier_declared_dg_hz_regulation2,            
            'supplier_declared_dg_hz_regulation3'           => $supplier_declared_dg_hz_regulation3,            
            'supplier_declared_dg_hz_regulation4'           => $supplier_declared_dg_hz_regulation4,            
            'supplier_declared_dg_hz_regulation5'           => $supplier_declared_dg_hz_regulation5,            
            'battery_weight_unit_of_measure'                => $battery_weight_unit_of_measure,                 
            'california_proposition_65_compliance_type'     => $california_proposition_65_compliance_type,      
            'california_proposition_65_chemical_names1'     => $california_proposition_65_chemical_names1,      
            'california_proposition_65_chemical_names2'     => $california_proposition_65_chemical_names2,      
            'california_proposition_65_chemical_names3'     => $california_proposition_65_chemical_names3,      
            'california_proposition_65_chemical_names4'     => $california_proposition_65_chemical_names4,      
            'california_proposition_65_chemical_names5'     => $california_proposition_65_chemical_names5,
            'updated_at'                => date("Y-m-d h:i:s"),
        );

        if($type == "add")
        {
            //$insert_result = $this->crud->insert($this->table,$fieldInfo);
        }

        if($type == "edit")
        {   
            $editid = $this->input->post('editid'); 
            $where_array = array('id'=>$editid);
            $update_result = $this->crud->update($this->table,$fieldInfo,$where_array);
        }

        if($insert_result > 0)
        {
            $this->session->set_flashdata('success', 'Details inserted successfully');
        }
        else if($update_result > 0)
        {
            $this->session->set_flashdata('success', 'Details updated successfully');
        }
        else
        {
            $this->session->set_flashdata('error', 'Something went wrong.');
        }

        redirect(ADMIN.'manage-product');
    }

    function readcsv()
    {
        $post = $this->input->post();

        /*echo "===";
        print_r($_REQUEST);
        print_r($_FILES);
        die();*/
        $response = array();

        if($post['csv_process_step'] == 1)
        {
            $data['error']              = '';    //initialize image upload error array to empty
            $config['upload_path']      = UPLOAD_DIR.PRODUCT_RECORD_CSV;
            $config['allowed_types']    = 'csv';
            $config['max_size']         = '1000';
            $user_id                    = $this->session->userdata('userId');

            $this->load->library('upload', $config);

            // If upload failed, display error
            if (!$this->upload->do_upload('productfile')) 
            {
                $response['res']        = 1;
                $response['res_msg']    = $this->upload->display_errors();
            } 
            else 
            {
                $file_data =  $this->upload->data();
                $file_path =  UPLOAD_DIR.PRODUCT_RECORD_CSV.$file_data['file_name'];
                //echo "<pre>"; print_r($this->csvimport->get_array($file_path))."-----";die();

                if($this->csvimport->get_array($file_path)) 
                {
                    $csv_array = $this->csvimport->get_array($file_path);
                    
                    $response['header']                 = $csv_array['column_headers'];
                    $response['res']                    = 0;
                    $response['uploaded_pro_csv_file']  = $file_path;
                    $response['step_res']               = 1;
                } 
                else 
                {
                    $response['res_msg'] = 'Error occured';
                    $response['res']     = 1;
                }
            }

            echo json_encode($response);die();
        }
        else if($post['csv_process_step'] == 2)
        {
            $file_path =  $post['uploaded_pro_csv_file'];
            //echo "<pre>"; print_r($this->csvimport->get_array($file_path))."-----";die();

            if($this->csvimport->get_array($file_path)) 
            {
                $csv_array = $this->csvimport->get_array($file_path);
                
                $except_res_brand_arr = array();

                foreach ($csv_array['data'] as $row) 
                {
                    $brand                                          = $row[$post['brand']];
                    $brand_slug                                     = $this->slug->create_slug($brand);
                    $sku                                            = $row[$post['sku']];
                    $product_id                                     = $row[$post['product-id']];
                    $product_id_type                                = $row[$post['product-id-type']];
                    $price                                          = $row[$post['price']];
                    $minimum_seller_allowed_price                   = $row[$post['minimum-seller-allowed-price']];
                    $maximum_seller_allowed_price                   = $row[$post['maximum-seller-allowed-price']];
                    $item_condition                                 = $row[$post['item-condition']];
                    $quantity                                       = $row[$post['quantity']];
                    $add_delete                                     = $row[$post['add-delete']];
                    $will_ship_internationally                      = $row[$post['will-ship-internationally']];
                    $expedited_shipping                             = $row[$post['expedited-shipping']];
                    $standard_plus                                  = $row[$post['standard-plus']];
                    $item_note                                      = $row[$post['item-note']];
                    $fulfillment_center_id                          = $row[$post['fulfillment-center-id']];
                    $product_tax_code                               = $row[$post['product-tax-code']];
                    $handling_time                                  = $row[$post['handling-time']];
                    $merchant_shipping_group_name                   = $row[$post['merchant_shipping_group_name']];
                    $batteries_required                             = $row[$post['batteries_required']];
                    $are_batteries_included                         = $row[$post['are_batteries_included']];
                    $battery_cell_composition                       = $row[$post['battery_cell_composition']];
                    $battery_type                                   = $row[$post['battery_type']];
                    $number_of_batteries                            = $row[$post['number_of_batteries']];
                    $battery_weight                                 = $row[$post['battery_weight']];
                    $number_of_lithium_ion_cells                    = $row[$post['number_of_lithium_ion_cells']];
                    $number_of_lithium_metal_cells                  = $row[$post['number_of_lithium_metal_cells']];
                    $lithium_battery_packaging                      = $row[$post['lithium_battery_packaging']];
                    $lithium_battery_energy_content                 = $row[$post['lithium_battery_energy_content']];
                    $lithium_battery_weight                         = $row[$post['lithium_battery_weight']];
                    $hazmat_united_nations_regulatory_id            = $row[$post['hazmat_united_nations_regulatory_id']];
                    $safety_data_sheet_url                          = $row[$post['safety_data_sheet_url']];
                    $item_weight                                    = $row[$post['item_weight']];
                    $item_volume                                    = $row[$post['item_volume']];
                    $flash_point                                    = $row[$post['flash_point']];
                    $ghs_classification_class1                      = $row[$post['ghs_classification_class1']];
                    $ghs_classification_class2                      = $row[$post['ghs_classification_class2']];
                    $ghs_classification_class3                      = $row[$post['ghs_classification_class3']];
                    $item_weight_unit_of_measure                    = $row[$post['item_weight_unit_of_measure']];
                    $item_volume_unit_of_measure                    = $row[$post['item_volume_unit_of_measure']];
                    $lithium_battery_energy_content_unit_of_measure = $row[$post['lithium_battery_energy_content_unit_of_measure']];
                    $lithium_battery_weight_unit_of_measure         = $row[$post['lithium_battery_weight_unit_of_measure']];
                    $supplier_declared_dg_hz_regulation1            = $row[$post['supplier_declared_dg_hz_regulation1']];
                    $supplier_declared_dg_hz_regulation2            = $row[$post['supplier_declared_dg_hz_regulation2']];
                    $supplier_declared_dg_hz_regulation3            = $row[$post['supplier_declared_dg_hz_regulation3']];
                    $supplier_declared_dg_hz_regulation4            = $row[$post['supplier_declared_dg_hz_regulation4']];
                    $supplier_declared_dg_hz_regulation5            = $row[$post['supplier_declared_dg_hz_regulation5']];
                    $battery_weight_unit_of_measure                 = $row[$post['battery_weight_unit_of_measure']];
                    $california_proposition_65_compliance_type      = $row[$post['california_proposition_65_compliance_type']];
                    $california_proposition_65_chemical_names1      = $row[$post['california_proposition_65_chemical_names1']];
                    $california_proposition_65_chemical_names2      = $row[$post['california_proposition_65_chemical_names2']];
                    $california_proposition_65_chemical_names3      = $row[$post['california_proposition_65_chemical_names3']];
                    $california_proposition_65_chemical_names4      = $row[$post['california_proposition_65_chemical_names4']];
                    $california_proposition_65_chemical_names5      = $row[$post['california_proposition_65_chemical_names5']];

                    $user_id = $this->session->userdata('userId');

                    if($minimum_seller_allowed_price == "" || $maximum_seller_allowed_price == "")
                    {
                        $response['res_msg'] = 'Please add minimum_seller_allowed_price and maximum_seller_allowed_price column details in csv record.';
                        $response['res']     = 1;
                        echo json_encode($response);die();
                    }

                    if($sku == '')
                    {
                        $response['res_msg'] = 'Please add sku column details in csv record.';
                        $response['res']     = 1;
                        echo json_encode($response);die();
                    }

                    if($fulfillment_center_id == 'AMAZON_NA')
                    {
                        if($batteries_required == '')
                        {
                            $response['res_msg'] = 'Please add batteries_required column details in csv record.';
                            $response['res']     = 1;
                            echo json_encode($response);die();
                        }
                    }

                    if($batteries_required == 'TRUE')
                    {
                        if($are_batteries_included == "")
                        {
                            $response['res_msg'] = 'Please add are_batteries_included column details in csv record.';
                            $response['res']     = 1;
                            echo json_encode($response);die();
                        }
                    }

                    if($are_batteries_included == 'TRUE')
                    {
                        if($battery_cell_composition == "")
                        {
                            $response['res_msg'] = 'Please add battery_cell_composition column details in csv record.';
                            $response['res']     = 1;
                            echo json_encode($response);die();
                        }
                    }

                    if($battery_cell_composition == "Lithium Variants")
                    {
                        if($battery_type == "")
                        {
                            $response['res_msg'] = 'Please add battery_type column details in csv record.';
                            $response['res']     = 1;
                            echo json_encode($response);die();
                        }

                        if($number_of_batteries == "")
                        {
                            $response['res_msg'] = 'Please add number_of_batteries column details in csv record.';
                            $response['res']     = 1;
                            echo json_encode($response);die();
                        }

                        if($battery_weight == "")
                        {
                            $response['res_msg'] = 'Please add battery_weight column details in csv record.';
                            $response['res']     = 1;
                            echo json_encode($response);die();
                        }

                        if($number_of_lithium_ion_cells == "")
                        {
                            $response['res_msg'] = 'Please add number_of_lithium_ion_cells column details in csv record.';
                            $response['res']     = 1;
                            echo json_encode($response);die();
                        }

                        if($number_of_lithium_metal_cells == "")
                        {
                            $response['res_msg'] = 'Please add number_of_lithium_metal_cells column details in csv record.';
                            $response['res']     = 1;
                            echo json_encode($response);die();
                        }

                        if($lithium_battery_packaging == "")
                        {
                            $response['res_msg'] = 'Please add lithium_battery_packaging column details in csv record.';
                            $response['res']     = 1;
                            echo json_encode($response);die();
                        }
                    }

                    if($battery_cell_composition == "Lithium Ion Variants")
                    {
                        if($lithium_battery_energy_content == "")
                        {
                            $response['res_msg'] = 'Please add lithium_battery_energy_content column details in csv record.';
                            $response['res']     = 1;
                            echo json_encode($response);die();
                        }
                    }

                    if($battery_cell_composition == "Lithium Metal Variants")
                    {
                        if($lithium_battery_weight == "")
                        {
                            $response['res_msg'] = 'Please add lithium_battery_weight column details in csv record.';
                            $response['res']     = 1;
                            echo json_encode($response);die();
                        }
                    }

                    if($supplier_declared_dg_hz_regulation1 == "transportation" || $supplier_declared_dg_hz_regulation2 == "transportation" || $supplier_declared_dg_hz_regulation3 == "transportation" || $supplier_declared_dg_hz_regulation4 == "transportation" || $supplier_declared_dg_hz_regulation5 == "transportation")
                    {
                        if($hazmat_united_nations_regulatory_id == "")
                        {
                            $response['res_msg'] = 'Please add hazmat_united_nations_regulatory_id column details in csv record.';
                            $response['res']     = 1;
                            echo json_encode($response);die();
                        }
                    }

                    if($supplier_declared_dg_hz_regulation1 == "ghs" || $supplier_declared_dg_hz_regulation2 == "ghs" || $supplier_declared_dg_hz_regulation3 == "ghs" || $supplier_declared_dg_hz_regulation4 == "ghs" || $supplier_declared_dg_hz_regulation5 == "ghs")
                    {
                        if($safety_data_sheet_url == "")
                        {
                            $response['res_msg'] = 'Please add safety_data_sheet_url column details in csv record.';
                            $response['res']     = 1;
                            echo json_encode($response);die();
                        }
                    }

                    if($supplier_declared_dg_hz_regulation1 == "IN" || $supplier_declared_dg_hz_regulation2 == "IN" || $supplier_declared_dg_hz_regulation3 == "IN" || $supplier_declared_dg_hz_regulation4 == "IN" || $supplier_declared_dg_hz_regulation5 == "IN")
                    {
                        if($item_weight == "")
                        {
                            $response['res_msg'] = 'Please add item_weight column details in csv record.';
                            $response['res']     = 1;
                            echo json_encode($response);die();
                        }
                    }

                    if($supplier_declared_dg_hz_regulation1 == "ghs" || $supplier_declared_dg_hz_regulation2 == "ghs" || $supplier_declared_dg_hz_regulation3 == "ghs" || $supplier_declared_dg_hz_regulation4 == "ghs" || $supplier_declared_dg_hz_regulation5 == "ghs")
                    {
                        if($ghs_classification_class1 == "" )
                        {
                            $response['res_msg'] = 'Please add ghs_classification_class1 column details in csv record.';
                            $response['res']     = 1;
                            echo json_encode($response);die();
                        }
                        if($ghs_classification_class2 == "" )
                        {
                            $response['res_msg'] = 'Please add ghs_classification_class2 column details in csv record.';
                            $response['res']     = 1;
                            echo json_encode($response);die();
                        }
                        if($ghs_classification_class3 == "" )
                        {
                            $response['res_msg'] = 'Please add ghs_classification_class3 column details in csv record.';
                            $response['res']     = 1;
                            echo json_encode($response);die();
                        }
                    }

                    if (strpos($california_proposition_65_compliance_type, 'food') !== false || strpos($california_proposition_65_compliance_type, 'furniture') !== false || strpos($california_proposition_65_compliance_type, 'chemical') !== false) 
                    {
                        if($california_proposition_65_chemical_names1 == "")
                        {
                            $response['res_msg'] = 'Please add california_proposition_65_chemical_names1 column details in csv record.';
                            $response['res']     = 1;
                            echo json_encode($response);die();
                        }

                        if($california_proposition_65_chemical_names2 == "")
                        {
                            $response['res_msg'] = 'Please add california_proposition_65_chemical_names2 column details in csv record.';
                            $response['res']     = 1;
                            echo json_encode($response);die();
                        }

                        if($california_proposition_65_chemical_names3 == "")
                        {
                            $response['res_msg'] = 'Please add california_proposition_65_chemical_names3 column details in csv record.';
                            $response['res']     = 1;
                            echo json_encode($response);die();
                        }

                        if($california_proposition_65_chemical_names4 == "")
                        {
                            $response['res_msg'] = 'Please add california_proposition_65_chemical_names4 column details in csv record.';
                            $response['res']     = 1;
                            echo json_encode($response);die();
                        }

                        if($california_proposition_65_chemical_names5 == "")
                        {
                            $response['res_msg'] = 'Please add california_proposition_65_chemical_names5 column details in csv record.';
                            $response['res']     = 1;
                            echo json_encode($response);die();
                        }
                    }

                    $check_duplicate = $this->crud->check_duplicate('brand_restricted',array('slug'=>$brand_slug,'isDelete'=>0));
                    if($check_duplicate)
                    {
                        
                    }
                    else
                    {
                        $amazon_fees = (0.15 * $maximum_seller_allowed_price);
                        $price_diff =  ($maximum_seller_allowed_price - $minimum_seller_allowed_price);
                        $cal_profit =  ($price_diff - $amazon_fees);

                        if($cal_profit > 0)
                        {
                            $except_res_brand_arr[] = $row;

                            $insert_data = array(
                                'added_by'                                      => 1,
                                'userId'                                        => $user_id,
                                'brand'                                         => $brand,
                                'sku'                                           => $sku,
                                'product-id'                                    => $product_id,
                                'product-id-type'                               => $product_id_type,
                                'price'                                         => $price,
                                'minimum-seller-allowed-price'                  => $minimum_seller_allowed_price,
                                'maximum-seller-allowed-price'                  => $maximum_seller_allowed_price,
                                'item-condition'                                => $item_condition,
                                'quantity'                                      => $quantity,
                                'add-delete'                                    => $add_delete,
                                'will-ship-internationally'                     => $will_ship_internationally,
                                'expedited-shipping'                            => $expedited_shipping,
                                'standard-plus'                                 => $standard_plus,
                                'item-note'                                     => $item_note,
                                'fulfillment-center-id'                         => $fulfillment_center_id,
                                'product-tax-code'                              => $product_tax_code,                       
                                'handling-time'                                 => $handling_time,                                     
                                'merchant_shipping_group_name'                  => $merchant_shipping_group_name,                   
                                'batteries_required'                            => $batteries_required,                             
                                'are_batteries_included'                        => $are_batteries_included,                         
                                'battery_cell_composition'                      => $battery_cell_composition,                       
                                'battery_type'                                  => $battery_type,                                   
                                'number_of_batteries'                           => $number_of_batteries,                            
                                'battery_weight'                                => $battery_weight,                                 
                                'number_of_lithium_ion_cells'                   => $number_of_lithium_ion_cells,                    
                                'number_of_lithium_metal_cells'                 => $number_of_lithium_metal_cells,                  
                                'lithium_battery_packaging'                     => $lithium_battery_packaging,                      
                                'lithium_battery_energy_content'                => $lithium_battery_energy_content,                 
                                'lithium_battery_weight'                        => $lithium_battery_weight,                         
                                'hazmat_united_nations_regulatory_id'           => $hazmat_united_nations_regulatory_id,            
                                'safety_data_sheet_url'                         => $safety_data_sheet_url,                          
                                'item_weight'                                   => $item_weight,                                    
                                'item_volume'                                   => $item_volume,                                    
                                'flash_point'                                   => $flash_point,                                    
                                'ghs_classification_class1'                     => $ghs_classification_class1,                      
                                'ghs_classification_class2'                     => $ghs_classification_class2,                      
                                'ghs_classification_class3'                     => $ghs_classification_class3,                      
                                'item_weight_unit_of_measure'                   => $item_weight_unit_of_measure,                    
                                'item_volume_unit_of_measure'                   => $item_volume_unit_of_measure,                    
                                'lithium_battery_energy_content_unit_of_measure' => $lithium_battery_energy_content_unit_of_measure, 
                                'lithium_battery_weight_unit_of_measure'        => $lithium_battery_weight_unit_of_measure,         
                                'supplier_declared_dg_hz_regulation1'           => $supplier_declared_dg_hz_regulation1,            
                                'supplier_declared_dg_hz_regulation2'           => $supplier_declared_dg_hz_regulation2,            
                                'supplier_declared_dg_hz_regulation3'           => $supplier_declared_dg_hz_regulation3,            
                                'supplier_declared_dg_hz_regulation4'           => $supplier_declared_dg_hz_regulation4,            
                                'supplier_declared_dg_hz_regulation5'           => $supplier_declared_dg_hz_regulation5,            
                                'battery_weight_unit_of_measure'                => $battery_weight_unit_of_measure,                 
                                'california_proposition_65_compliance_type'     => $california_proposition_65_compliance_type,      
                                'california_proposition_65_chemical_names1'     => $california_proposition_65_chemical_names1,      
                                'california_proposition_65_chemical_names2'     => $california_proposition_65_chemical_names2,      
                                'california_proposition_65_chemical_names3'     => $california_proposition_65_chemical_names3,      
                                'california_proposition_65_chemical_names4'     => $california_proposition_65_chemical_names4,      
                                'california_proposition_65_chemical_names5'     => $california_proposition_65_chemical_names5,
                                'status'                                        =>  'Y',
                                'is_from_csv'                                   =>  '1',
                            );

                            $result = $this->crud->insert($this->table,$insert_data);
                        }
                    }
                }

                //echo "<pre>"; print_r($except_res_brand_arr);die();
                
                $filename = 'users_'.$user_id."_".date('Ymd').'.csv'; 
                header("Content-type: application/csv");
                header("Content-Disposition: attachment; filename=$filename");
                header("Pragma: no-cache");
                header("Expires: 0");

                //$file = fopen('php://output', 'w');
                $file = fopen(UPLOAD_DIR.PRODUCT_RECORD_CSV.$filename, 'wb');
 
                $header = $csv_array['column_headers'];
                fputcsv($file, $header);
                foreach ($except_res_brand_arr as $key=>$line)
                { 
                    fputcsv($file,$line); 
                }
                fclose($file); 
                //exit();

                $url = base_url().UPLOAD_DIR.PRODUCT_RECORD_CSV.$filename;

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

                $login_user_details         = $this->crud->get_row_by_id("tbl_users",array('id'=>$user_id,'isDeleted'=>0));
                $mail_data['fname']         = $login_user_details['fname'];
                $mail_data['url']           = $url;

                $message = $this->load->view('mail_template/generated_csv_mail_template', $mail_data, TRUE);

                $mailbody['ToEmail']        = $login_user_details['email'];
                $mailbody['FromName']       = $general_setting->site_name;
                $mailbody['FromEmail']      = $general_setting->site_from_email;
                $mailbody['Subject']        = $general_setting->site_name." - CSV generated except restricted brand product details";
                $mailbody['Message']        = $message;
                $mailbody['attach_file']    = UPLOAD_DIR.PRODUCT_RECORD_CSV.$filename;
    
                $mail_result = $this->EmailSend($mailbody);
                
                $response['res_msg']    = 'New csv generated successfully. <a target="_blank" href="'.base_url().UPLOAD_DIR.PRODUCT_RECORD_CSV.$filename.'"> ( Click here to download ) </a>';
                $response['res']        = 0;
                $response['step_res']   = 2;
                echo json_encode($response);die();
            } 
            else 
            {
                $response['res_msg'] = 'Error occured';
                $response['res']     = 1;
                echo json_encode($response);die();
            }
        }   
        else
        {
            $response['res_msg'] = 'Something went wrong. Please try again.';
            $response['res']     = 1;

            echo json_encode($response);die();
        }
    }

    function importcsv() 
    {
        $data['error'] = '';    //initialize image upload error array to empty

        $config['upload_path'] = UPLOAD_DIR.PRODUCT_RECORD_CSV;
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '1000';

        $this->load->library('upload', $config);

        // If upload failed, display error
        if (!$this->upload->do_upload('productfile')) 
        {
            $this->session->set_flashdata('error', $this->upload->display_errors());
            redirect(ADMIN.'manage-product');
        } 
        else 
        {
            $file_data = $this->upload->data();
            $file_path =  UPLOAD_DIR.PRODUCT_RECORD_CSV.$file_data['file_name'];
            //echo $this->csvimport->get_array($file_path)."-----";die();
            if ($this->csvimport->get_array($file_path)) 
            {
                $csv_array = $this->csvimport->get_array($file_path);
                /*echo "<pre>";
                print_r($csv_array);
                die();*/
                $except_res_brand_arr = array();

                foreach ($csv_array['data'] as $row) 
                {
                    $brand                                          = $row['brand'];
                    $brand_slug                                     = $this->slug->create_slug($brand);
                    $sku                                            = $row['sku'];
                    $product_id                                     = $row['product-id'];
                    $product_id_type                                = $row['product-id-type'];
                    $price                                          = $row['price'];
                    $minimum_seller_allowed_price                   = $row['minimum-seller-allowed-price'];
                    $maximum_seller_allowed_price                   = $row['maximum-seller-allowed-price'];
                    $item_condition                                 = $row['item-condition'];
                    $quantity                                       = $row['quantity'];
                    $add_delete                                     = $row['add-delete'];
                    $will_ship_internationally                      = $row['will-ship-internationally'];
                    $expedited_shipping                             = $row['expedited-shipping'];
                    $standard_plus                                  = $row['standard-plus'];
                    $item_note                                      = $row['item-note'];
                    $fulfillment_center_id                          = $row['fulfillment-center-id'];
                    $product_tax_code                               = $row['product-tax-code'];
                    $handling_time                                  = $row['handling-time'];
                    $merchant_shipping_group_name                   = $row['merchant_shipping_group_name'];
                    $batteries_required                             = $row['batteries_required'];
                    $are_batteries_included                         = $row['are_batteries_included'];
                    $battery_cell_composition                       = $row['battery_cell_composition'];
                    $battery_type                                   = $row['battery_type'];
                    $number_of_batteries                            = $row['number_of_batteries'];
                    $battery_weight                                 = $row['battery_weight'];
                    $number_of_lithium_ion_cells                    = $row['number_of_lithium_ion_cells'];
                    $number_of_lithium_metal_cells                  = $row['number_of_lithium_metal_cells'];
                    $lithium_battery_packaging                      = $row['lithium_battery_packaging'];
                    $lithium_battery_energy_content                 = $row['lithium_battery_energy_content'];
                    $lithium_battery_weight                         = $row['lithium_battery_weight'];
                    $hazmat_united_nations_regulatory_id            = $row['hazmat_united_nations_regulatory_id'];
                    $safety_data_sheet_url                          = $row['safety_data_sheet_url'];
                    $item_weight                                    = $row['item_weight'];
                    $item_volume                                    = $row['item_volume'];
                    $flash_point                                    = $row['flash_point'];
                    $ghs_classification_class1                      = $row['ghs_classification_class1'];
                    $ghs_classification_class2                      = $row['ghs_classification_class2'];
                    $ghs_classification_class3                      = $row['ghs_classification_class3'];
                    $item_weight_unit_of_measure                    = $row['item_weight_unit_of_measure'];
                    $item_volume_unit_of_measure                    = $row['item_volume_unit_of_measure'];
                    $lithium_battery_energy_content_unit_of_measure = $row['lithium_battery_energy_content_unit_of_measure'];
                    $lithium_battery_weight_unit_of_measure         = $row['lithium_battery_weight_unit_of_measure'];
                    $supplier_declared_dg_hz_regulation1            = $row['supplier_declared_dg_hz_regulation1'];
                    $supplier_declared_dg_hz_regulation2            = $row['supplier_declared_dg_hz_regulation2'];
                    $supplier_declared_dg_hz_regulation3            = $row['supplier_declared_dg_hz_regulation3'];
                    $supplier_declared_dg_hz_regulation4            = $row['supplier_declared_dg_hz_regulation4'];
                    $supplier_declared_dg_hz_regulation5            = $row['supplier_declared_dg_hz_regulation5'];
                    $battery_weight_unit_of_measure                 = $row['battery_weight_unit_of_measure'];
                    $california_proposition_65_compliance_type      = $row['california_proposition_65_compliance_type'];
                    $california_proposition_65_chemical_names1      = $row['california_proposition_65_chemical_names1'];
                    $california_proposition_65_chemical_names2      = $row['california_proposition_65_chemical_names2'];
                    $california_proposition_65_chemical_names3      = $row['california_proposition_65_chemical_names3'];
                    $california_proposition_65_chemical_names4      = $row['california_proposition_65_chemical_names4'];
                    $california_proposition_65_chemical_names5      = $row['california_proposition_65_chemical_names5'];

                    $user_id = $this->session->userdata('userId');

                    if($minimum_seller_allowed_price == "" || $maximum_seller_allowed_price == "")
                    {
                        $this->session->set_flashdata('error', 'Please add minimum_seller_allowed_price and maximum_seller_allowed_price column details in csv record.');
                        redirect(ADMIN.'manage-product');
                    }

                    if($sku == '')
                    {
                        $this->session->set_flashdata('error', 'Please add sku column details in csv record.');
                        redirect(ADMIN.'manage-product');
                    }

                    if($fulfillment_center_id == 'AMAZON_NA')
                    {
                        if($batteries_required == '')
                        {
                            $this->session->set_flashdata('error', 'Please add batteries_required column details in csv record.');
                            redirect(ADMIN.'manage-product');
                        }
                    }

                    if($batteries_required == 'TRUE')
                    {
                        if($are_batteries_included == "")
                        {
                            $this->session->set_flashdata('error', 'Please add are_batteries_included column details in csv record.');
                            redirect(ADMIN.'manage-product');
                        }
                    }

                    if($are_batteries_included == 'TRUE')
                    {
                        if($battery_cell_composition == "")
                        {
                            $this->session->set_flashdata('error', 'Please add battery_cell_composition column details in csv record.');
                            redirect(ADMIN.'manage-product');
                        }
                    }

                    if($battery_cell_composition == "Lithium Variants")
                    {
                        if($battery_type == "")
                        {
                            $this->session->set_flashdata('error', 'Please add battery_type column details in csv record.');
                            redirect(ADMIN.'manage-product');
                        }

                        if($number_of_batteries == "")
                        {
                            $this->session->set_flashdata('error', 'Please add number_of_batteries column details in csv record.');
                            redirect(ADMIN.'manage-product');
                        }

                        if($battery_weight == "")
                        {
                            $this->session->set_flashdata('error', 'Please add battery_weight column details in csv record.');
                            redirect(ADMIN.'manage-product');
                        }

                        if($number_of_lithium_ion_cells == "")
                        {
                            $this->session->set_flashdata('error', 'Please add number_of_lithium_ion_cells column details in csv record.');
                            redirect(ADMIN.'manage-product');
                        }

                        if($number_of_lithium_metal_cells == "")
                        {
                            $this->session->set_flashdata('error', 'Please add number_of_lithium_metal_cells column details in csv record.');
                            redirect(ADMIN.'manage-product');
                        }

                        if($lithium_battery_packaging == "")
                        {
                            $this->session->set_flashdata('error', 'Please add lithium_battery_packaging column details in csv record.');
                            redirect(ADMIN.'manage-product');
                        }
                    }

                    if($battery_cell_composition == "Lithium Ion Variants")
                    {
                        if($lithium_battery_energy_content == "")
                        {
                            $this->session->set_flashdata('error', 'Please add lithium_battery_energy_content column details in csv record.');
                            redirect(ADMIN.'manage-product');
                        }
                    }

                    if($battery_cell_composition == "Lithium Metal Variants")
                    {
                        if($lithium_battery_weight == "")
                        {
                            $this->session->set_flashdata('error', 'Please add lithium_battery_weight column details in csv record.');
                            redirect(ADMIN.'manage-product');
                        }
                    }

                    if($supplier_declared_dg_hz_regulation1 == "transportation" || $supplier_declared_dg_hz_regulation2 == "transportation" || $supplier_declared_dg_hz_regulation3 == "transportation" || $supplier_declared_dg_hz_regulation4 == "transportation" || $supplier_declared_dg_hz_regulation5 == "transportation")
                    {
                        if($hazmat_united_nations_regulatory_id == "")
                        {
                            $this->session->set_flashdata('error', 'Please add hazmat_united_nations_regulatory_id column details in csv record.');
                            redirect(ADMIN.'manage-product');
                        }
                    }

                    if($supplier_declared_dg_hz_regulation1 == "ghs" || $supplier_declared_dg_hz_regulation2 == "ghs" || $supplier_declared_dg_hz_regulation3 == "ghs" || $supplier_declared_dg_hz_regulation4 == "ghs" || $supplier_declared_dg_hz_regulation5 == "ghs")
                    {
                        if($safety_data_sheet_url == "")
                        {
                            $this->session->set_flashdata('error', 'Please add safety_data_sheet_url column details in csv record.');
                            redirect(ADMIN.'manage-product');
                        }
                    }

                    if($supplier_declared_dg_hz_regulation1 == "IN" || $supplier_declared_dg_hz_regulation2 == "IN" || $supplier_declared_dg_hz_regulation3 == "IN" || $supplier_declared_dg_hz_regulation4 == "IN" || $supplier_declared_dg_hz_regulation5 == "IN")
                    {
                        if($item_weight == "")
                        {
                            $this->session->set_flashdata('error', 'Please add item_weight column details in csv record.');
                            redirect(ADMIN.'manage-product');
                        }
                    }

                    if($supplier_declared_dg_hz_regulation1 == "ghs" || $supplier_declared_dg_hz_regulation2 == "ghs" || $supplier_declared_dg_hz_regulation3 == "ghs" || $supplier_declared_dg_hz_regulation4 == "ghs" || $supplier_declared_dg_hz_regulation5 == "ghs")
                    {
                        if($ghs_classification_class1 == "" )
                        {
                            $this->session->set_flashdata('error', 'Please add ghs_classification_class1 column details in csv record.');
                            redirect(ADMIN.'manage-product');
                        }
                        if($ghs_classification_class2 == "" )
                        {
                            $this->session->set_flashdata('error', 'Please add ghs_classification_class2 column details in csv record.');
                            redirect(ADMIN.'manage-product');
                        }
                        if($ghs_classification_class3 == "" )
                        {
                            $this->session->set_flashdata('error', 'Please add ghs_classification_class3 column details in csv record.');
                            redirect(ADMIN.'manage-product');
                        }
                    }

                    if (strpos($california_proposition_65_compliance_type, 'food') !== false || strpos($california_proposition_65_compliance_type, 'furniture') !== false || strpos($california_proposition_65_compliance_type, 'chemical') !== false) 
                    {
                        if($california_proposition_65_chemical_names1 == "")
                        {
                            $this->session->set_flashdata('error', 'Please add california_proposition_65_chemical_names1 column details in csv record.');
                            redirect(ADMIN.'manage-product');
                        }

                        if($california_proposition_65_chemical_names2 == "")
                        {
                            $this->session->set_flashdata('error', 'Please add california_proposition_65_chemical_names2 column details in csv record.');
                            redirect(ADMIN.'manage-product');
                        }

                        if($california_proposition_65_chemical_names3 == "")
                        {
                            $this->session->set_flashdata('error', 'Please add california_proposition_65_chemical_names3 column details in csv record.');
                            redirect(ADMIN.'manage-product');
                        }

                        if($california_proposition_65_chemical_names4 == "")
                        {
                            $this->session->set_flashdata('error', 'Please add california_proposition_65_chemical_names4 column details in csv record.');
                            redirect(ADMIN.'manage-product');
                        }

                        if($california_proposition_65_chemical_names5 == "")
                        {
                            $this->session->set_flashdata('error', 'Please add california_proposition_65_chemical_names5 column details in csv record.');
                            redirect(ADMIN.'manage-product');
                        }
                    }

                    $check_duplicate = $this->crud->check_duplicate('brand_restricted',array('slug'=>$brand_slug,'isDelete'=>0));
                    if($check_duplicate)
                    {
                        
                    }
                    else
                    {
                        $amazon_fees = (0.15 * $maximum_seller_allowed_price);
                        $price_diff =  ($maximum_seller_allowed_price - $minimum_seller_allowed_price);
                        $cal_profit =  ($price_diff - $amazon_fees);

                        if($cal_profit > 0)
                        {
                            $except_res_brand_arr[] = $row;
                        }
                    }

                    $insert_data = array(
                        'added_by'                                      => 1,
                        'userId'                                        => $user_id,
                        'brand'                                         => $brand,
                        'sku'                                           => $sku,
                        'product-id'                                    => $product_id,
                        'product-id-type'                               => $product_id_type,
                        'price'                                         => $price,
                        'minimum-seller-allowed-price'                  => $minimum_seller_allowed_price,
                        'maximum-seller-allowed-price'                  => $maximum_seller_allowed_price,
                        'item-condition'                                => $item_condition,
                        'quantity'                                      => $quantity,
                        'add-delete'                                    => $add_delete,
                        'will-ship-internationally'                     => $will_ship_internationally,
                        'expedited-shipping'                            => $expedited_shipping,
                        'standard-plus'                                 => $standard_plus,
                        'item-note'                                     => $item_note,
                        'fulfillment-center-id'                         => $fulfillment_center_id,
                        'product-tax-code'                              => $product_tax_code,                       
                        'handling-time'                                 => $handling_time,                                     
                        'merchant_shipping_group_name'                  => $merchant_shipping_group_name,                   
                        'batteries_required'                            => $batteries_required,                             
                        'are_batteries_included'                        => $are_batteries_included,                         
                        'battery_cell_composition'                      => $battery_cell_composition,                       
                        'battery_type'                                  => $battery_type,                                   
                        'number_of_batteries'                           => $number_of_batteries,                            
                        'battery_weight'                                => $battery_weight,                                 
                        'number_of_lithium_ion_cells'                   => $number_of_lithium_ion_cells,                    
                        'number_of_lithium_metal_cells'                 => $number_of_lithium_metal_cells,                  
                        'lithium_battery_packaging'                     => $lithium_battery_packaging,                      
                        'lithium_battery_energy_content'                => $lithium_battery_energy_content,                 
                        'lithium_battery_weight'                        => $lithium_battery_weight,                         
                        'hazmat_united_nations_regulatory_id'           => $hazmat_united_nations_regulatory_id,            
                        'safety_data_sheet_url'                         => $safety_data_sheet_url,                          
                        'item_weight'                                   => $item_weight,                                    
                        'item_volume'                                   => $item_volume,                                    
                        'flash_point'                                   => $flash_point,                                    
                        'ghs_classification_class1'                     => $ghs_classification_class1,                      
                        'ghs_classification_class2'                     => $ghs_classification_class2,                      
                        'ghs_classification_class3'                     => $ghs_classification_class3,                      
                        'item_weight_unit_of_measure'                   => $item_weight_unit_of_measure,                    
                        'item_volume_unit_of_measure'                   => $item_volume_unit_of_measure,                    
                        'lithium_battery_energy_content_unit_of_measure' => $lithium_battery_energy_content_unit_of_measure, 
                        'lithium_battery_weight_unit_of_measure'        => $lithium_battery_weight_unit_of_measure,         
                        'supplier_declared_dg_hz_regulation1'           => $supplier_declared_dg_hz_regulation1,            
                        'supplier_declared_dg_hz_regulation2'           => $supplier_declared_dg_hz_regulation2,            
                        'supplier_declared_dg_hz_regulation3'           => $supplier_declared_dg_hz_regulation3,            
                        'supplier_declared_dg_hz_regulation4'           => $supplier_declared_dg_hz_regulation4,            
                        'supplier_declared_dg_hz_regulation5'           => $supplier_declared_dg_hz_regulation5,            
                        'battery_weight_unit_of_measure'                => $battery_weight_unit_of_measure,                 
                        'california_proposition_65_compliance_type'     => $california_proposition_65_compliance_type,      
                        'california_proposition_65_chemical_names1'     => $california_proposition_65_chemical_names1,      
                        'california_proposition_65_chemical_names2'     => $california_proposition_65_chemical_names2,      
                        'california_proposition_65_chemical_names3'     => $california_proposition_65_chemical_names3,      
                        'california_proposition_65_chemical_names4'     => $california_proposition_65_chemical_names4,      
                        'california_proposition_65_chemical_names5'     => $california_proposition_65_chemical_names5,
                        'status'                                        =>  'Y',
                        'is_from_csv'                                   =>  '1',
                    );

                    $result = $this->crud->insert($this->table,$insert_data);
                }
                //echo "<pre>"; print_r($except_res_brand_arr);die();
                
                $filename = 'users_'.$user_id."_".date('Ymd').'.csv'; 
                header("Content-type: application/csv");
                header("Content-Disposition: attachment; filename=$filename");
                header("Pragma: no-cache");
                header("Expires: 0");

                //$file = fopen('php://output', 'w');
                $file = fopen(UPLOAD_DIR.PRODUCT_RECORD_CSV.$filename, 'wb');
 
                $header = $csv_array['column_headers'];
                fputcsv($file, $header);
                foreach ($except_res_brand_arr as $key=>$line)
                { 
                    fputcsv($file,$line); 
                }
                fclose($file); 
                //exit();

                $url = base_url().UPLOAD_DIR.PRODUCT_RECORD_CSV.$filename;

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

                $login_user_details         = $this->crud->get_row_by_id("tbl_users",array('id'=>$user_id,'isDeleted'=>0));
                $mail_data['fname']         = $login_user_details['fname'];
                $mail_data['url']           = $url;

                $message = $this->load->view('mail_template/generated_csv_mail_template', $mail_data, TRUE);

                $mailbody['ToEmail']        = $login_user_details['email'];
                $mailbody['FromName']       = $general_setting->site_name;
                $mailbody['FromEmail']      = $general_setting->site_from_email;
                $mailbody['Subject']        = $general_setting->site_name." - CSV generated except restricted brand product details";
                $mailbody['Message']        = $message;
                $mailbody['attach_file']    = UPLOAD_DIR.PRODUCT_RECORD_CSV.$filename;
    
                $mail_result = $this->EmailSend($mailbody);

                $this->session->set_flashdata('success', 'New csv generated successfully. <a target="_blank" href="'.base_url().UPLOAD_DIR.PRODUCT_RECORD_CSV.$filename.'"> ( Click here to download ) </a>');
                redirect(ADMIN.'manage-product');

                /*if($result > 0)
                {
                    $this->session->set_flashdata('success', 'Csv Data Inserted successfully');
                    redirect(ADMIN.'manage-product');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Something went wrong');
                    redirect(ADMIN.'manage-product');
                }*/
            } 
            else 
            {
                $this->session->set_flashdata('error', 'Error occured');
                redirect(ADMIN.'manage-product');
            }
            
        }
    }

    function brand_restricted()
    {
        $this->global['pageTitle'] = '  : Brand Restricted';
        $this->loadViews(ADMIN."brand_restricted", $this->global, NULL, NULL);
    }

    function ajax_datatable_brand_restricted()
    {
        $tblId      = "id";
        $tblName    = "brand_restricted";
        $tablename  = base64_encode($tblName);
        $tableId    = base64_encode($tblId);

        $config['select'] = $tblName.'.*';
        $config['table'] = $tblName;
        $config['column_order'] = array($tblName.'.name');
        $config['column_search'] = array($tblName.'.name');         
        $config['order'] = array($tblId => 'desc');
        $config['custom_where'] = array('isDelete'=>0);
        $this->load->library('datatables', $config, 'datatable');
        $records = $this->datatable->get_datatables();
        $data = array();
        
        foreach ($records as $record) {
          
            $action = '<div class="d-flex">';
            $action .= '<a href="javascript:void(0);" class="mr-2 rowEdit" data-id="'.$record->$tblId.'" data-td="'.$tablename.'" data-i="'.$tableId.'"> <i class="far fa-edit"></i> </a> ';

            $action .= '<a href="javascript:void(0);" class="rowDelete" data-id="'.$record->$tblId.'" data-td="'.$tablename.'" data-i="'.$tableId.'"> <i class="far fa-trash-alt"></i> </a> ';
            $action .= '</div>';
            
            $ischecked = $record->status == 'Y' ? 'checked="checked"' : '';
            $status = $record->status == 'N' ? 'N' : 'Y';
            

            $row = array();
            $row[] = $record->name;
            $row[] = '<div class="form-group d-flex align-items-center mb-0">
                        <div class="switch m-r-10">
                            <input type="checkbox" class="changeStatus" data-id="'.$record->$tblId.'" data-status="'.$status.'" data-td="'.$tablename.'" data-i="'.$tableId.'" id="switch'.$record->$tblId.'" name="isActive" '.$ischecked.'>
                            <label for="switch'.$record->$tblId.'"></label>
                        </div>
                    </div>';
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


    function export_excel()
    {
        $posts = $this->crud->get_all_with_where("brand_restricted","name","asc",array("isDelete" => 0));

        // create file name
        $fileName = 'data-'.time().'.xlsx';  
        // load excel library
        $this->load->library('excel');

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Brand Name');
     
        // set Row
        $rowCount = 2;
        $total_purchase_cost = 0;
        $total_profit = 0;
        $total_buyer_paid = 0;
        foreach ($posts as $post) 
        {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $post->name);
            $rowCount++;
        }

        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

        //header("Content-Type: application/vnd.ms-excel");

        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment; filename=".$fileName);
        header("Cache-Control: max-age=0");
        $objWriter->save("php://output");

        redirect(ADMIN.'manage-brand-restricted');
    }

    function export_pdf()
    {
        error_reporting(E_ERROR | E_PARSE);
        require_once('application/libraries/vendor/autoload.php');

        
        $posts = $this->crud->get_all_with_where("brand_restricted","name","asc",array("isDelete" => 0));

        $html = '<!DOCTYPE html>
                <html lang="en">
                    <head>
                    <meta charset="utf-8">
                    <title>Amazon Order Report</title>
                    <style>
                        body {
                            margin: 0 auto; 
                            color: #001028;
                            background: #FFFFFF; 
                            font-family: Arial, sans-serif; 
                            font-size: 12px; 
                        }
                        
                        table {
                            width: 100%;
                            border-collapse: collapse;
                            border-spacing: 0;
                        }

                        table tr:nth-child(2n-1) td {
                            background: #F5F5F5;
                        }

                        table th,
                        table td {
                            text-align: center;
                        }

                        table th {
                            padding: 10px 20px;
                            color: #5D6975;
                            white-space: nowrap;        
                            font-weight: normal;
                        }

                        table td {
                            padding: 15px;
                            text-align: center;
                        }
                    </style>
                    </head>
                    <body>
                        <main>
                            <table style="border: 1px solid #C1CED9;">
                                <thead>
                                    <tr style="border: 1px solid #C1CED9;">
                                        <th>Brand Name</th>
                                    </tr>
                                </thead>
                                <tbody>';

                                $total_purchase_cost = 0;
                                $total_profit = 0;
                                $total_buyer_paid = 0;
                                if(!empty($posts))
                                { 
                                    foreach($posts as $post){
                                        $html.='<tr style="border: 1px solid #C1CED9;">
                                                    <td>'.$post->name.'</td>
                                                </tr>';

                                    }
                                }
                                else
                                {
                                    $html.='<tr>
                                                <td colspan="15">
                                                    There are currently Brand Added.
                                                </td>
                                            </tr>';
                                }
                            $html.='</tbody>
                            </table>
                        </main>
                    </body>
                </html>';

        //echo $html;die();
        $mpdf = new mPDF();
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($html);
        $pdf_name = "Brand Restricted".".pdf";
        $mpdf->Output($pdf_name, 'D');
        exit;
        //redirect(ADMIN.'manage-amazon-order');
    }
}
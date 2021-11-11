<?php

class SiteSetting_model extends CI_Model 
{
    function __construct() {
        parent::__construct(); 
        
    }

     function storeSiteSetting($settingInfo)
    {
       
        $id = 1;
        $this->db->where('id', $id);
        $this->db->update('site_settings', $settingInfo);        
        return TRUE;
    }

    function getSiteSetting(){
        $id = 1;
        $this->db->select('*');
        $this->db->from('site_settings');
        $this->db->where('id', $id);
        $query = $this->db->get();
        // echo '<pre>'; print_r($query->result()); echo '</pre>'; exit;    
        return  $query->result();
    }

}
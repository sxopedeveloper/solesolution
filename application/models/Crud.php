<?php

/**
 * Class Crud
 * &@property CI_DB_active_record $db
 */
class Crud extends CI_Model
{
	function __construct() {
		parent::__construct();
        $this->load->database();
	}

	/**
	 * @param $table_name
	 * @param $data_array
	 * @return bool
	 */
	function insert($table_name,$data_array) {
		if($this->db->insert($table_name,$data_array))
		{
			return $this->db->insert_id();
		}
		return false;
	}

	function insertFromSql($sql) {
		$this->db->query($sql);
		return $this->db->insert_id();
	}

	function execuetSQL($sql) {
		$this->db->query($sql);
	}
    
	function getFromSQL($sql) {
		return $this->db->query($sql)->result();
	}

	/**
	 * @param $table_name
	 * @param $order_by_column
	 * @param $order_by_value
	 * @return bool
	 */
	function get_all_records($table_name,$order_by_column,$order_by_value) {
		$this->db->select("*");
		$this->db->from($table_name);
		$this->db->order_by($order_by_column,$order_by_value);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}else{
			return false;
		}
	}

	/**
	 * @param $table_name
	 * @param $order_by_column
	 * @param $order_by_value
	 * @param $where_array
	 * @return bool
	 */
	function get_all_with_where($table_name,$order_by_column,$order_by_value,$where_array) {
		$this->db->select("*");
		$this->db->from($table_name);
		$this->db->where($where_array);
		$this->db->order_by($order_by_column,$order_by_value);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}else{
			return false;
		}
	}

	/**
	 * @param $table_name
	 * @param array $where
	 * @return mixed
	 */
	function get_record_with_where_limit($table_name,$where = array(),$limit='') {
		if (!empty($where)) {
			$this->db->where($where);
		}
		if (!empty($limit)) {
			$this->db->limit($limit);
		}
		$query = $this->db->get($table_name);
		
		return $query->result_array();
	}

	function get_num_rows_with_where($table_name,$where = array()) {
		if (!empty($where)) {
			$this->db->where($where);
		}
		$query = $this->db->get($table_name);
		return $query->num_rows();
	}

	/**
	 * @param $tbl_name
	 * @param $column_name
	 * @param $where_id
	 * @return mixed
	 */
	function get_column_value_by_id($tbl_name,$column_name,$where_id) {				
		$this->db->select("*");
		$this->db->from($tbl_name);
		$this->db->where($where_id);		
		$this->db->last_query();
		$query = $this->db->get();
		return $query->row($column_name);
	}

	/**
	 * @param $tbl_name
	 * @param $column_name
	 * @param $where_id
	 * @return mixed
	 */
	function get_column_value($tbl_name,$column_name,$where_id) {				
		$this->db->select($column_name);
		$this->db->from($tbl_name);
		$this->db->where($where_id);		
		$this->db->last_query();
		$query = $this->db->get();
		return $query->row($column_name);
	}

	/**
	 * @param $table_name
	 * @param $where_id
	 * @return mixed
	 */
	function get_row_by_id($table_name,$where_id) {
		$this->db->select("*");
		$this->db->from($table_name);
		$this->db->where($where_id);
		$query = $this->db->get();
		return $query->row_array();
	}

	function check_duplicate($table_name,$where_array) {
		$this->db->select("*");
		$this->db->from($table_name);
		$this->db->where($where_array);
		$query = $this->db->get();
		if($query->num_rows() > 0) 
		{
			return true;
		} else {
			return false;
		}
	}
	
	function check_buyer_cancelled($table_name,$where_array) {
		$this->db->select("*");
		$this->db->from($table_name);
		$this->db->where($where_array);
		$query = $this->db->get();
		return $query->row_array();
	}

	/**
	 * @param $table_name
	 * @param $where_array
	 * @return mixed
	 */
	function delete($table_name,$where_array) {		
		$result = $this->db->delete($table_name,$where_array);
		return $result;
	}

	/**
	 * @param $table_name
	 * @param $data_array
	 * @param $where_array
	 * @return mixed
	 */
	function update($table_name,$data_array,$where_array) {
		$this->db->where($where_array);
		$rs = $this->db->update($table_name, $data_array);
		return $rs;
	}

	/**
	 * @return string
	 */
	function get_state() {
		if(isset($_POST['country_id'])) {

			$countryID =  $_POST['country_id'];
			$where = array('country_id'=>$countryID);
			$result = $this->get_all_with_where('state','state_id','ASC',$where);
			$option = '<option value="">Select State</option>';

			if($result)
			{
				foreach ($result as $row) {
					$state_id = $row->state_id;
					$state = $row->state;
					$option .= '<option value="'.$state_id.'">'.$state.'</option>';
				}
			}
			return $option;
		}
	}


	function upload_multi_files($path, $img_slug, $files)
    {
    	$config = array(
            'upload_path'   => $path,
            'allowed_types' => 'jpg|png|jpeg',
            'overwrite'     => 1,                       
        );

        $this->load->library('upload', $config);

        $images = array();
       
        foreach ($files['name'] as $key => $image) 
        {
            $_FILES['images[]']['name']= $files['name'][$key];
            $_FILES['images[]']['type']= $files['type'][$key];
            $_FILES['images[]']['tmp_name']= $files['tmp_name'][$key];
            $_FILES['images[]']['error']= $files['error'][$key];
            $_FILES['images[]']['size']= $files['size'][$key];

            $fileName = rand()."_".$img_slug .'_'. preg_replace('/\s+/', '_', $image);

            $images[] = $fileName;

            $config['file_name'] = $fileName;

            $this->upload->initialize($config);

            if ($this->upload->do_upload('images[]')) {
                $this->upload->data();
            } else {
                return false;
            }
        }

        return $images;
    }


	/**
	 * @param $name
	 * @param $path
	 * @return bool
	 */
	function upload_file($name, $path , $allowed_types="") {
		$config['upload_path'] = $path;

		if($allowed_types!="")
		{
			$config['allowed_types'] = $allowed_types;
		}
		else
		{
			$config['allowed_types'] = '*';
		}
		
		$this->upload->initialize($config);
		if($this->upload->do_upload($name))
		{
			$upload_data = $this->upload->data();
			return $upload_data['file_name'];
		}
		return false;
	}

	/**
	 * @param $table
	 * @param $column
	 * @param $search_value
	 * @param array $where
	 * @return mixed
	 */
	function getAutoCompleteData($table,$column,$search_value,$where = array())	{
		$this->db->select('*');
		$this->db->from($table);
		if(!empty($where)) {
			$this->db->where($where);
		}
		$this->db->like($column, $search_value);
		$query = $this->db->get();
		return $query->result();
	}

	/**
	 * @param $table
	 * @param $id_column
	 * @param $column
	 * @param $column_val
	 * @return null
	 */
	function get_id_by_val($table,$id_column,$column,$column_val) {
		$this->db->select($id_column);
		$this->db->from($table);
		$this->db->where($column,$column_val);
		$this->db->limit('1');
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			return $query->row()->$id_column;
		} else {
			return null;
		}
	}

	function limit_words($string, $word_limit=30) {
		$words = explode(" ",$string);
		return implode(" ", array_splice($words, 0, $word_limit));
	}
	
	function limit_character($string, $character_limit=30) 
	{
		if (strlen($string) > $character_limit) {
			return substr($string, 0, $character_limit).'...';
		}else{
			return $string;
		}
	}
	
	//select data 
	function get_select_data($tbl_name)	{
		$this->db->select("*");
		$this->db->from($tbl_name);
		$query = $this->db->get();
		return $query->result();
	}

	/**
	 * @param $tbl_name
	 * @param $where
	 * @param $where_id
	 * @return mixed
	 */
	function get_data_row_by_id($tbl_name,$where,$where_id)	{
		$this->db->select("*");
		$this->db->from($tbl_name);
		$this->db->where($where,$where_id);
		$query = $this->db->get();
		return $query->row();
	}

	public function get_one_value($table,$wh = array(),$colname)
	{
		$this->db->select($colname);
		$this->db->from($table);
		if(!empty($wh) || count($wh) > 0)
			$this->db->where($wh);
		$res = $this->db->get();
		$type = $res->row_array();
		return !empty($type)?$type[$colname]:false;
	}

	public function get_one_row($table,$wh = array() )
	{
		$this->db->select("*");
		$this->db->from($table);
		if(count($wh) > 0 || $wh != '')
		$this->db->where($wh);
	 	$query = $this->db->get();
 		$results = $query->result_array();
 		return !empty($results)?$results[0]:false;
	}

    
	function get_result_where_array($tbl_name,$where_array ){
		$this->db->select("*");
		$this->db->from($tbl_name);
		$this->db->where($where_array);
		$query = $this->db->get();
		return $query->result();
	}

	function get_result_where($tbl_name,$where,$where_id) {
		$this->db->select("*");
		$this->db->from($tbl_name);
		$this->db->where($where,$where_id);
		$query = $this->db->get();
		return $query->result();
	}
	
	function getTimeZone() {
		$this->db->select('id, name, description, gmt, CONCAT_WS(" ", gmt,description) AS timezone', FALSE);
		$this->db->from('timezone');
		$this->db->where('status', 1);
		$this->db->where('isDelete', 0);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_join($join,$wh = array(),$params=array()) {
		
		if(array_key_exists("select",$join)){
			$this->db->select($join['select']);
        } else {
        	$this->db->select('*');	
        }

        $this->db->from($join['table']);

        if(isset($join['joins']))
        {
        	foreach ($join['joins'] as $key => $value) 
        	{
	        	$join_table = $value['join_table'];
	        	$join_by = $value['join_by'];
	        	$join_type = $value['join_type'];

	        	$this->db->join($join_table,$join_by,$join_type);
	        	
	        }
        }

        if(array_key_exists("ShortBy",$params) && array_key_exists("ShortOrder",$params)){
			$this->db->order_by($params['ShortBy'],$params['ShortOrder']);
        }
        if(array_key_exists("Limit",$params)){
			$this->db->limit($params['Limit'],$params['start']);
        }
        if(array_key_exists("Search",$params)){
        	$this->db->like($params['field'],$params['Search']);
        }

        if(array_key_exists("GroupBy",$params)){
        	$this->db->group_by($params['GroupBy']);
    	}

        if(array_key_exists("in_field",$params)){
			$this->db->where_in($params['in_field'],$params['in_value']);
        }

		
        if(isset($params['like']) && !empty($params['like'])){
            $this->db->group_start();
            $this->db->or_like($params['like']);
            $this->db->group_end();
        }
        

		if(count($wh) > 0 && $wh != '')
			$this->db->where($wh);
		$res = $this->db->get();
		$res = $res->result_array();
		return !empty($res)?$res:array();
	}

	public function get_join_row($join,$wh = array(),$params=array()) {
		
		if(array_key_exists("select",$join)){
			$this->db->select($join['select']);
        } else {
        	$this->db->select('*');	
        }

        $this->db->from($join['table']);

        if(isset($join['joins']))
        {
        	foreach ($join['joins'] as $key => $value) 
        	{
	        	$join_table = $value['join_table'];
	        	$join_by = $value['join_by'];
	        	$join_type = $value['join_type'];

	        	$this->db->join($join_table,$join_by,$join_type);
	        	
	        }
        }

        if(array_key_exists("ShortBy",$params) && array_key_exists("ShortOrder",$params)){
			$this->db->order_by($params['ShortBy'],$params['ShortOrder']);
        }
        if(array_key_exists("Limit",$params)){
			$this->db->limit($params['Limit'],$params['start']);
        }
        if(array_key_exists("Search",$params)){
        	$this->db->like($params['field'],$params['Search']);
        }

        if(array_key_exists("GroupBy",$params)){
        	$this->db->group_by($params['GroupBy']);
    	}

        if(array_key_exists("in_field",$params)){
			$this->db->where_in($params['in_field'],$params['in_value']);
        }

        if(isset($params['like']) && !empty($params['like'])){
            $this->db->or_like($params['like']);
        }
		if(count($wh) > 0 && $wh != '')
			$this->db->where($wh);
		$res = $this->db->get();
		return $res = $res->row_array();
		 // !empty($res)?$res:array();
	}


	public function get_data($tbl,$wh = array(),$params = array())
	{
		if(array_key_exists("Select",$params)){
			$this->db->select($params['Select']);
        } else {
        	$this->db->select('*');	
        }
        
        $this->db->from($tbl);
        if(array_key_exists("ShortBy",$params) && array_key_exists("ShortOrder",$params)){
			$this->db->order_by($params['ShortBy'],$params['ShortOrder']);
        }
        if(array_key_exists("Limit",$params)){
			$this->db->limit($params['Limit'],$params['start']);
        }
        if(array_key_exists("Search",$params)){
        	$this->db->like($params['field'],$params['Search']);
        }

        if(array_key_exists("GroupBy",$params)){
        	$this->db->group_by($params['GroupBy']);
    	}

        if(array_key_exists("in_field",$params)){
			$this->db->where_in($params['in_field'],$params['in_value']);
        }

        if(isset($params['like']) && !empty($params['like'])){
            $this->db->or_like($params['like']);
        }
		if(count($wh) > 0 && $wh != '')
			$this->db->where($wh);
		$res = $this->db->get();
		$res = $res->result_array();
		return !empty($res)?$res:array();
	}

	public function get_sum($table,$colum,$wh){
    	$this->db->select_sum($colum);
    	$this->db->from($table);
    	$this->db->where($wh);
    	$sum = $this->db->get()->result_array();
    	$sum = $sum[0][$colum];
    	if($sum > 0) {
    		return $sum;
    	} else {
    		return 0;
    	}
    }
    public function total_record($table,$wh) {
    	$this->db->select("*");
    	$this->db->from($table);
    	$this->db->where($wh);
    	$res = $this->db->get()->result_array();
    	$count = count($res);
    	if($count > 0) {
    		return $count;
    	} else {
    		return 0;
    	}
    }

	public function upload_file_($field_name, $upload_path, $file_name, $allowed_types)
    {
    	$this->load->library('upload');
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, TRUE);
             @chmod($upload_path,0777);
        }
        $config['file_name'] = $file_name;
        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = $allowed_types;
        $config['overwrite'] = true;
        $config['remove_spaces'] = TRUE;
        $this->upload->initialize($config);

        $FileName = "";
        if ($this->upload->do_upload($field_name)) {
            $file = $this->upload->data();
            $FileName = $file['file_name'];
            chmod($file['full_path'],0777);
        } else {
            $error['error'] = $this->upload->display_errors();
            return $error;
        }
        return $FileName;
    }
    
    public function generateRandomString($length = 10) 
    {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}

	public function get_single_rating($rate_value) {
    	$wh = "type = '".$type."' AND pid='".$pid."' AND isDelete=0 AND status='Y' ";
    	$rating_sum = $this->get_sum("rating","rating",$wh);

    	$rating_count = $this->total_record("rating",$wh);
    	if($rating_sum > 0) {
    		$star = $rating_sum / $rating_count;
    	} else {
    		$star = 0;
    	}
    	?>
    	<span class="rating">
    		<?php
           	for ($i=0; $i < 5; $i++) 
           	{ 
           		$checked = ($rate_value>$i) ? 'icon_star' : 'icon_star empty';
       		?><i class="<?= $checked; ?>"></i>
       		<?php
           	}
           	?>
    		<i class="icon_star"></i>
    		<i class="icon_star"></i>
    		<i class="icon_star"></i>
    		<i class="icon_star"></i>
    		<i class="icon_star empty"></i>
    		<em>4.50/5.00</em>
    	</span>

    	<li class="tag-ctg">
           <div class="rating-list">
           		
           </div>
        </li>
        <?php
    }

    function fixJSON($json) {
        $newJSON = '';

        $jsonLength = strlen($json);
        for ($i = 0; $i < $jsonLength; $i++) {
            if ($json[$i] == '"' || $json[$i] == "'") {
                $nextQuote = strpos($json, $json[$i], $i + 1);
                $quoteContent = substr($json, $i + 1, $nextQuote - $i - 1);
                $newJSON .= '"' . str_replace('"', "'", $quoteContent) . '"';
                $i = $nextQuote;
            } else {
                $newJSON .= $json[$i];
            }
        }

        /*var_dump($newJSON);
        var_dump(json_decode($newJSON));
        var_dump(json_last_error());
        var_dump(json_last_error_msg());
        die();*/
        
        return $newJSON;
    }

		function fixJSON1($json) {
			$patterns     = [];
    /** garbage removal */
   $patterns[0]  = "/([\s:,\{}\[\]])\s*'([^:,\{}\[\]]*)'\s*([\s:,\{}\[\]])/"; //Find any character except colons, commas, curly and square brackets surrounded or not by spaces preceded and followed by spaces, colons, commas, curly or square brackets...
    $patterns[1]  = '/([^\s:,\{}\[\]]*)\{([^\s:,\{}\[\]]*)/'; //Find any left curly brackets surrounded or not by one or more of any character except spaces, colons, commas, curly and square brackets...
   $patterns[2]  =  "/([^\s:,\{}\[\]]+)}/"; //Find any right curly brackets preceded by one or more of any character except spaces, colons, commas, curly and square brackets...
   $patterns[3]  = "/(}),\s*/"; //JSON.parse() doesn't allow trailing commas
    /** reformatting */
    $patterns[4]  = '/([^\s:,\{}\[\]]+\s*)*[^\s:,\{}\[\]]+/'; //Find or not one or more of any character except spaces, colons, commas, curly and square brackets followed by one or more of any character except spaces, colons, commas, curly and square brackets...
    $patterns[5]  = '/["\']+([^"\':,\{}\[\]]*)["\']+/'; //Find one or more of quotation marks or/and apostrophes surrounding any character except colons, commas, curly and square brackets...
    $patterns[6]  = '/(")([^\s:,\{}\[\]]+)(")(\s+([^\s:,\{}\[\]]+))/'; //Find or not one or more of any character except spaces, colons, commas, curly and square brackets surrounded by quotation marks followed by one or more spaces and  one or more of any character except spaces, colons, commas, curly and square brackets...
    $patterns[7]  = "/(')([^\s:,\{}\[\]]+)(')(\s+([^\s:,\{}\[\]]+))/"; //Find or not one or more of any character except spaces, colons, commas, curly and square brackets surrounded by apostrophes followed by one or more spaces and  one or more of any character except spaces, colons, commas, curly and square brackets...
    $patterns[8]  = '/(})(")/'; //Find any right curly brackets followed by quotation marks...
    $patterns[9]  = '/,\s+(})/'; //Find any comma followed by one or more spaces and a right curly bracket...
    $patterns[10] = '/\s+/'; //Find one or more spaces...
    $patterns[11] = '/^\s+/'; //Find one or more spaces at start of string...
  
    $replacements     = [];
    /** garbage removal */
    $replacements[0]  = '$1 "$2" $3'; //...and put quotation marks surrounded by spaces between them;
    $replacements[1]  = '$1 { $2'; //...and put spaces between them;
    $replacements[2]  = '$1 }'; //...and put a space between them;
    $replacements[3]  = '$1'; //...so, remove trailing commas of any right curly brackets;
    /** reformatting */
    $replacements[4]  = '"$0"'; //...and put quotation marks surrounding them;
    $replacements[5]  = '"$1"'; //...and replace by single quotation marks;
    $replacements[6]  = '\\$1$2\\$3$4'; //...and add back slashes to its quotation marks;
    $replacements[7]  = '\\$1$2\\$3$4'; //...and add back slashes to its apostrophes;
    $replacements[8]  = '$1, $2'; //...and put a comma followed by a space character between them;
    $replacements[9]  = ' $1'; //...and replace by a space followed by a right curly bracket;
    $replacements[10] = ' '; //...and replace by one space;
    $replacements[11] = ''; //...and remove it.
  
    $result = preg_replace($patterns, $replacements, $json);
		/*echo "<pre>";
		print_r($result); 
		echo "<br>";
		echo json_decode($result, true); */
    return $result;
		}
}

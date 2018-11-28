<?php

class CategoryModel{
	
	private $db ;
	private $table_name ;
	
	public function __construct(){
		global $wpdb;
		$this->db = $wpdb;
		$this->table_name = $wpdb -> prefix .'portal_category';
	}
	
	public function add_categories($data){
	$cat_name = $data['cat_name'];
	 if($this->all_categories($cat_name) == 0){
		 $status = $this->db->insert( $this->table_name, array( 'category_name' => $cat_name), array('%s') );
		 if($status == 1){
			$error['status'] = 1;
			$error['msg'] = "The category have been added successfully.";				 
		 }else{
			$error['status'] = 0;
			$error['msg'] = "Error while adding category. Please try again.";		 
		 }	
	 }else{
		$error['status'] = 0;
		$error['msg'] = "The category name already exists";		 
	 }
	 return $error;
	}
	
	public function all_categories($cat_name= null, $cat_id = null){
		if(isset($cat_name) && $cat_id == null){
			$cat_count = $this->db->get_results( "SELECT count(*) as cat_count FROM $this->table_name WHERE category_name = '$cat_name'")[0]->cat_count;
			return $cat_count; // return category count
		}elseif(isset($cat_name , $cat_id )){
			$cat_count = $this->db->get_results( "SELECT count(*) as cat_count FROM $this->table_name WHERE category_name = '$cat_name' AND category_id != $cat_id")[0]->cat_count;
			return $cat_count; // return category count except the current category
		}else{
			$fields = $this->db->get_results( "SELECT * FROM $this->table_name" );
			return $fields; // all values
		}
	}
	
	public function get_category_name($cat_id){
		$cat_name = $this->db->get_results( "SELECT category_name FROM $this->table_name WHERE category_id = $cat_id " )[0]->category_name;
		return $cat_name; 
	}
	
	public function update_categories($data, $cat_id){
		$cat_name = $data['cat_name'];
		$existing_cat_name = $this->get_category_name($cat_id);
		
		//check if the current data is same as the previous data
		if($cat_name == $existing_cat_name){
			$cat_name_status = 1;
		}else{
			$cat_name_status = 0;
		} 
		
		if($this->all_categories($cat_name,$cat_id) == 0){
			$status = $this->db->update( $this->table_name, array( 'category_name' => $cat_name),  array( 'category_id' => $cat_id), array('%s'), array('%d') );
				
			if($status == 1 || $cat_name_status == 1){
				$error['status'] = 1;
				$error['msg'] = "The category have been updated successfully.";				 
			}else{
				$error['status'] = 0;
				$error['msg'] = "Error while adding category. Please try again.";		 
			}	
		}else{
			$error['status'] = 0;
			$error['msg'] = "The category name already exists";		 
		}
		return $error;
	}

}
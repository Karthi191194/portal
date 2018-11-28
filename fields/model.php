<?php

class FieldsModel{
	
	private $db ;
	private $table_name ;
	
	public function __construct(){
		global $wpdb;
		$this->db = $wpdb;
		$this->table_name = $wpdb -> prefix .'portal_fields';
	}
	
	public function add_fields($data){
		
		$field_type = $data['type'];
		$field_label = $data['label'];
		$field_placeholder = $data['placeholder'];
		if(isset($data['required'])){
			$required = $data['required']; 
		}else{
			$required = 0;
		}
		if($field_type == "radio" || $field_type == "checkbox" || $field_type == "select"){	
			$field_options = $data['options'];
		}else{
			$field_options = "";
		}
				
		$status = $this->db->insert( $this->table_name, array( 'field_type' => $field_type, 'field_label' => $field_label, 'field_placeholder' => $field_placeholder, 'required' => $required,'field_options' => $field_options), array('%s','%s','%s','%d' ,'%s') );
		
		if($status == 1){
			$error['status'] = 1;
			$error['msg'] = "The field have been added successfully.";				 
		 }else{
			$error['status'] = 0;
			$error['msg'] = "Error while adding field. Please try again.";		 
		 }	
		
		return $error;			
	}
	
	public function all_fields($id = null, $label = null){
		if($id == 1 && $label == 1){
			$fields = $this->db->get_results( "SELECT field_id, field_label FROM $this->table_name" );
			return $fields; // return id and label values
		}else{
			$fields = $this->db->get_results( "SELECT * FROM $this->table_name" );
			return $fields; // all values
		}
	}
	
}
<?php

class FieldsModel{
	
	private $db ;
	private $table_name ;
	private $field_category_table_name ;
	
	public function __construct(){
		global $wpdb;
		$this->db = $wpdb;
		$this->table_name = $wpdb -> prefix .'portal_fields';
		$this->field_category_table_name = $wpdb->prefix . 'portal_field_category';
	}
	
	public function add_fields($data, $field_options){
		
		$field_type = $data['type'];
		$field_label = $data['label'];
		$field_placeholder = $data['placeholder'];

				
		$status = $this->db->insert( $this->table_name, array( 'field_type' => $field_type, 'field_label' => $field_label, 'field_placeholder' => $field_placeholder, 'field_options' => $field_options), array('%s','%s','%s' ,'%s') );
		
		if($status == 1 && !empty($data['categories'])){
			$insert_id = $this->db->insert_id;
			$values = array();
			$placeholders = array();
			
			$query = "INSERT INTO $this->field_category_table_name (field_id, category_id) VALUES ";
			
			foreach($data['categories'] as $category){
				array_push($values, $insert_id, $category);
				$placeholders[] = "('%d', '%d')";
			}
			$query .= implode(', ', $placeholders);
			
			$status  = $this->db->query( $this->db->prepare("$query ", $values));
						
		}
			$last_error = $this->db->last_error ;
		
		if(empty($last_error)){
			$error['status'] = 1;
			$error['msg'] = "The field have been added successfully.";				 
		 }else{
			$error['status'] = 0;
			$error['msg'] = "Error while adding field. Please try again.";		 
		 }	
		
		return $error;			
	}
	
	public function field($fieldid){
		$fields = $this->db->get_results("SELECT field.field_type, field.field_label, field.field_placeholder, field.field_options, category.category_id FROM $this->table_name AS field LEFT JOIN $this->field_category_table_name AS category ON field.field_id = category.field_id WHERE  field.field_id = $fieldid" );
		return $fields;
	}
	
	public function editfield($fieldid, $data, $field_options){
		$field_type = $data['type'];
		$field_label = $data['label'];
		$field_placeholder = $data['placeholder'];
		
		$status = $this->db->update( $this->table_name, array( 'field_type' => $field_type, 'field_label' => $field_label, 'field_placeholder' => $field_placeholder, 'field_options' => $field_options), array( 'field_id' => $fieldid ), array('%s','%s' ,'%s'), array( '%d' )  );
		$last_error = $this->db->last_error ;
		
		if(empty($last_error)){	
			$status = $this->db->query("DELETE FROM $this->field_category_table_name WHERE field_id IN ($fieldid) ");
			
			$last_error = $this->db->last_error ;

			if(empty($last_error)){
			if(!empty($data['categories'])){				
				$insert_id = $fieldid;
				$values = array();
				$placeholders = array();
				
				$query = "INSERT INTO $this->field_category_table_name (field_id, category_id) VALUES ";
				
				foreach($data['categories'] as $category){
					array_push($values, $insert_id, $category);
					$placeholders[] = "('%d', '%d')";
				}
				$query .= implode(', ', $placeholders);
				
				$status  = $this->db->query( $this->db->prepare("$query ", $values));
				$last_error = $this->db->last_error ;
					if(empty($last_error)){
						$error['status'] = 1;
						$error['msg'] = "The field have been updated successfully.";				 
					}else{
						$error['status'] = 0;
						$error['msg'] = "Error while updating field. Please try again.";		 
					}
			}else{
					$error['status'] = 1;
					$error['msg'] = "The field have been updated successfully.";
			}		
			}else{
				$error['status'] = 0;
				$error['msg'] = "Error while updating field. Please try again.";
			}			
		}else{
			$error['status'] = 0;
			$error['msg'] = "Error while updating field. Please try again.";
		}			
	return $error;
	}
	
	public function all_fields($id = null, $label = null){
		if($id == 1 && $label == 1){
			$fields = $this->db->get_results( "SELECT field_id, field_label FROM $this->table_name" );
			return $fields; // return id and label values
		}else{
			$fields = $this->db->get_results( "SELECT * FROM $this->table_name", ARRAY_A );
			return $fields; // all values
		}
	}
	
}
<?php

class FieldsController{
	
	private $model;
	
	public function __construct(){
		$this->model = new FieldsModel();
	}
	
	public function add_new(){
		if(isset($_POST['add'])){
			//var_dump($this->model);
			//echo "<pre>"; print_r($_POST); die;
			if($_POST['type'] == "checkbox"){
				$choices =  explode("|",$_POST["options"]);
				foreach($choices as $option){	
					if(strpos($option,":") != false){
						$options[] = explode(":", $option);
						$field_options = serialize($options);
					}else{
						$insert_status['status'] = 0;
					}	
				}
			}else{
				$field_options = "";
			}
			if(empty($insert_status)){
				$insert_status = $this->model->add_fields($_POST, $field_options);
			}else{
				$insert_status['status'] = 0;
				$insert_status['msg'] = "The Checkbox Options added doesn't match the predefined conditions. Please add the Options as per the instructions and map the categories again.";	
				$data = $_POST;
			}	
		}
		include(FILE_VIEW_ADD_FIELDS);
	}
	
	public function edit(){
		if(isset($_GET['action']) && $_GET['action'] == "edit"){
			$field_id = $_GET['field'];			
		}
		if(isset($_POST['update'])){
			//echo "<pre>"; print_r($_POST);
			if($_POST['type'] == "checkbox"){
				$choices =  explode("|",$_POST["options"]);
				foreach($choices as $option){	
					if(strpos($option,":") != false){
						$options[] = explode(":", $option);
						$field_options = serialize($options);
					}else{
						$update_status['status'] = 0;
						$field_options = "";
						$_POST["categories"] = array();
					}	
				}
			}else{
				$field_options = "";
			}
			if(empty($update_status)){
				$update_status = $this->model->editfield($field_id, $_POST, $field_options);
			}else{
				$update_status = $this->model->editfield($field_id, $_POST, $field_options);				
				$update_status['status'] = 0;
				$update_status['msg'] = "The Checkbox Options added doesn't match the predefined conditions. Please add the Options as per the instructions and map the categories again.";	
			}	
		}
		$field_data = $this->model->field($field_id);
		include(FILE_VIEW_EDIT_FIELDS);
	}
	
	public function list_all(){
		/*$fields = $this->model->all_fields();
		//echo "<pre>"; print_r($fields);
		if(isset($_GET['field']) && isset($_GET['action']) && $_GET['action'] == "delete"){
			die("delete...");
		}
		include(FILE_VIEW_LIST_FIELDS);*/
		
		include(FILE_VIEW_LIST_TABLE_FIELDS);
	}

}
?>
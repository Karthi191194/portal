<?php

class FieldsController{
	
	private $model;
	
	public function __construct(){
		$this->model = new FieldsModel();
	}
	
	public function add_new(){
		if(isset($_POST['add'])){
			//var_dump($this->model);
			//echo "<pre>"; print_r($_POST);
			$insert_status = $this->model->add_fields($_POST);
		}
		include(FILE_VIEW_ADD_FIELDS);
	}
	
	public function edit(){
		die("edit...");
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
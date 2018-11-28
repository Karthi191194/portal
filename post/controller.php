<?php

class PostController{
	
	private $fieldsmodel; 
	
	public function __construct(){
		$this->fieldsmodel = new FieldsModel();
	}
	
	public function add_new(){
		 $fields = $this->fieldsmodel->all_fields($id = 1, $label = 1);	
		 //echo "<pre>"; print_r($_POST);
		 include(FILE_VIEW_ADD_POST);
	}
}
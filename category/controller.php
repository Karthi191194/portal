<?php

class CategoryController{
	
	private $model;
	
	public function __construct(){
		$this->model = new CategoryModel();
	}
	
	public function add_new(){
		if(isset($_POST['add'])){
			$insert_status = $this->model->add_categories($_POST);
		}
		 include(FILE_VIEW_ADD_CATEGORY);
	}
	
	public function edit(){
		if(!empty($_GET['category'])){
			$cat_id = $_GET['category'];
							
			if(isset($_POST['update'])){
				$update_status = $this->model->update_categories($_POST, $cat_id);
			}
			
			$cat_name = $this->model->get_category_name($cat_id);
			include(FILE_VIEW_EDIT_CATEGORY);
			
		}
	}
	
	public function list_all(){
		$categories = $this->model->all_categories();
		if(isset($_GET['category']) && isset($_GET['action']) && $_GET['action'] == "delete"){
			die("delete...");
		}
		include(FILE_VIEW_LIST_CATEGORY);
	}
	
}
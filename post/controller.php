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
	
	public function list_all(){
		global $wpdb;
		$user_id = get_current_user_id();
		$query = "SELECT $wpdb->posts.ID, $wpdb->posts.post_title FROM $wpdb->posts, $wpdb->postmeta WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id AND $wpdb->postmeta.meta_key = 'assigned_contributors' AND FIND_IN_SET($user_id , $wpdb->postmeta.meta_value) AND $wpdb->posts.post_type = 'portal'";

		$result = $wpdb->get_results( $query, ARRAY_A  );

		echo "<pre>"; print_r($result);
	}
}
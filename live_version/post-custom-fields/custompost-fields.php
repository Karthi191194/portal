<?php

function portal_post_boxes() {
    add_meta_box( 'fields_meta_box',
        'Requirements',
        'portal_fields_meta_box',
        'procurement_forecast', 'normal', 'high'
    );
}
add_action( 'admin_init', 'portal_post_boxes' );

function portal_fields_meta_box(){
	$prev_fields = get_post_meta(get_the_ID(), 'assigned_fields', TRUE); 
	global $wpdb;
	$table_name = $wpdb -> prefix .'portal_fields';
	$field_category_table_name = $wpdb -> prefix .'portal_field_category';
	$fields = $wpdb->get_results( "SELECT field.field_id, field.field_type, field.field_label, field.field_placeholder, field.field_options, category.category_id FROM $table_name AS field INNER JOIN $field_category_table_name AS category ON field.field_id = category.field_id ORDER BY category.category_id ASC" );

	require_once "accordion-fields.php";

}

function save_post_to_other_table($post_id) {  
	if ( isset( $_POST['post_type'] ) && 'procurement_forecast' == $_POST['post_type'] && isset($_POST['portalcustomfield'])) { //echo "<pre>"; print_r($_POST['portalcustomfield']); die;
if ( false !== wp_is_post_revision( $post_id ) )
        return;
		 global $wpdb;
		 $table = $wpdb->prefix.'portal_fields_value';
		 $values = array();
		 $placeholders = array();
		 $post_id = $post_id;
		//echo "<pre>"; print_r($_POST);
		if($_POST['original_publish'] == 'Update'){
			$wpdb->query("DELETE FROM $table WHERE post_id IN ($post_id) ");
		}
		
		$query = "INSERT INTO $table (post_id, field_name, field_value) VALUES ";
		foreach($_POST['portalcustomfield'] as $name => $value){
			if(is_array($value)){ $value = serialize($value);}
			array_push($values, $post_id, $name, stripslashes($value) );
			$placeholders[] = "(%d, '%s', '%s')";
		}	
		$query .= implode(', ', $placeholders);
		
		$status  = $wpdb->query($wpdb->prepare("$query ", $values)); 
		//$lastid = $wpdb->insert_id;
		//echo $lastid; 
		 
	}  
}

add_action( 'save_post', 'save_post_to_other_table', 99, 1 );






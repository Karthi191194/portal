<?php 
function portal_tables(){
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
		
	$table_name_category = $wpdb -> prefix .'portal_category';
	$sql = "CREATE TABLE $table_name_category (category_id INT(11) AUTO_INCREMENT PRIMARY KEY, category_name VARCHAR(255) NOT NULL) $charset_collate;";
	dbDelta( $sql );
	
	$table_name_contributors = $wpdb -> prefix .'portal_contributors';
	$sql = "CREATE TABLE $table_name_contributors (contributor_id INT(11) AUTO_INCREMENT PRIMARY KEY, contributor_name VARCHAR(255) NOT NULL, contributor_email_address VARCHAR(255) NOT NULL, contributor_password VARCHAR(255) NOT NULL) $charset_collate;";
	dbDelta( $sql );
	
	$table_name_fields = $wpdb -> prefix .'portal_fields';
	$sql = "CREATE TABLE $table_name_fields (field_id INT(11) AUTO_INCREMENT PRIMARY KEY, field_type VARCHAR(255) NOT NULL, field_label VARCHAR(255) NOT NULL, field_placeholder VARCHAR(255) NOT NULL, required INT(1), 	field_options LONGTEXT) $charset_collate;";
	dbDelta( $sql );
	
	$table_name_fieldsmapped = $wpdb -> prefix .'portal_fields_mapped';
	$sql = "CREATE TABLE $table_name_fieldsmapped (id INT(11) AUTO_INCREMENT PRIMARY KEY, post_id INT(11), field_id INT(11), position INT(11),) $charset_collate;";
	dbDelta( $sql );
	
	$table_name_fieldvalue = $wpdb -> prefix .'portal_fields_value';
	$sql = "CREATE TABLE $table_name_fieldvalue (id INT(11) AUTO_INCREMENT PRIMARY KEY, post_id INT(11), field_id INT(11), contributor_id INT(11)) $charset_collate;";
	dbDelta( $sql );
	
	$table_name_posts = $wpdb -> prefix .'portal_posts';
	$sql = "CREATE TABLE $table_name_posts (post_id INT(11) AUTO_INCREMENT PRIMARY KEY, post_name VARCHAR(255) NOT NULL, post_hastag VARCHAR(255), category_id LONGTEXT, contributor_id LONGTEXT ) $charset_collate;";
	dbDelta( $sql );
}

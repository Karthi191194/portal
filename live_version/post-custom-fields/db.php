<?php 
function portal_tables(){
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
			
	$table_name_fields = $wpdb -> prefix .'portal_fields';
	$sql = "CREATE TABLE $table_name_fields (field_id INT(11) AUTO_INCREMENT PRIMARY KEY, field_type VARCHAR(255) NOT NULL, field_label LONGTEXT NOT NULL, field_placeholder VARCHAR(255) NOT NULL,  field_options LONGTEXT) $charset_collate;";
	dbDelta( $sql );
	
	$table_name_field_category = $wpdb -> prefix .'portal_field_category';
	$sql = "CREATE TABLE $table_name_field_category (id INT(11) AUTO_INCREMENT PRIMARY KEY, field_id INT(11), category_id INT(11) NOT NULL, FOREIGN KEY(field_id) REFERENCES $table_name_fields(field_id) ON DELETE CASCADE) $charset_collate;";
	dbDelta( $sql );
	
	$table_name_fields_value = $wpdb -> prefix .'portal_fields_value';
	$table_name_post = $wpdb -> prefix .'posts';
	$sql = "CREATE TABLE $table_name_fields_value (id INT(11) AUTO_INCREMENT PRIMARY KEY, post_id BIGINT(20) UNSIGNED NOT NULL, field_name VARCHAR(255) NOT NULL, field_value LONGTEXT, FOREIGN KEY(post_id) REFERENCES $table_name_post(ID) ON DELETE CASCADE ) $charset_collate;";
	dbDelta( $sql );

}

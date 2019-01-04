<?php 
/* 
Plugin Name: Post Custom Fields
Description: Plugin for creating custom fields and assigning to custom posts. 
Version: 1.0 
*/ 

include_once("db.php");
register_activation_hook( __FILE__, 'portal_tables' );

define ('PORTAL_ASSESTS_BACKEND', plugin_dir_url(__FILE__) . 'assests/backend/');
define ('PORTAL_ASSESTS_FRONTEND', plugin_dir_url(__FILE__) . 'assests/frontend/');

define('MSG', dirname(__FILE__).'/msg.tpl' );

define('FILE_VIEW_ADD_FIELDS',  dirname(__FILE__) . "/fields/view/add.tpl");
define('FILE_VIEW_LIST_FIELDS',  dirname(__FILE__) . "/fields/view/list.tpl");
define('FILE_VIEW_VIEW_FIELDS',  dirname(__FILE__) . "/fields/view/view.tpl");
define('FILE_VIEW_EDIT_FIELDS',  dirname(__FILE__) . "/fields/view/edit.tpl");
define('FILE_VIEW_LIST_TABLE_FIELDS', dirname(__FILE__). "/fields/table.php");
require_once("fields/controller.php");
require_once("fields/model.php");
require_once("custompost-fields.php");

function portal_menu(){
		
	//fields
	$control_fields = new FieldsController();	
	add_menu_page( "Fields", "Fields", "manage_options", "fields", "fields" ,plugin_dir_url( __FILE__ ). 'assests/backend/images/procurement_forecast.png', 50);
	add_submenu_page("fields", "All Fields", "All Fields", "manage_options", "all_fields", array($control_fields, 'list_all'));
	add_submenu_page("fields", "Add New Field", "Add New Field", "manage_options", "new_field", array($control_fields, 'add_new'));
	add_submenu_page("", "Edit Field", "Edit Field", "manage_options", "edit_field", array($control_fields, 'edit'));
	remove_submenu_page("fields", "fields");	
	
}
add_action( 'admin_menu', 'portal_menu' );

function global_scripts() {
    wp_enqueue_style( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' );
    wp_enqueue_style( 'jquery-ui-css', 'https://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css' );
    wp_enqueue_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js', array(), '1.0.0', true );
    wp_enqueue_script( 'bootstrapjquery', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', array(), '1.0.0', true );
    wp_enqueue_script( 'jquery-ui', 'https://code.jquery.com/ui/1.9.2/jquery-ui.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'global_scripts' );

function load_custom_wp_admin_style() {
        wp_register_style( 'custom_wp_admin_css', PORTAL_ASSESTS_BACKEND . 'css/portal.css', false, '1.0.0' );
        wp_enqueue_style( 'custom_wp_admin_css' );
		wp_enqueue_style( 'datatable', 'https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css' );
		wp_enqueue_script( 'datatable', 'https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js', array(), '1.0.0', true );
}
add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );

/*contributors*/
function add_roles_on_plugin_activation() {
       add_role( 'custom_contributor', 'Portal Contributor', array( 'read' => true, 'edit_posts' => true ) );
}
register_activation_hook( __FILE__, 'add_roles_on_plugin_activation' );




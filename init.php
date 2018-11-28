<?php 
/* 
Plugin Name: Portal
Description: Plugin for creating contributors and assigning to custom posts. 
Version: 1.0 
*/ 

include_once("db.php");
register_activation_hook( __FILE__, 'portal_tables' );

define ('PORTAL_ASSESTS_BACKEND', plugin_dir_url(__FILE__) . 'assests/backend/');
define ('PORTAL_ASSESTS_FRONTEND', plugin_dir_url(__FILE__) . 'assests/frontend/');

define('MSG', dirname(__FILE__).'/msg.tpl' );

define('FILE_VIEW_ADD_CONTRIBUTORS',  dirname(__FILE__) . "/contributors/view/add.tpl");
define('FILE_VIEW_LIST_CONTRIBUTORS',  dirname(__FILE__) . "/contributors/view/list.tpl");
define('FILE_VIEW_VIEW_CONTRIBUTORS',  dirname(__FILE__) . "/contributors/view/view.tpl");
define('FILE_VIEW_EDIT_CONTRIBUTORS',  dirname(__FILE__) . "/contributors/view/edit.tpl");
require_once("contributors/controller.php");
require_once("contributors/model.php");

define('FILE_VIEW_ADD_FIELDS',  dirname(__FILE__) . "/fields/view/add.tpl");
define('FILE_VIEW_LIST_FIELDS',  dirname(__FILE__) . "/fields/view/list.tpl");
define('FILE_VIEW_VIEW_FIELDS',  dirname(__FILE__) . "/fields/view/view.tpl");
define('FILE_VIEW_EDIT_FIELDS',  dirname(__FILE__) . "/fields/view/edit.tpl");
require_once("fields/controller.php");
require_once("fields/model.php");

define('FILE_VIEW_ADD_CATEGORY',  dirname(__FILE__) . "/category/view/add.tpl");
define('FILE_VIEW_LIST_CATEGORY',  dirname(__FILE__) . "/category/view/list.tpl");
define('FILE_VIEW_VIEW_CATEGORY',  dirname(__FILE__) . "/category/view/view.tpl");
define('FILE_VIEW_EDIT_CATEGORY',  dirname(__FILE__) . "/category/view/edit.tpl");
require_once("category/controller.php");
require_once("category/model.php");

define('FILE_VIEW_ADD_POST',  dirname(__FILE__) . "/post/view/add.tpl");
define('FILE_VIEW_LIST_POST',  dirname(__FILE__) . "/post/view/list.tpl");
define('FILE_VIEW_VIEW_POST',  dirname(__FILE__) . "/post/view/view.tpl");
define('FILE_VIEW_EDIT_POST',  dirname(__FILE__) . "/post/view/edit.tpl");
require_once("post/controller.php");
require_once("post/model.php");

define('FILE_VIEW_ADD_ENTRIES',  dirname(__FILE__) . "/entries/view/add.tpl");
define('FILE_VIEW_LIST_ENTRIES',  dirname(__FILE__) . "/entries/view/list.tpl");
define('FILE_VIEW_VIEW_ENTRIES',  dirname(__FILE__) . "/entries/view/view.tpl");
define('FILE_VIEW_EDIT_ENTRIES',  dirname(__FILE__) . "/entries/view/edit.tpl");
require_once("entries/controller.php");
require_once("entries/model.php");

function portal_menu(){
	
	//contributors
	$control_contributors = new ContributorsController();
	add_menu_page( "Contributors", "Contributors", "manage_options", "contributors", "contributors", plugin_dir_url( __FILE__ ). 'assests/backend/images/p-icon.png'  );
	add_submenu_page("contributors", "All Contributors", "All Contributors", "manage_options", "all_contributors", "contributors");
	add_submenu_page("contributors", "Add New Contributor", "Add New Contributor", "manage_options", "new_contributor", array($control_contributors, 'add_new'));
	remove_submenu_page("contributors", "contributors");
	
	//fields
	$control_fields = new FieldsController();	
	add_menu_page( "Fields", "Fields", "manage_options", "fields", "fields" ,plugin_dir_url( __FILE__ ). 'assests/backend/images/p-icon.png');
	add_submenu_page("fields", "All Fields", "All Fields", "manage_options", "all_fields", array($control_fields, 'list_all'));
	add_submenu_page("fields", "Add New Field", "Add New Field", "manage_options", "new_field", array($control_fields, 'add_new'));
	add_submenu_page("", "Edit Field", "Edit Field", "manage_options", "edit_field", array($control_fields, 'edit'));
	remove_submenu_page("fields", "fields");
	
	//category
	$control_category = new CategoryController();	
	add_menu_page( "Categories", "Categories", "manage_options", "category", "category", plugin_dir_url( __FILE__ ). 'assests/backend/images/p-icon.png' );
	add_submenu_page("category", "All Categories", "All Categories", "manage_options", "all_category", array($control_category, 'list_all'));
	add_submenu_page("category", "Add New Category", "Add New Category", "manage_options", "new_category", array($control_category, 'add_new'));
	add_submenu_page("", "Edit Category", "Edit Category", "manage_options", "edit_category", array($control_category, 'edit'));
	remove_submenu_page("category", "category");
	
	//post
	$control_post = new PostController();	
	add_menu_page( "Posts", "Posts", "manage_options", "posts", "posts", plugin_dir_url( __FILE__ ). 'assests/backend/images/p-icon.png' );
	add_submenu_page("posts", "All Posts", "All Posts", "manage_options", "all_posts", "posts");
	add_submenu_page("posts", "Add New Post", "Add New Post", "manage_options", "new_post",  array($control_post, 'add_new'));
	remove_submenu_page("posts", "posts");
	
	//entries	
	add_menu_page( "Entries", "Entries", "manage_options", "entries", "entries", plugin_dir_url( __FILE__ ). 'assests/backend/images/p-icon.png' );
	add_submenu_page("entries", "All Entries", "All Entries", "manage_options", "all_entries", "entries");
	add_submenu_page("entries", "New Entries", "New Entries", "manage_options", "new_entries", "new_entries");
	remove_submenu_page("entries", "entries");		
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


function contributors(){}
function new_contributor(){}
function fields(){}
function new_field(){}
function category(){}
function new_category(){}
function posts(){}
function new_post(){}
function entries(){}
function new_entries(){}



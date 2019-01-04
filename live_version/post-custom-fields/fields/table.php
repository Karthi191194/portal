<?php 
if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Field_List_Table extends WP_List_Table{
	private $data;
	private $db;
	private $table_name;
	
	public function __construct(){
		global $status, $page;
		global $wpdb;
		$this -> db = $wpdb;
		$this -> table_name = $wpdb -> prefix .'portal_fields';
	
		//Set parent defaults
		parent::__construct(array(
			'singular' => 'field',
			'plural' => 'fields',
			'ajax' => false
		));
	}	
	
	public function get_columns(){ 
		//column names displayed on the header and footer of table
		//the key value must be eqial to the method called function column_field_label eg.column_{key_name}
		$columns = array(
			'cb'        => '<input type="checkbox" />', //Render a checkbox instead of text
			'field_label'     => 'Field Label', 
			'field_type'    => 'Field Type'
		);
		return $columns;
	}
		
	public function prepare_items($search = null) {
		$per_page = 10;
		$columns = $this->get_columns();
		$hidden = array();
		$sortable = $this->get_sortable_columns();
		
		$this->_column_headers = array($columns, $hidden, $sortable);
		
		$this->process_bulk_action();
		
		$query = "SELECT * FROM $this->table_name ";
		if(!empty($search)){
			$query .= " WHERE (field_label LIKE '%{$search}%' OR field_type LIKE '%{$search}%' )";
		}
		//echo $this->db->last_query;
		$this->items = $this->db->get_results( $query , ARRAY_A ); 
		
		function usort_reorder($a,$b){
            $orderby = (!empty($_REQUEST['orderby'])) ? $_REQUEST['orderby'] : 'field_label'; //If no sort, default to title
            $order = (!empty($_REQUEST['order'])) ? $_REQUEST['order'] : 'asc'; //If no order, default to asc
            $result = strcmp($a[$orderby], $b[$orderby]); //Determine sort order
            return ($order==='asc') ? $result : -$result; //Send final sort direction to usort
        }
        usort($this->items, 'usort_reorder');
		
		//REQUIRED for pagination.Let's figure out what page the user is currently looking at.
		$current_page = $this->get_pagenum();
		
		//REQUIRED for pagination. Let's check how many items are in our data array. 
		 $total_items = count($this->items);
		 
		 /**
         * The WP_List_Table class does not handle pagination for us, so we need
         * to ensure that the data is trimmed to only the current page. We can use
         * array_slice() to 
         */
        $this->data = array_slice($this->items,(($current_page-1)*$per_page),$per_page);
		
		//Now we can add our *sorted* data to the items property, where it can be used by the rest of the class.
		$this->items = $this->data;
		
		/**
         * REQUIRED. We also have to register our pagination options & calculations.
         */
        $this->set_pagination_args( array(
            'total_items' => $total_items,                  //WE have to calculate the total number of items
            'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
            'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
        ) );
	}
		
	public function column_cb($item){
		return sprintf(
           '<input type="checkbox" name="%1$s[]" value="%2$s" />',
           $this->_args['singular'],  //Let's simply repurpose the table's singular label ("movie")
            $item['field_id']                //The value of the checkbox should be the record's id
		);			
	}
		
	//column field label
	//$item A singular item (one full row's worth of data)
	public function column_field_label($item){ 
		 //Build row actions
		$actions = array(
		'edit' => sprintf('<a href="?page=edit_field&action=edit&field=%s">Edit Field</a>',$item['field_id']),
		'delete'=> sprintf('<a href="?page=%s&action=delete&field=%s">Trash Field</a>',$_REQUEST['page'],$item['field_id'])
		);
        
		//Return the field label of each row
		return sprintf('%1$s %2$s', $item['field_label'],$this->row_actions($actions));
	}
		
	public function column_field_type($item){
		return sprintf('%1$s', $item['field_type']);
	}
	
	//sortable links on the header	
	public  function get_sortable_columns() {
        $sortable_columns = array(
            'field_label'    => array('field_label',false),     //true means it's already sorted
            'field_type'    => array('field_type',false)
        );
        return $sortable_columns;
    }
	
	//bulk actions
	public function get_bulk_actions() {
        $actions = array(
            'delete'    => 'Delete'
        );
        return $actions;
    }
	
	public function process_bulk_action() {
        
        //Detect when a bulk action is being triggered...
        global $wpdb;

        if ('delete' === $this->current_action()) {
            $ids = isset($_REQUEST['field']) ? $_REQUEST['field'] : array();
            if (is_array($ids)) $ids = implode(',', $ids);

            if (!empty($ids)) {
				$table1 = $wpdb->prefix . "portal_fields";
				$table2 = $wpdb->prefix . "portal_field_category";
               $wpdb->query("DELETE FROM " . $wpdb->prefix . "portal_fields WHERE field_id IN($ids)");
				//DELETE table1, table2 FROM table1 INNER JOIN table2 ON table1.id=table2.foreigns
            }
        }	        
    }
	
	public function no_items() {
		_e( 'No fields avaliable.', 'field' );
	}
	
}


/*render table output*/
$fields_table = new Field_List_Table();

//echo "<pre>"; print_r($_POST);
    $message = '';
    if ('delete' === $fields_table->current_action()) {
		if(is_array($_REQUEST['field'])){
			$message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('%d fields deleted successfully!', 'portal'), count($_REQUEST['field'])) . '</p></div>';
		}else{
			$message = '<div class="updated below-h2" id="message"><p> Field deleted successfully! </p></div>';
		}	
    }

echo '<div class="wrap"><h2>Fields <a class="add-new-h2" href="?page=new_field">Add New Field</a></h2>';echo $message; ?>
<!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
     <form id="field-filter" method="POST">
        <!-- For plugins, we also need to ensure that the form posts back to our current page -->
        <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
        <!-- Now we can render the completed list table -->
		<?php    
		 if( isset($_POST['s']) ){
			$fields_table->prepare_items($_POST['s']);
		} else {
			$fields_table->prepare_items();
		}
		//Fetch, prepare, sort, and filter our data...
		$fields_table->search_box('Search Fields', 'field'); 
		$fields_table->display(); 
		?>
    </form>
<?php
echo '</div>'; 
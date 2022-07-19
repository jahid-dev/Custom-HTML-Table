
<?php

if ( ! class_exists( "WP_List_Table" ) ) {
	require_once( ABSPATH . "wp-admin/includes/class-wp-list-table.php" );
}

class CTABLEUSERS extends WP_List_Table {

	private $_items;
	function __construct( $data ) {
		parent::__construct();
		$this->_items = $data;
	}

	function get_columns() {
		return [
			'cb'     => '<input type="checkbox">',
			'username'   => __( 'User Name', 'ctable' ),
			'email'  => __( 'Email', 'ctable' ),
			'role'  => __( 'Role', 'ctable' ),
		];
	}

	function column_cb( $item ) {
		return "<input type='checkbox' value='{$item['id']}'>";
	}

	

	function column_default( $item, $column_name ) {
		return $item[ $column_name ];
	}


	function prepare_items() {
		$paged                 = !empty($_REQUEST['paged']) ? sanitize_key($_REQUEST['paged']) : 1;
		$per_page              = 15;
		$total_items           = count( $this->_items );
		$this->_column_headers = array( $this->get_columns(), array(), $this->get_sortable_columns() );
		$data_chunks           = array_chunk( $this->_items, $per_page );
		$this->items           = $data_chunks[ $paged - 1 ];
		$this->set_pagination_args( [
			'total_items' => $total_items,
			'per_page'    => $per_page,
			'total_pages' => ceil( count( $this->_items ) / $per_page )
		] );
	}
}
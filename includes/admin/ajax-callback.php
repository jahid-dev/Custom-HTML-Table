<?php 

function ctable_pagination_query(){

global $wpdb;

$role= sanitize_text_field($_POST['role']);
if(!empty($role)){
	$ctabledataquery             = "SELECT * FROM {$wpdb->prefix}ctable_user WHERE role = '$role'";
}else{
	$ctabledataquery             = "SELECT * FROM {$wpdb->prefix}ctable_user";
}
$ctable_total_query     = "SELECT COUNT(1) FROM (${ctabledataquery}) AS combined_table";
$ctabletotalrow             = $wpdb->get_var( $ctable_total_query );
$ctable_items_per_page =  10;
$ctable_page             = isset( $_POST['page'] ) ? sanitize_key( $_POST['page'] ) : 1;
$ctable_offset         = ( $ctable_page * $ctable_items_per_page ) - $ctable_items_per_page;
$ctable_tables_data         = $wpdb->get_results( $wpdb->prepare( $ctabledataquery . " ORDER BY id ASC LIMIT %d, %d",$ctable_offset,$ctable_items_per_page), ARRAY_A );

$ctable_totalPage         = ceil($ctabletotalrow / $ctable_items_per_page);
?>
<table class="table">
	<thead>
		<tr>
			<th>Username</th>
			<th>Email</th>
			<th>Role</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		foreach($ctable_tables_data as $single){ ?>
		<tr>
			<td>
				<?php echo esc_html($single['username']); ?>
			</td>
			<td>
				<?php echo esc_html($single['email']); ?>
			</td>
			<td>
				<?php echo esc_html($single['role']); ?>
			</td>
			
		</tr>
		<?php } ?>
		
	</tbody>

	<tfoot>
		<tr>
			<td colspan="3" class="ctable_pagination">
				<?php
				if($ctable_totalPage > 1){
					echo $customPagHTML     =  '<div>'.paginate_links( array(
					'base' => add_query_arg( 'ctable', '%#%' ),
					'format' => '',
					'prev_text' => __('&laquo;'),
					'next_text' => __('&raquo;'),
					'total' => $ctable_totalPage,
					'current' => $ctable_page
					)).'</div>';
				}
				?>
			</td>
		</tr>
	</tfoot>
	
	
</table>
<?php
wp_die();
}
add_action('wp_ajax_ctable_pagination_preview', 'ctable_pagination_query');
add_action('wp_ajax_nopriv_ctable_pagination_preview', 'ctable_pagination_query');


function ctable_role_query(){
global $wpdb;
$role= sanitize_text_field($_POST['role']);
if(!empty($role)){
	$ctabledataquery             = "SELECT * FROM {$wpdb->prefix}ctable_user WHERE role = '$role'";
}else{
	$ctabledataquery             = "SELECT * FROM {$wpdb->prefix}ctable_user";
}
$ctable_total_query     = "SELECT COUNT(1) FROM (${ctabledataquery}) AS combined_table";
$ctabletotalrow             = $wpdb->get_var( $ctable_total_query );
$ctable_items_per_page =  10;
$ctable_page             = isset( $_POST['page'] ) ? sanitize_key( $_POST['page'] ) : 1;
$ctable_offset         = ( $ctable_page * $ctable_items_per_page ) - $ctable_items_per_page;
if(!empty($_POST['role'])){
	$ctable_tables_data         = $wpdb->get_results( $wpdb->prepare( $ctabledataquery . " ORDER BY id ASC LIMIT %d, %d",$ctable_offset,$ctable_items_per_page), ARRAY_A );
}else{
$ctable_tables_data         = $wpdb->get_results( $wpdb->prepare( $ctabledataquery . " ORDER BY id ASC LIMIT %d, %d",$ctable_offset,$ctable_items_per_page), ARRAY_A );
}
$ctable_totalPage         = ceil($ctabletotalrow / $ctable_items_per_page);
?>
<table class="table">
	<thead>
		<tr>
			<th>Username</th>
			<th>Email</th>
			<th>Role</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		foreach($ctable_tables_data as $single){ ?>
		<tr>
			<td>
				<?php echo esc_html($single['username']); ?>
			</td>
			<td>
				<?php echo esc_html($single['email']); ?>
			</td>
			<td>
				<?php echo esc_html($single['role']); ?>
			</td>
			
		</tr>
		<?php } ?>
		
	</tbody>
	<tfoot>
		<tr>
			<td colspan="3" class="ctable_pagination">
				<?php
				if($ctable_totalPage > 1){
					echo $customPagHTML     =  '<div>'.paginate_links( array(
					'base' => add_query_arg( 'ctable', '%#%' ),
					'format' => '',
					'prev_text' => __('&laquo;'),
					'next_text' => __('&raquo;'),
					'total' => $ctable_totalPage,
					'current' => $ctable_page
					)).'</div>';
				}
				?>
			</td>
		</tr>
	</tfoot>
	
	
</table>
<?php
wp_die();
}
add_action('wp_ajax_ctable_role_preview', 'ctable_role_query');
add_action('wp_ajax_nopriv_ctable_role_preview', 'ctable_role_query');

?>
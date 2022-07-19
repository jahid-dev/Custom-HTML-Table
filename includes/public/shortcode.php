<?php 

function ctable_shortcode_preview( $atts ){

		global $wpdb;
		$ctable_tables_column = $wpdb->get_results( $wpdb->prepare("SELECT id, username, email, role FROM {$wpdb->prefix}ctable_user ORDER BY id ASC"), ARRAY_A );

		$ctabledataquery             = "SELECT * FROM {$wpdb->prefix}ctable_user";
		$ctable_total_query     = "SELECT COUNT(1) FROM (${ctabledataquery}) AS combined_table";
		$ctabletotalrow             = $wpdb->get_var( $ctable_total_query );
		$ctable_items_per_page =  10;
		$ctable_page             = isset( $_GET['vxpage'] ) ? sanitize_key( $_GET['vxpage'] ) : 1;
		$ctable_offset         = ( $ctable_page * $ctable_items_per_page ) - $ctable_items_per_page;
		$ctable_tables_data         = $wpdb->get_results( $wpdb->prepare( $ctabledataquery . " ORDER BY id ASC LIMIT %d, %d",$ctable_offset,$ctable_items_per_page), ARRAY_A );
		$ctable_totalPage         = ceil($ctabletotalrow / $ctable_items_per_page);

		ob_start();
	?>

	<div class="ctable-pricing-table">
		<?php 
		$ctable_user_roles = $wpdb->get_results( $wpdb->prepare("SELECT id,role FROM {$wpdb->prefix}ctable_user GROUP BY role ORDER BY id ASC"), ARRAY_A );
		?>
		<div class="roles-box">
			<select name="" id="ctable_role">
				<option value="">--Select Role--</option>
				<?php foreach($ctable_user_roles as $singlerole){ ?>
				<option value="<?php echo esc_html($singlerole['role']); ?>"><?php echo esc_html($singlerole['role']); ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="table-responsive" id="ctable_preview">
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
		</div>
	</div>
<?php
	$ctable_short_output = ob_get_contents();
	ob_end_clean();
	return $ctable_short_output;
	
}

add_shortcode('ctable-preivew', 'ctable_shortcode_preview');

?>
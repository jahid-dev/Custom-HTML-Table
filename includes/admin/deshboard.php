<?php 
if ( file_exists( CTABLE_PATH . 'includes/admin/class.ctableusers.php' ) ) {
    require_once CTABLE_PATH . 'includes/admin/class.ctableusers.php';
}
?>

<div class="wrap" id="ctable-form-editor">

<h1 class="wp-heading-inline" style="font-size: 24px; font-weight: 700;"><?php
		echo esc_html( __( 'HTML Table', 'ctable' ) );

?></h1>

<?php 
if(!empty($_GET['success']) && $_GET['success']=="200"){
?>

<div class="notice notice-success is-dismissible">
    <p>
    <?php 
    echo esc_html(__('Successfully Data Import !', 'ctable')); ?>
    </p>
</div>

<?php 
}
?>

<?php 

if(!empty($_GET['success']) && $_GET['success']=="400"){

?>
<div class="notice notice-error is-dismissible">
    <p>
    <?php 
    echo esc_html(__('Invalid File Extension !', 'vxtab')); ?>
    </p>
</div>
<?php 
}
if(!empty($_GET['success']) && $_GET['success']=="404"){

?>
<div class="notice notice-error is-dismissible">
    <p>
    <?php 
    echo esc_html(__('There is an error !', 'vxtab')); ?>
    </p>
</div>
<?php } ?>

<div id="ctable-table-box">
<div class="form_tables_box_content">
	<form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" enctype="multipart/form-data">
      <input type="file" name="ctable_filename">
      <input type="hidden" name="action" value="ctable_form">
      <?php wp_nonce_field('ctable_form', 'ctable_form_nonce'); ?>
      <button class="button button-primary" name="data-import" type="submit"><?php echo __("Import CSV","vxtab"); ?></button>

    </form>
</div>
</div>

<div class="form_column_box_content">
  <?php
  global $wpdb;
  $ctable_tables = $wpdb->get_results( $wpdb->prepare("SELECT id, username, email, role FROM {$wpdb->prefix}ctable_user ORDER BY id ASC"), ARRAY_A );
  $ctabbles         = new CTABLEUSERS( $ctable_tables );
  $ctabbles->prepare_items();
  $ctabbles->display();
  ?>
</div>

</div>
<?php 

add_action('admin_post_ctable_form', function () {

  /*
  *** Data Import
  */

  if (isset($_POST['data-import'])) {
    $nonce = sanitize_text_field($_POST['ctable_form_nonce']);
    $action = 'ctable_form';
    if (wp_verify_nonce($nonce, $action)){
      global $wpdb;   

	  $ctable_extension = pathinfo($_FILES['ctable_filename']['name'], PATHINFO_EXTENSION);
		if(!empty($_FILES['ctable_filename']['name']) && $ctable_extension == 'csv'){
	  	$ctable_csvFile = fopen($_FILES['ctable_filename']['tmp_name'], 'r');
	    fgetcsv($ctable_csvFile);

	    while(($ctable_csvData = fgetcsv($ctable_csvFile)) !== FALSE){
	      $ctable_csvData = array_map("utf8_encode", $ctable_csvData);
	      $wpdb->query(
	         $wpdb->prepare(
	            "INSERT INTO {$wpdb->prefix}ctable_user
	            ( username, email, role)
	            VALUES ( %s, %s, %s)",
	            sanitize_text_field(trim($ctable_csvData[0])),
	            sanitize_email(trim($ctable_csvData[1])),
	            sanitize_text_field(trim($ctable_csvData[2]))
	         )
	      );
	  	}
      wp_safe_redirect(
         admin_url('admin.php?page=ctable&success=200')
      );

	  }else{
	  	wp_safe_redirect(
	        admin_url('admin.php?page=ctable&success=400')
	    );
	  }
    }else{
      wp_safe_redirect(
         admin_url('admin.php?page=ctable&success=404')
      );
    }
  }  

});


?>
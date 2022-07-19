<?php 

/**
 * Table create 
 * https://codex.wordpress.org/Creating_Tables_with_Plugins
 */
global $wpdb;
$table_name = $wpdb->prefix . "ctable_user";
$charset_collate = $wpdb->get_charset_collate();


require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

/*
*ctable
*/

$sql = "CREATE TABLE IF NOT EXISTS $table_name (
  id bigint(20) NOT NULL AUTO_INCREMENT,
  username varchar(255),
  email varchar(255),
  role varchar(255),
  PRIMARY KEY id (id)
) $charset_collate;";
dbDelta($sql);


?>
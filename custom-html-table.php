<?php 
/**
 * Plugin Name:       Custom HTML Table
 * Plugin URI:        https://themefic.com/
 * Description:       Custom HTML Table Builder
 * Version:           1.0.0
 * Requires at least: 4.7
 * Tested up to: 6.0.1
 * Requires PHP:      5.3
 * Author:            jahidcse
 * Author URI:        https://profiles.wordpress.org/jahid-cse/
 * Text Domain:       ctable
 */


// don't load directly
defined( 'ABSPATH' ) || exit;

/**
* Including Plugin file
*/

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

define('CTABLE_PATH',plugin_dir_path(__FILE__));
define('CTABLE_URL',plugin_dir_url(__FILE__));
define('CTABLE_VERSION','1.0.0');


/**
* Plugin Activation
*/

function vxtab_activation_function() { 
  if ( file_exists( CTABLE_PATH . 'includes/admin/tabledb.php' ) ) {
    require_once CTABLE_PATH . 'includes/admin/tabledb.php';
  }
}
register_activation_hook( __FILE__, 'vxtab_activation_function' );



/**
 * Plugin Activation redirect page
 * https://developer.wordpress.org/reference/hooks/activated_plugin/
 */

function ctable_activated_deshboard($plugin){
    if (plugin_basename(__FILE__)==$plugin) {
        wp_redirect(admin_url('admin.php?page=ctable'));
        die();
    }
}
add_action('activated_plugin','ctable_activated_deshboard');




/**
 * Admin Menu Genaration
 * https://developer.wordpress.org/reference/hooks/admin_menu/
 * 
*/

add_action( 'admin_menu', 'ctable_admin_main_menu_creation' );

function ctable_admin_main_menu_creation(){
    add_menu_page(
        __( 'HTML Table', 'ctable' ),
        __( 'HTML Table', 'ctable' ),
        'manage_options',
        'ctable',
        'ctable_admin_table_manager',
        'dashicons-table-col-after',
        30
    );

}

function ctable_admin_table_manager(){
  include_once CTABLE_PATH.'/includes/admin/deshboard.php';
}

/**
 * Submission Function includes
*/

if ( file_exists( CTABLE_PATH . 'includes/admin/form-submission.php' ) ) {
    require_once CTABLE_PATH . 'includes/admin/form-submission.php';
}

/**
 * Public Function includes
*/

if ( file_exists( CTABLE_PATH . 'includes/public/shortcode.php' ) ) {
    require_once CTABLE_PATH . 'includes/public/shortcode.php';
}


/**
 * Public Ajax callback Function includes
*/

if ( file_exists( CTABLE_PATH . 'includes/admin/ajax-callback.php' ) ) {
    require_once CTABLE_PATH . 'includes/admin/ajax-callback.php';
}


/**
 * Front-end Enqueue styles and scripts 
 * https://developer.wordpress.org/reference/hooks/wp_enqueue_scripts/
 */

function ctable_enqueue_front_script(){
  wp_enqueue_style('ctable-front-style', CTABLE_URL. 'includes/public/assets/css/style.css', array(), CTABLE_VERSION);
  wp_enqueue_style('font-awesome', CTABLE_URL. 'includes/public/assets/css/font-awesome.min.css', array(), CTABLE_VERSION);

  wp_enqueue_script('ctable-script', CTABLE_URL. 'includes/public/assets/js/custom.js', array('jquery'), true, CTABLE_VERSION);
  wp_localize_script('ctable-script','ctable',
    array(
      'ajaxurl' => admin_url('admin-ajax.php')
  ));
}

add_action('wp_enqueue_scripts', 'ctable_enqueue_front_script');
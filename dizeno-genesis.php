<?php 
/*
Plugin Name: Genesis
Plugin URI: 
Description: Plugin from Dizeno
Author: Tejas Mishra
Version: 1.0
Author URI: 
*/
	


define('PLUGIN_GENESIS_PATH', plugin_dir_path(__FILE__));
define('PLUGIN_GENESIS_NAME', plugin_basename(__FILE__));
define('PLUGIN_GENESIS_URL', plugins_url()."/genesis/");


global $origin_theme, $slider_enabled, $is_logo_set, $topbar_menu_pos;
$origin_theme 	= get_option( 'origin_theme' );
$slider_enabled = $origin_theme['switch-parent-slider'];

/**
 * Add an admin menu link 
 */
global $menu_slug;
$menu_slug = 'dizeno_genesis';
function genesis_create_menu() {
	global $menu_slug;
    add_menu_page(__('Genesis', 'dizeno_genesis'), __('Genesis', 'dizeno_genesis'), 'manage_options', $menu_slug, 'dizeno_genesis_page_handler','dashicons-dizeno-logo',5);	
}
add_action( 'admin_menu', 'genesis_create_menu' );
function dizeno_genesis_page_handler() { 
?>
    <div class="wrap">
        <h2><?php _e('Genesis', 'dizeno_genesis')?></h2>
    </div>

<?php }



/**
 * Register assets
 */
function register_scripts_and_styles() {
	// Magnific Popup
	wp_enqueue_style( 'magnific-popup', PLUGIN_GENESIS_PATH.'assets/css/magnific-popup/magnific-popup.css', false, '0.9.9', 'all' );
	wp_enqueue_script( 'magnific-popup', PLUGIN_GENESIS_PATH.'assets/js/magnific-popup/magnific-popup.js', array( 'jquery' ), '', true );
}
add_action('admin_enqueue_scripts', 'register_scripts_and_styles');

require_once(PLUGIN_GENESIS_PATH.'assets/widgets/widget-slider.php');
require_once(PLUGIN_GENESIS_PATH.'assets/widgets/widget-aboutus.php');





?>
<?php
/**
 * Plugin Name: ray CRUD plugin
 * Description: Plugin for sample CRUD in WP
 * Version: 1.0
 * Author: Ray Roland
 * Author URI: http://www.rayroland.com
 */

 function raycrud_install() {
	global $wpdb;
	
	$table_name = $wpdb->prefix . 'article';
	
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,		
		title varchar(55) NOT NULL,
		slug varchar(55) DEFAULT '' NOT NULL,
        content text NOT NULL,		
		PRIMARY KEY  (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

}

register_activation_hook( __FILE__, 'raycrud_install' );

add_action('admin_menu','plugin_menu');

function plugin_menu() {

    add_menu_page('Ray CRUD', 'Ray CRUD', 'manage_options','raycrud','raycrud');

    add_submenu_page('raycrud', 'Add New Data', 'Add New', 'manage_options','raycrud_create', 'raycrud_create');

    add_submenu_page(null, 'Update Data','Update', 'manage_options', 'raycrud_update', 'raycrud_update' ); 
}

define('ROOTDIR', plugin_dir_path(__FILE__));
require_once(ROOTDIR . 'list.php');
require_once(ROOTDIR . 'create.php');
require_once(ROOTDIR . 'update.php');
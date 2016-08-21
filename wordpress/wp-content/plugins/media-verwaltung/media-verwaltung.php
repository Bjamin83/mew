<?php
/*
 * Plugin Name: Media Verwaltung
 * Description: Zur automatischen Erstellung von Ordnern der Unternemen sowie deren Pflege in der DB.
 * Author: Bjamin
 * Version: 0.1
 *
 */

register_activation_hook( __FILE__, 'create_media_table' );

function create_media_table()
{
    global $wpdb;

    $table_name = $wpdb->prefix . 'mediaverwaltung';

    $sql = "CREATE TABLE $table_name (
      id int(11) NOT NULL AUTO_INCREMENT,
	  slugname varchar(50) NOT NULL,
      slug varchar(50) NOT NULL,
      permalink varchar(500) DEFAULT NULL,
      description varchar(255) DEFAULT NULL,
      imagename varchar(255) DEFAULT NULL,
      property11 varchar(255) DEFAULT NULL,
      property12 varchar(255) DEFAULT NULL,
      property13 varchar(255) DEFAULT NULL,
	  PRIMARY KEY (`slugname`),
      UNIQUE KEY id (id)
    );";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
    
    
    
} 




add_action( 'admin_menu', 'register_my_media_verwaltung' );

function register_my_media_verwaltung() {

	add_menu_page( 'MEW Media Verwaltung', 'MEW Media Verwaltung', 'manage_options', 'media-verwaltung/media-verwaltung-admin.php', '', '', 6 );

}









?>
<?php
/*
 * Plugin Name: Unternehmen
 * Description: Unternehmen in der Region
 * Author: Bjamin
 * Version: 0.1 
 * 
 */

/* Datenbank bei Aktivierung anlegen   
register_activation_hook( __FILE__, 'create_plugin_tables' );

function create_plugin_tables()
{
    global $wpdb;

    $table_name = $wpdb->prefix . 'checkliste';

    $sql = "CREATE TABLE $table_name (
      id int(11) NOT NULL AUTO_INCREMENT,
      userID varchar(50) NOT NULL,
      checkliste varchar(1000) DEFAULT NULL,
      property11 varchar(255) DEFAULT NULL,
      property12 varchar(255) DEFAULT NULL,
      property13 varchar(255) DEFAULT NULL,
      property14 varchar(255) DEFAULT NULL,
      property15 varchar(255) DEFAULT NULL,
      UNIQUE KEY id (id)
    );";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql ); 
} 

*/ 
require_once('posttyp.php');
require_once('regionen-box.php');
require_once('unternehmen-spalten.php');

?>
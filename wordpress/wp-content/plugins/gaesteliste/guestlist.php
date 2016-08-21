<?php
 /*
 * Plugin Name: DB für Gästeliste
 * Description: DB-Tabelle für die Gäste
 * Author: Bjamin
 * Version: 0.1 
 * 
 */

/* Datenbank bei Aktivierung anlegen  */  
register_activation_hook( __FILE__, 'create_guestlist_tables' );

function create_guestlist_tables()
{
    global $wpdb;

    $table_name = $wpdb->prefix . 'guestlist';

    $sql = "CREATE TABLE $table_name (
      id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      userID varchar(11) NOT NULL,
      userName varchar(50) NOT NULL,
      vorname varchar(50) NOT NULL,
      nachname varchar(50) DEFAULT NULL,
      portion varchar(50) NOT NULL,
      essen varchar(50) NOT NULL,
      status varchar(50) NOT NULL,
      property11 varchar(255) DEFAULT NULL,
      property12 varchar(255) DEFAULT NULL,
      property13 varchar(255) DEFAULT NULL,
      property14 varchar(255) DEFAULT NULL,
      property15 varchar(255) DEFAULT NULL
      
    );";
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
    
} 
?>
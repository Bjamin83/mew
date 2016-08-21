<?php
 /*
 * Plugin Name: DB für Checkliste
 * Description: DB-Tabelle für die Checkliste
 * Author: Bjamin
 * Version: 0.1 
 * 
 */

/* Datenbank bei Aktivierung anlegen  */  
register_activation_hook( __FILE__, 'create_checklist_tables' );

function create_checklist_tables()
{
    global $wpdb;

    $table_name = $wpdb->prefix . 'checklist';

    $sql = "CREATE TABLE $table_name (
      id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      userID int(11) NOT NULL,
      beschreibung varchar(250) NOT NULL,
      prio varchar(50) NOT NULL,
      datum varchar(50) DEFAULT NULL,
      status tinyint(2) NOT NULL,
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
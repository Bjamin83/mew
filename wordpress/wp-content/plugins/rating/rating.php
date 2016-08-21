<?php
 /*
 * Plugin Name: Rating System MEW
 * Description: Bewertungssystem der Werbekunden
 * Author: Bjamin
 * Version: 0.1 
 * 
 */

/* Datenbank bei Aktivierung anlegen  */  
register_activation_hook( __FILE__, 'create_rating_table' );

function create_rating_table()
{
    global $wpdb;

    $table_name = $wpdb->prefix . 'rating';

    $sql = "CREATE TABLE $table_name (
      id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      unternehmensID varchar(11) NOT NULL,
      userID int(11) NOT NULL,
      bewertung int(11) NOT NULL,
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
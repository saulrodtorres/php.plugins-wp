<?php

//esta constante comprueba si ya está desinstalado.
if( !defined( 'WP_UNINSTALL_PLUGIN' ) ){
    exit();
}

global $wpdb;
//tiene que ser entre llaves
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}mitabla");

?>
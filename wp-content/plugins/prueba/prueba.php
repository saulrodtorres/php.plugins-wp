<?php
/**
* Plugin Name: Pruebas
* Plugin URI: https://srttorres.com
* Description: Este es mi primer plugin. 
* Version: 1.10.3
* Requires at least: 5.2
* Requires PHP: 7.2
* Author: John Smith
* Author URI: https://author.example.com/
* License: GPL v2 or later
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
* Text Domain: my-basics-plugin
* Domain Path: /languages
*/

function res_install(){
    //Accion
    require_once 'activador.php';
}
//__FILE__ es el archivo donde nos encontramos
register_activation_hook(__FILE__, 'res_install');


function res_desactivacion(){
    //Accion
    flush_rewrite_rules();
    //podría eliminar una tabla de la base de datos
}
register_deactivation_hook(__FILE__, 'res_desactivacion');
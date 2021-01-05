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
* Text Domain: pruebas
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


if ( !function_exists( 'res_plugins_cargados' ) ){
    function res_plugins_cargados(){
        //pintar un meta si el usuario está logeado. 
        if( current_user_can('edit_pages')){
            if(!function_exists('add_meta_description')){
                function add_meta_description(){
                    echo "<meta name='description' content='creación de plugins de wordpress'>";
                }
                add_action('wp_head','add_meta_description');
            }
        }
    }
    //este gancho de acción. se dispara una vez se han cargados los elementos activados
    add_action('plugins_loaded', 'res_plugins_cargados');
}

//vamos a crear una pestaña para el plugin
if (!function_exists('res_prueba_nonce')){
    function res_prueba_nonce(){

        add_menu_page(
            'RES Prueba Nonce',
            'RES Prueba Nonce',
            'manage_options',
            'res_pruebas_nonce',
            'res_pruebas_page_display',
            'dashicons-excerpt-view',//icono de la página de wp dashicons 6º parametro
            '15'
        );
    }
    add_action('admin_menu', 'res_prueba_nonce');
    function res_pruebas_page_display(){

        if(current_user_can('edit_others_posts')){
            $nonce = wp_create_nonce('mi_nonce_de_seguridad');
            echo "<br>El nonce actual: $nonce <br>";
            
            if (isset($_POST['nonce']) && !empty($_POST['nonce'] )){
                if (wp_verify_nonce($_POST['nonce'], 'mi_nonce_de_seguridad')){
                    echo "Hemos verificado correctamente el nonce recibido <br> NONCE: {$_POST['nonce']} <br>";
                }
                else{
                    echo "el nonce recibido no es correcto";
                }
            }
            ?>
            <br>
            <form action="" method="POST">
                <input type="hidden" name="nonce" value="<?php echo $nonce; ?>">
                <input type="hidden" name="eliminar" value="eliminar">
                <button type="submit">Eliminar</button>
            </form>


            <?php
        }
    }
}


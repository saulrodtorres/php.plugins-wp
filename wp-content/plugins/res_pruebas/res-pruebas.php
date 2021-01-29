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

        remove_menu_page('admin_menu', 'res_pruebas_nonce');

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
/*************************************************/
/*menú en el CMS de wordpress*/
/*************************************************/
if (!function_exists('res_options_page')){

    function res_options_page(){
        add_menu_page(
            'RES opciones de Página',
            'RES opciones de Página',
            'manage_options',
            'res_options_page',
            'res_options_page_display',
            plugin_dir_url(__FILE__).'img/logo_menu.png',
            15
        );
        add_submenu_page(
            'res_options_page',
            'Submenu 1', //page title
            'Submenu 1',//submenu title
            'manage_options',
            'res_submenu1_pruebas',
            'res_submenu1_pruebas_display'

        );
    }
    add_action('admin_menu', 'res_options_page');
}

if(!function_exists('res_options_page_display')){
    function res_options_page_display(){
        ?>
        <!--html para el formulario-->
        <div class = "wrap">
            <form action="" method="POST">
                <input type="text" name="" id="" placeholder="Texto">
                <?php submit_button('Enviar'); ?>
            </form>
        </div>
        <?php
        
    }
    if(!function_exists('res_submenu1_pruebas_display')){
        function res_submenu1_pruebas_display(){
            ?>
            <!--html-->
            <div class="wrap">
                <h3>Bienvenido a la página submenu</h3>
            </div>
            
            <?php
        }
    }
}

//function eliminar widget

function quitar_widget_calendar(){
    unregister_widget('WP_Widget_Calendar');
}
add_action('widgets_init','quitar_widget_calendar');


//enviar un email por cada post 
//para esto necesitamos un servidor web
function function_callback_save_post($post_id, $post){
    //si el post es una revisión
    if (wp_is_post_revision($post_id)){
        return;
    }

    $author_id = $post->post_author;
    $name_author = get_the_author_meta('display_name', $author_id);
    $email_author = get_the_author_meta('user_email', $author_id);
    $title = $post->post_title;
    $permalink = get_permalink($post_id);

    //Datos para el email
    $para=sprintf('%s', $email_autor);
    $asunto=sprintf('Publicacion guardada %s', $title);
    $mensaje=sprintf('%s se ha publicado %s en %s',$name_author, $title, $permalink );
    $headers[]='From "'.$name_author.'" <'.get_option('admin_email').'>';
    wp_mail($para,$asunto,$mensaje,$headers);

    add_action('save_post', 'function_callback_save_post');
}


//ver más cambiarlo por ...
function atr_modificar_texto($texto){
    $texto = "...";
    return $texto;
}

add_filter('excerpt_more', 'atr_modificar_texto');
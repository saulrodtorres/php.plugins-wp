<?php


//**NONCE nos devuelve el código del nonce que cambia cada 12h pero es balido por 24h */
$url = 'http://localhost/_curso02/como-crear-tarta-de-queso-italiana/';
echo wp_nonce_url($url, 'borrar', 'nonce');




/**sanitatización de código */
$mensaje = "Mensaje <?php echo 'DELETE, DROP, UPDATE'?> guardado<br>";
echo sanitize_text_field($mensaje);
/**sanitatización de email para no incluir caracteres extraños*/
$_POST['email'] ='pruebas ¿¿¿¿¿¿¿@pruebas.com !!';
$email = $_POST['email'];
echo "<br>";
echo sanitize_email($email);







/**comprobar si es formato email */
$_POST['email'] ='pruebas@pruebas.com';
$email = $_POST['email'];

if(is_email($email)){
    echo "Este email es correcto<br>";
}
else{
    echo "Email incorrecto<br>";
}

/**comprobar */

$_POST['frutas']=array('Mango','Pera', 'Manzana', 'Piña');
$frutas = $_POST['frutas'];

if (in_array('Manzana', $frutas)){
    echo "Manzana existe";
}



///OTROS////////////////////////

//comprobar si existe y si no, la crea
//variable

if (!isset($mivariable)){
    $mivariable = "Nuevo valor";    
}

//funcion

if ( !function_exists( 'res_install' ) ){
    function res_install(){
    //escribimos nuestra función
    }
}

//comprobar si la clase existe

if ( !class_exists( 'Res_Mi_Class' ) ){
    class Res_Mi_Class {
    //escribimos el código a ejecutar
    }
    }

//comprobar si existe la constante
/*
if( !defined( 'UNA_CONSTANTE' ) ){//'WP_UNINSTALL_PLUGIN' ) ){
    exit();
    }
    */
//comprobar si es un usuario
/*
if ( is_admin() ){
    //mostramos la información de la administración
    //require_once 'admin/display-admin.php';
    }else{
    //require_once 'public/display-public.php';
    }
*/
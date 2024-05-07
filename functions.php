<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );

// END ENQUEUE PARENT ACTION

function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
  }


// PAGINA DE CLUSTERS

//Insertar Javascript y enviar ruta admin-ajax.php
add_action('wp_enqueue_scripts', 'cimne_insertar_js');

function cimne_insertar_js(){

    wp_register_script('cimne_main_scripts', get_stylesheet_directory_uri(). '/js/functions.js', array('jquery'), '1', true );
    wp_enqueue_script('cimne_main_scripts');

    //echo get_permalink();

	if (is_page( 'projects-template' )) {      
        wp_register_script('cimne_ajax_scripts', get_stylesheet_directory_uri(). '/js/cimne_ajax.js', array('jquery'), '1', true );
        wp_enqueue_script('cimne_ajax_scripts');
        wp_localize_script('cimne_ajax_scripts','cimne_vars',['ajaxurl'=>admin_url('admin-ajax.php')]);
    }

    if( strpos(get_permalink(), 'transparency' )) {
        wp_register_script('cimne_transparency_scripts', get_stylesheet_directory_uri(). '/js/transparency.js', array('jquery'), '1', true );
        wp_enqueue_script('cimne_transparency_scripts');
    }
}

//Devolver datos a archivo js
add_action('wp_ajax_nopriv_cimne_ajax_request','cimne_http_request');
add_action('wp_ajax_cimne_ajax_request','cimne_http_request');

function cimne_http_request()
{

	$RTDClusterCode = $_POST['id_post'];
    $webServiceUrl = 'https://ws.cimne.com/web_cimne/GetClusterByCode?Code=';
    $requestUrl = $webServiceUrl.$RTDClusterCode;
    $response = wp_remote_get($requestUrl);

    if(is_wp_error($response)) {
        return $response->get_error_message();
    
    } else if ( str_contains( $response['body'], 'Warning: Attempt to read property' )) {
        return "<h1>Wrong cluster code</h1>";

    } else {
        $body = wp_remote_retrieve_body($response);
    }

	//sleep(2);
    echo $body;

	wp_die();
}



// Filtro para agregar contenido a una página de WordPress a través del shortcode [cluster_info]

//add_shortcode('cluster_info', 'cimne_add_cluster_info');

// Agregamos contenido sólo a la página con el título "cluster"
/*function cimne_add_cluster_info($atts){

    $default = array(
        'attr' => 'null',
    );
    $clusterInfoRequest = shortcode_atts($default, $atts);

    //console_log($clusterInfoRequest);
    //console_log($clusterInfoRequest['attr']);

    $errorMessage = '<h1>Page not found</h1>';

	if (!isset($_GET['code']) || empty($_GET['code']) || $clusterInfoRequest['attr'] == 'null' ) return $errorMessage;

    $hash = $_GET['code'];

    //console_log($hash);
    
    //$html = cimne_get_data_api($hash);
    // Se puede usar cualquier de las dos lineas de abajo
	// $html = cimne_get_data_api($hash, $clusterInfoRequest);
    //$html = cimne_get_data_api($hash, $clusterInfoRequest['attr']);
	//return $html;
}

*/
// END PAGINA DE CLUSTERS
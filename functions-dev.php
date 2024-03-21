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

add_filter('allowed_http_origins', 'add_allowed_origins');

function add_allowed_origins($origins) {
    $origins[] = 'http://localhost:3000';
    return $origins;
}

// END ENQUEUE PARENT ACTION

function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
  }


// PAGINA DE CLUSTERS

// Shortcode [cluster_info cluster="Code"]
function cimne_get_data_api($RTDClusterCode, $RTDClusterInfoRequest) {
    

    $webServiceUrl = 'https://ws.cimne.com/web_cimne/GetClusterByCode?Code=';
    $requestUrl = $webServiceUrl.$RTDClusterCode;

    console_log( '$requestUrl: '.$requestUrl);

    $response = wp_remote_get($requestUrl);

    console_log( '$response->body: '.$response->body);
    console_log( $response );
    console_log( $response->body );

    if(is_wp_error($response)) {
        return $response->get_error_message();
    
    } else if ( str_contains( $response['body'], 'Warning: Attempt to read property' )) {
        return "<h1>Wrong cluster code</h1>";

    } else {
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);
        console_log( '$data: '.$data );
    }

   
        
}


//Insertar Javascript js y enviar ruta admin-ajax.php
add_action('wp_enqueue_scripts', 'cimne_insertar_js');

function cimne_insertar_js(){

	if (!is_home()) return;

	wp_register_script('cimne_cripts', get_template_directory_uri(). '/js/functions.js', '1', true );
	wp_enqueue_script('cimne_cripts')

	wp_localize_script('cimne_cripts'),'cimne_vars',['ajaxurl'=>admin_url('admin-ajax.php')]);
}

//Devolver datos a archivo js
add_action('wp_ajax_nopriv_cimne_ajax_text','cimne_enviar_contenido');
add_action('wp_ajax_cimne_ajax_text','cimne_enviar_contenido');

function cimne_enviar_contenido()
{

	$id_post = absint($_POST['id_post']);
	//$content = apply_filters('the_content', get_post_field('post_content', $id_post));

    $webServiceUrl = 'https://ws.cimne.com/web_cimne/GetClusterByCode?Code=';
    $requestUrl = $webServiceUrl.$RTDClusterCode;

    console_log( '$requestUrl: '.$requestUrl);

    $response = wp_remote_get($requestUrl);

    console_log( '$response->body: '.$response->body);
    console_log( $response );
    console_log( $response->body );

    if(is_wp_error($response)) {
        return $response->get_error_message();
    
    } else if ( str_contains( $response['body'], 'Warning: Attempt to read property' )) {
        return "<h1>Wrong cluster code</h1>";

    } else {
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);
        //console_log( '$data: '.$data );
    }

	//sleep(2);
	
	return "Ojete";

	wp_die();
}



// Filtro para agregar contenido a una página de WordPress a través del shortcode [cluster_info]

add_shortcode('cluster_info', 'cimne_add_cluster_info');

// Agregamos contenido sólo a la página con el título "cluster"
function cimne_add_cluster_info($atts){

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
    $html = cimne_get_data_api($hash, $clusterInfoRequest['attr']);
	return $html;
}


// END PAGINA DE CLUSTERS
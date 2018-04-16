<?php
/*register menus*/
if(!defined("SABIAN_THEME_NAME")){
	define("SABIAN_THEME_NAME","Sabian Corporate");	
}
if(!defined("SABIAN_COPRATE")){
	define("SABIAN_COPRATE",SABIAN_THEME_NAME);	
}
if(!defined("SABIAN_APP_PATH"))
define("SABIAN_APP_PATH",dirname(__FILE__)."/");

if(!defined("SABIAN_URL"))
define("SABIAN_URL",get_template_directory_uri()."/");

if(!defined("SABIAN_IMAGE_URL"))
define("SABIAN_IMAGE_URL",SABIAN_URL."images/");

if(!defined("SABIAN_TEMPLATES_PATH"))
define("SABIAN_TEMPLATES_PATH",SABIAN_APP_PATH."templates/");

if(!defined("SABIAN_GOOGLE_MAPS_API"))
define("SABIAN_GOOGLE_MAPS_API","AIzaSyBgNysDKEbU4k5Sgp0R-9JXWhTYvmvCnWw"); //Loading from Google Maps Web API (To activate click : https://developers.google.com/places/javascript/)


if(!defined("SABIAN_EVE_THEME_TEMPLATE_FOLDER")){
    define("SABIAN_EVE_THEME_TEMPLATE_FOLDER","sabian-events");
}

require_once(SABIAN_APP_PATH."application.php");

remove_filter( 'the_content', 'wpautop' );
remove_filter( 'the_excerpt', 'wpautop' );

/*allow thumbnails*/
add_theme_support( 'post-thumbnails' ); 
add_image_size( 'sabian_preview', 300, 300 ); //300 pixels wide (and unlimited height)
add_image_size( 'sabian_sidebar', 370, 500 ); 
add_image_size( 'sabian_blog', 470, 500 );
add_image_size( 'sabian_small', 50, 100 ); 
add_image_size('sabian_gallery',250,500);
set_post_thumbnail_size( 150, 150, true ); 
/*allow thumbnails*/

/*menus*/
add_action( 'init', 'sabian_register_menus' );
/*menus*/

/*register theme scripts*/
add_action( 'wp_enqueue_scripts', 'sabian_register_styles' );

add_action( 'wp_enqueue_scripts', 'sabian_register_scripts' );

add_action( 'admin_enqueue_scripts', 'sabian_register_admin_scripts');

add_filter("sabian_site_logo","sabian_site_logo");

function sabian_site_logo($img)
{
	$logo="";
	
	$logo=get_bloginfo("name");
	
	return apply_filters("sabian_img_logo",$logo);
}

function sabian_theme_active()
{
	return true;
}

?>
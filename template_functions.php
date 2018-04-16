<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * 
 * @since 1.5.4
 */

if(!defined("SABIAN_TEMPLATES_PATH")){
    
    /**
     * The default template path for all posts
     */
    define("SABIAN_TEMPLATES_PATH",SABIAN_APP_PATH."templates/");
}


/**
 * Loads a post template
 * @param string $style Template style
 * @param WP_Post $post
 */
function sabian_load_post_item_template($style = '1',$post = null) {
    
    sabian_load_template('views/post-slider-item-' . $style . '.php');
}

/**
 * Gets a file template
 * @param string $template_name
 * @param string $default_path The default path if theme template not found
 * @param array $args Template arguments
 * @return boolean|string
 */
function sabian_get_template($template_name, $default_path=SABIAN_TEMPLATES_PATH,$args = array()) {
    
    $template_path = SABIAN_TEMPLATES_PATH;
    
    //echo $template_path.$template_name." nigga";

    // Look templates in theme first.
    $template = locate_template(
            array(
                trailingslashit($template_path) . $template_name,
                $template_name,
            )
    );
    
    if (!$template) {
        $template = $default_path . $template_name;
    }
    if (file_exists($template)) {
        
        return $template;
    }
    
    return false;
}

/**
 * Get Template Part.
 * @param  String $slug Name of slug.
 * @param  string $name Name of file / template.
 */
function sabian_get_template_part($slug, $name = '',$default_path=SABIAN_TEMPLATES_PATH) {
    
    $template = '';
    
    $file_name = ( $name ) ? "{$slug}-{$name}.php" : "{$slug}.php";
    
    if ($name) {
        $template = sabian_get_template($file_name,$default_path);
    }
    
    if ($template) {
        load_template($template, false);
    }
}

/**
 * Load Template
 *
 * @param  String $path Path of template.
 * @param string $default_path The default path if theme template not found
 * @param  array  $args Template arguments.
 */
function sabian_load_template($path, $default_path=SABIAN_TEMPLATES_PATH,$args = array()) {
    
    $template = sabian_get_template($path, $default_path,$args);
    
    if ($template) {
        include $template;
    }
}


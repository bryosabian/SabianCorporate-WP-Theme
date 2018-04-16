<?php
define("SABIAN_SEGMENTS", true);

function sabian_get_categories($args = array()) {

    $default_args = array(
        "taxonomy" => "category",
        "orderby" => "term_id",
        "order" => "DESC",
    );

    $args = wp_parse_args($args, $default_args);

    $categories = get_categories($args);

    return $categories;
}

function sabian_get_posts($post_args = array(), $tax_args = array()) {

    $args = array();

    $def_post_args = array(
        "posts_per_page" => -1
    );

    $args = wp_parse_args($post_args, $def_post_args);

    if (!empty($tax_args)) {
        $args['tax_query'] = array($tax_args);
    }

    $posts = get_posts($args);

    return $posts;
}

function sabian_get_pages($args = array()) {

    $def_args = array(
        "post_type" => "page",
        "post_status" => "publish");

    $args = wp_parse_args($args, $def_args);

    return sabian_get_posts($args);
}

function sabian_get_ellipsis($string, $length) {
    if (strlen($string) <= $length) {
        return $string;
    } else {
        return substr($string, 0, $length) . ".....";
    }
}

function sabian_update_meta_values($post_id, $meta_key, $value) {

    $old_value = wp_specialchars(get_post_meta($post_id, $meta_key, true));

    if ($value && '' == $old_value) {

        update_post_meta($post_id, $meta_key, $value);

        return;
    }

    if ($value != $old_value) {

        update_post_meta($post_id, $meta_key, $value);

        return;
    }
    if ('' == $value && $old_value) {
        delete_post_meta($post_id, $meta_key, $meta_value);

        return;
    }
}

/**
 * Converts hex to rgba
 * @param hex $color
 * @param int $opacity
 * @return string
 */
function sabian_hex_to_rgb($color, $opacity = false) {

    $default = 'rgb(0,0,0)';

    //Return default if no color provided
    if (empty($color))
        return $default;

    //Sanitize $color if "#" is provided 
    if ($color[0] == '#') {
        $color = substr($color, 1);
    }

    //Check if color has 6 or 3 characters and get values
    if (strlen($color) == 6) {
        $hex = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
    } elseif (strlen($color) == 3) {
        $hex = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
    } else {
        return $default;
    }

    //Convert hexadec to rgb
    $rgb = array_map('hexdec', $hex);

    //Check if opacity is set(rgba or rgb)
    if ($opacity) {
        if (abs($opacity) > 1)
            $opacity = 1.0;
        $output = 'rgba(' . implode(",", $rgb) . ',' . $opacity . ')';
    } else {
        $output = 'rgb(' . implode(",", $rgb) . ')';
    }

    //Return rgb(a) color string
    return $output;
}

?>
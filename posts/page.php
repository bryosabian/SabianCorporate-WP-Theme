<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined("SABIAN_HEADER_PAGE_IMAGE_META")) {
    define("SABIAN_HEADER_PAGE_IMAGE_META", "_sabian_page_header_image");
}

if (!defined("SABIAN_HEADER_PAGE_TITLE_META")) {
    define("SABIAN_HEADER_PAGE_TITLE_META", "_sabian_page_header_title");
}
if (!defined("SABIAN_HEADER_PAGE_DISPLAY_META")) {
    define("SABIAN_HEADER_PAGE_DISPLAY_META", "_sabian_page_header_display");
}

add_action('add_meta_boxes', 'sabian_add_page_header_box');

add_action('save_post', 'sabian_save_page_header_settings');

add_action('admin_enqueue_scripts', function($hook) {

    global $post;

    if ($hook == 'post-new.php' || $hook == 'post.php') {

        $supports = sabian_get_header_page_supported_types();

        if (in_array($post->post_type, $supports)) {

            /* Enqueue the wp media upload scripts */
            wp_enqueue_script('media-upload');

            wp_enqueue_media();

            wp_enqueue_script('sabian_page_header_script', SABIAN_URL . 'js/admin/page_header.js', array('jquery'), false, true);
        }
    }
});

$GLOBALS["sabian_header_settings_nonce"] = 'sabian_header_settings_content_nonce';

function sabian_add_page_header_box() {

    $supports = sabian_get_header_page_supported_types();

    foreach ($supports as $sup) {
        add_meta_box(
                'sabian_header_box', 'Header Settings', 'sabian_page_header_settings', $sup, 'side', 'high'
        );
    }
}

function sabian_page_header_settings($post) {

    wp_nonce_field(plugin_basename(__FILE__), $GLOBALS["sabian_header_settings_nonce"]);

    $def_image = wp_specialchars(get_post_meta($post->ID, SABIAN_HEADER_PAGE_IMAGE_META, true));

    $def_title = wp_specialchars(get_post_meta($post->ID, SABIAN_HEADER_PAGE_TITLE_META, true));

    $display_header = get_post_meta($post->ID, SABIAN_HEADER_PAGE_DISPLAY_META, true);
    ?>

    <div class="form-group">

        <label class="checkbox">Display Header
            <input type="checkbox" name="sabian_display_header" <?php
            if ($display_header) {
                echo 'checked="checked"';
            }
            ?> />
        </label>

    </div>

    <div class="form-group">

        <label for="sabian-header-title">Header Title</label>

        <input type="text" id="sabian-header-title" name="sabian_header_title" class="form-control" placeholder="Enter Header Title" value="<?php echo $def_title; ?>" />

    </div>

    <div class="form-group">

        <input type="hidden" name="sabian_header_image" id="sabian_header_inp" value="<?php echo $def_image; ?>" />

        <label for="sabian-header-title">Header Image</label>

        <div class="img_container"><img src="<?php echo $def_image; ?>" id="sabian_header_img" /></div>

        <a class="btn btn-primary btn-block" id="sabian_header_image_btn" data-img="#sabian_header_img" data-input="#sabian_header_inp">Select Image</a>


        <?php
        $remove_attrs = [];

        if (($def_image && $def_image > -1) != true)
            $remove_attrs[] = "disabled=disabled";
        ?>

        <a class="btn btn-danger btn-block" <?php echo implode(" ", $remove_attrs); ?> id="sabian_header_image_remove_btn" data-img="#sabian_header_img" data-input="#sabian_header_inp">Remove Image</a>
    </div>





    <?php
}

function sabian_save_page_header_settings($post_id) {

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

    if (!wp_verify_nonce($_POST[$GLOBALS["sabian_header_settings_nonce"]], plugin_basename(__FILE__)))
        return;

    $supports = sabian_get_header_page_supported_types();

    if (!in_array($_POST["post_type"], $supports)) {
        return;
    }

    $img = $_POST['sabian_header_image'];

    $title = $_POST['sabian_header_title'];

    $display_header = isset($_POST['sabian_display_header']);

    sabian_update_meta_values($post_id, SABIAN_HEADER_PAGE_IMAGE_META, $img);

    sabian_update_meta_values($post_id, SABIAN_HEADER_PAGE_TITLE_META, $title);

    sabian_update_meta_values($post_id, SABIAN_HEADER_PAGE_DISPLAY_META, $display_header);
}

/**
 * 
 * @param WP_Post $post
 * @return array $title, $image or NULL
 */
function sabian_get_page_header_details($post) {

    $title = get_post_meta($post->ID, SABIAN_HEADER_PAGE_TITLE_META, true);

    $image = get_post_meta($post->ID, SABIAN_HEADER_PAGE_IMAGE_META, true);

    

    if (!$title) {
        $title = $post->post_title;
    }

    if (!$image || $image == -1) {
        
        $image = "";
        
        $thumbID= get_post_thumbnail_id($post);
        
        if($thumbID){
            $thumbID= wp_get_attachment_url($thumbID);
            if($thumbID!==FALSE){
                $image=$thumbID;
            }
        }
    }

    return array("title" => $title, "image" => $image);
}

/**
 * Whether to display the page header
 * @param WP_Post $post Description
 * @return boolean
 */
function sabian_can_display_page_header($post) {

    $display_header = get_post_meta($post->ID, SABIAN_HEADER_PAGE_DISPLAY_META, true);

    if (!$display_header) {
        return false;
    }

    return true;
}

/**
 * Gets a collection of all post types the page header settings support
 * @return array
 */
function sabian_get_header_page_supported_types() {

    $supports = array('page', 'post');

    $supports = apply_filters('sabian_page_header_supports', $supports);

    return $supports;
}
?>
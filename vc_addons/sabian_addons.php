<?php
add_action('vc_before_init', 'sabian_register_slider_addon');
add_action('vc_before_init', 'sabian_register_cta_addon');
add_action('vc_before_init', 'sabian_register_title_addon');
add_action('vc_before_init', 'sabian_register_overlay_addon');
add_action('vc_before_init', 'sabian_register_featured_categories_addon');
add_action('vc_before_init', 'sabian_register_featured_categories_list_addon');
add_action('vc_before_init', 'sabian_register_testimonial_slider_addon');
add_action('vc_before_init', 'sabian_register_product_slider_addon');
add_action('vc_before_init', 'sabian_register_content_image_slider_addon');
add_action('vc_before_init', 'sabian_register_button_addon');
add_action('vc_before_init', 'sabian_register_section_title_addon');
add_action('vc_before_init', 'sabian_register_team_addon');
add_action('vc_before_init', 'sabian_register_teams_addon');
add_action('vc_before_init', 'sabian_register_image_addon');
add_action('vc_before_init', 'sabian_register_icon_block_addon');
add_action('vc_before_init', 'sabian_register_map_addon');
add_action('vc_before_init', 'sabian_register_contact_form_addon');
add_action('vc_before_init', 'sabian_register_contact_info');
add_action('vc_before_init', 'sabian_register_contact_program');
add_action('vc_before_init', 'sabian_register_contact_social');
add_action('vc_before_init', 'sabian_register_team_box_addon');
add_action("vc_before_init", 'sabian_register_full_carousel_slider_addon');
add_action('vc_before_init', 'sabian_register_small_box_addon');
add_action('vc_before_init', 'sabian_register_info_box_addon');
add_action('vc_before_init', 'sabian_register_full_screen_slider_addon');
add_action('vc_before_init', 'sabian_register_bg_block_addon');
add_action('vc_before_init', 'sabian_register_carousel_slider_addon');
add_action('vc_before_init', 'sabian_register_blog_posts_slider_addon');
add_action('vc_before_init','sabian_register_icon_image_block_addon');
add_action('vc_before_init','sabian_register_clients_addon');
add_action('vc_before_init','sabian_register_transparent_contact_addon');


$GLOBALS["slider_carousel_ids"] = 909;

$GLOBALS["client_slider_carousel_ids"] = 909;

$GLOBALS["overlay_container_ids"] = 900;

$GLOBALS["img_slider_carousel_ids"] = 1909;

$GLOBALS["btn_ids"] = 2909;

$GLOBALS["post_slider_carousel_ids"] = 910;

function sabian_register_slider_addon() {
    $sabian_vc_addons = $GLOBALS["sabian_vc_addons"];
    $sabian_slider_opts = array();
    $sabian_category_blocks = array();
    $categories = array();
    $slider = $GLOBALS["sabian_slider_post"];
    $args = array("taxonomy" => $slider->cat_name, "orderby" => "name");
    $categories = get_categories($args);
    foreach ($categories as $cat) {

        $sabian_category_blocks[$cat->name] = "sabiancat::" . $cat->term_id;
    }
    $sabian_slider_opts[] = array(
        'type' => 'dropdown',
        'holder' => '',
        'class' => '',
        'heading' => __("Select Slider Category"),
        'param_name' => 'sabian_slider_category',
        'value' => $sabian_category_blocks,
        'description' => __('Select Category'),
    );
    $shortcode = array();
    $shortcode["title"] = "sabian_posts_slider";
    $shortcode["callback"] = "sabian_posts_slider_addon";
    $sabian_slider_addon = array(
        'name' => __('Sabian Slider'),
        'base' => $shortcode["title"],
        'category' => __($sabian_vc_addons->sabian_options),
        'params' => $sabian_slider_opts);
    $sabian_vc_addons->add_option($sabian_slider_addon, $shortcode);
}

function sabian_posts_slider_addon($attr, $content) {

    $cat_id = $attr["sabian_slider_category"];
    $total_posts = $attr["sabian_slider_posts"];
    $slider = $GLOBALS["sabian_slider_post"];
    $cat = explode("::", $cat_id);
    $posts = sabian_get_posts(array("post_type" => $slider->post_name), array('taxonomy' => $slider->cat_name,
        'field' => 'term_id',
        'terms' => $cat[1]
    ));
    $cont = '';
    $slide_images = array();
    foreach ($posts as $i => $post) {

        $image_link = "";
        if (has_post_thumbnail($post->ID)) {
            $imID = get_post_thumbnail_id($post->ID);
            $image_link = wp_get_attachment_url($imID);
            $slide_images[] = $image_link;
        }
    }
    ob_start();
    ?>

    <section class="section_banner shop rs-slider-wrapper visible-lg visible-md">

        <!--Start Layer Slider-->

        <div id="banner_rs_slider" class="banner_rs_slider">
            <ul class="rs-slider-items">

                <?php
                foreach ($posts as $i => $post) {
                    $image_link = "";
                    if (has_post_thumbnail($post->ID)) {
                        $imID = get_post_thumbnail_id($post->ID);
                        $image_link = wp_get_attachment_url($imID);
                    }
                    $is_first = $i == 0;
                    $page = get_post_meta($post->ID, $slider->link_meta_key, true);
                    $btnText = get_post_meta($post->ID, $slider->button_text_meta_key, true);
                    $page = WP_Post::get_instance($page);
                    $link = $page->guid;
                    ?>

                    <!--First Slide-->

                    <li data-transition="boxslide" data-slotamount="7">
                        <img src="<?php echo $image_link; ?>" />
                        <div class="tp-caption fade fadeout banner_caption_1 title"

                             data-x="5" 

                             data-y="center"

                             data-voffset="-90" 

                             data-speed="800"

                             data-start="700"

                             data-easing="Power4.easeOut"

                             data-endspeed="500"

                             data-endeasing="Power4.easeIn"
                             >
                            <h1><?php echo $post->post_title; ?></h1>
                        </div>
                        <div class="tp-caption customin customout banner_caption_container no-padding-left"

                             data-x="5" 

                             data-y="center"

                             data-voffset="0" 

                             data-customin="x:0;y:150;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.5;scaleY:0.5;skewX:0;skewY:0;opacity:0;transformPerspective:0;transformOrigin:50% 50%;"

                             data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"

                             data-start="1200" 

                             data-speed="800"

                             data-easing="Power4.easeOut"

                             data-endspeed="500"

                             data-endeasing="Power4.easeIn">


                            <div class="banner_description text_white banner_dark"><?php echo $post->post_excerpt; ?></div>
                        </div>

                        <div class="tp-caption skewfromleft skewtoright banner_caption_4"

                             data-x="5" 

                             data-y="center"

                             data-voffset="100" 

                             data-start="1500"

                             data-speed="800"

                             data-easing="Power4.easeOut"

                             data-endspeed="500"

                             data-endeasing="Power4.easeIn"

                             >

                            <a class="btn btn-primary btn-icon btn-eye" href="<?php echo $link; ?>"><?php echo $btnText; ?></a>

                        </div>

                    </li>

                    <!--End First Slide-->

                <?php } ?>
            </ul>
            <!--End Slider-->
        </div>
    </section>



    <!--Mobile Slider-->

    <section class="section_banner visible-xs visible-sm" id="section_banner" data-slide-images="<?php echo implode(",", $slide_images); ?>">
        <!--<div class="banner_mask"></div>-->
        <!--Start Carousel Slide-->

        <div id="banner_carousel" class="banner_carousel carousel" data-ride="carousel">
            <!--Carousel Controls-->

            <div class="banner-control control-left hidden-xs" id="slider_prev"><span><i class="fa fa-chevron-left"></i></span></div>

            <div class="banner-control control-right hidden-xs" id="slider_next"><span><i class="fa fa-chevron-right"></i></span></div>


            <ol class="banner-indicators carousel-indicators">

                <?php
                foreach ($posts as $j => $post) {
                    $is_active = $j == 0;
                    ?>

                    <li data-target="#banner_carousel" data-slide-to="<?php echo $j; ?>" class="<?php echo ($is_active) ? "active" : ""; ?>"></li>

                <?php } ?>

            </ol>   

            <!--End Controls-->


            <div class="banner_content content_centered">
                <div class="container">
                    <!--Start Carousel Inner-->

                    <div class="carousel-inner">
                        <?php
                        foreach ($posts as $k => $post) {
                            $is_active = $k == 0;
                            $page = get_post_meta($post->ID, $slider->link_meta_key, true);
                            $btnText = get_post_meta($post->ID, $slider->button_text_meta_key, true);
                            $page = WP_Post::get_instance($page);
                            $link = $page->guid;
                            ?>

                            <!--First Carousel-->

                            <div class="item <?php echo ($is_active) ? "active" : ""; ?>">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="banner_caption_1 animatedDown anim_step_1"><h1><?php echo $post->post_title; ?></h1></div>
                                        <div class="banner_caption_container animatedDown anim_step_2">
                                            <div class="banner_description text_white"><?php echo $post->post_excerpt; ?></div>
                                        </div>


                                        <div class="banner_caption_4 animatedDown anim_step_3">

                                            <a class="btn btn-primary btn-icon btn-eye" href="<?php echo $link; ?>"><?php echo $btnText; ?></a>

                                        </div>
                                    </div>
                                    <!--<div class="col-md-6">

                                    <img class="img-responsive pull-right" src="images/responsive-imac.png" />

                                    </div>-->
                                </div>
                            </div>

                            <!--End First Carousel-->

                        <?php } ?>

                    </div>

                    <!--End Carousel Inner-->
                </div>
            </div>
        </div>

        <!--End Slide Carousel-->
    </section>

    <?php
    $cont = ob_get_contents();
    ob_end_clean();
    return $cont;
}

function sabian_register_cta_addon() {

    $sabian_vc_addons = $GLOBALS["sabian_vc_addons"];
    $sabian_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Call To Action Description'),
        'param_name' => 'sabian_cta_description',
        'value' => __(''),
        'description' => __('Call To Action Description'),
    );
    $sabian_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Button Text'),
        'param_name' => 'sabian_cta_btn_text',
        'value' => __(''),
        'description' => __('Button Text'),
    );
    $pages = sabian_get_pages();
    foreach ($pages as $pag) {

        $sabian_page_blocks[$pag->post_title] = $pag->guid;
    }
    $sabian_opts[] = array(
        'type' => 'dropdown',
        'holder' => '',
        'class' => '',
        'heading' => __('Select Go To Page'),
        'param_name' => 'sabian_cta_link',
        'value' => $sabian_page_blocks,
        'description' => __('Select Go To Page'),
    );
    $shortcode = array();
    $shortcode["title"] = "sabian_cta";
    $shortcode["callback"] = "sabian_call_to_action";
    $sabian_slider_addon = array(
        'name' => __('Sabian Call To Action'),
        'base' => $shortcode["title"],
        'category' => __($sabian_vc_addons->sabian_options),
        'params' => $sabian_opts);
    $sabian_vc_addons->add_option($sabian_slider_addon, $shortcode);
}

function sabian_call_to_action($attr, $content) {

    $desc = $attr["sabian_cta_description"];
    $btnText = $attr["sabian_cta_btn_text"];
    $url = $attr["sabian_cta_link"];
    $cont = '<div class="call_to_action">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h2 class="message">' . $desc . '</h2>
                </div>
                <div class="col-md-4">
                    <a class="btn btn-white btn-icon btn-check btn-sm pull-right" href="' . $url . '">' . $btnText . '</a>
                </div>
            </div>
        </div>
    </div>';
    return $cont;
}

function sabian_register_title_addon() {

    $sabian_vc_addons = $GLOBALS["sabian_vc_addons"];
    $sabian_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Title'),
        'param_name' => 'sabian_title',
        'value' => __(''),
        'description' => __('Title'),
    );
    $sabian_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Extra Class Names'),
        'param_name' => 'sabian_extra_class',
        'value' => __(''),
        'description' => __('Extra Class Names'),
    );
    $shortcode = array();
    $shortcode["title"] = "sabian_title";
    $shortcode["callback"] = "sabian_title";
    $sabian_addon = array(
        'name' => __('Sabian Title'),
        'base' => $shortcode["title"],
        'category' => __($sabian_vc_addons->sabian_options),
        'params' => $sabian_opts);
    $sabian_vc_addons->add_option($sabian_addon, $shortcode);
}

function sabian_title($attr, $content) {

    $title = $attr["sabian_title"];
    $class = (isset($attr['sabian_extra_class'])) ? $attr['sabian_extra_class'] : '';
    if ($class != '') {
        
    }
    $cont = '<h2 class="text_condesed ' . $class . '" style="font-size: 20px"><span class="text_line_top">' . $title . '</span></h2>';
    return $cont;
}

function sabian_register_overlay_addon() {

    $sabian_vc_addons = $GLOBALS["sabian_vc_addons"];
    $sabian_opts[] = array(
        'type' => 'attach_image',
        'holder' => '',
        'class' => '',
        'heading' => __('Select Background Image'),
        'param_name' => 'sabian_overlay_image',
        'value' => __(''),
        'description' => __('Select Background Image'),
    );
    $sabian_opts[] = array(
        'type' => 'iconpicker',
        'heading' => __('Icon', 'js_composer'),
        'param_name' => 'sabian_overlay_icon',
        'settings' => array(
            'emptyIcon' => false, // default true, display an "EMPTY" icon?
            'type' => 'fontawesome',
            'iconsPerPage' => 200, // default 100, how many icons per/page to display
        ),
        'dependency' => array(
            'element' => 'icon_type',
            'value' => 'fontawesome',
        ),
        'description' => __('Select icon from library.', 'js_composer'),
    );
    $sabian_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Title'),
        'param_name' => 'sabian_overlay_title',
        'value' => __(''),
        'description' => __('Title'),
    );
    $sabian_opts[] = array(
        'type' => 'colorpicker',
        'holder' => 'div',
        'class' => '',
        'heading' => __('Background color'),
        'param_name' => 'sabian_overlay_color',
        'value' => SabianThemeSettings::getThemeColor(),
        'description' => __('Choose color for background'),
    );
    $sabian_opts[] = array(
        'type' => 'colorpicker',
        'holder' => 'div',
        'class' => '',
        'heading' => __('Text color'),
        'param_name' => 'sabian_overlay_text_color',
        'value' => "#fff",
        'description' => __('Choose color for text'),
    );



    $sabian_opts[] = array(
        'type' => 'textarea',
        'holder' => '',
        'class' => '',
        'heading' => __('Overlay Description'),
        'param_name' => 'sabian_overlay_description',
        'value' => __(''),
        'description' => __('Overlay Description'),
    );


    $sabian_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Overlay Button Text'),
        'param_name' => 'sabian_overlay_button_text',
        'value' => __(''),
        'description' => __('Overlay Button Text'),
    );
    $sabian_opts[] = array(
        'type' => 'dropdown',
        'heading' => 'Overlay Size',
        'param_name' => 'sabian_overlay_size',
        'value' => array('medium', 'small', 'large'),
    );
    $sabian_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Overlay Height'),
        'param_name' => 'sabian_overlay_height',
        'value' => __(''),
        'description' => __('Overlay Height in px'),
    );
    $pages = sabian_get_pages();
    foreach ($pages as $pag) {

        $sabian_page_blocks[$pag->post_title] = $pag->guid;
    }
    $sabian_opts[] = array(
        'type' => 'vc_link',
        'holder' => '',
        'class' => '',
        'heading' => __('Select Button Link'),
        'param_name' => 'sabian_overlay_button_link',
        'value' => __(''),
        'description' => __('Select Button Link'),
    );


    $sabian_opts[] = array(
        'type' => 'dropdown',
        'heading' => 'Select Icon Size',
        'param_name' => 'sabian_overlay_icon_size',
        'value' => array('medium', 'small', 'large'),
    );
    $sabian_opts[] = array(
        'type' => 'dropdown',
        'heading' => 'Select Overlay Type',
        'param_name' => 'sabian_overlay_type',
        'value' => array('centered', 'inline'),
    );


    $shortcode = array();
    $shortcode["title"] = "sabian_overlay_container";
    $shortcode["callback"] = "sabian_overlay_container";
    $sabian_addon = array(
        'name' => __('Sabian Overlay Container'),
        'base' => $shortcode["title"],
        'category' => __($sabian_vc_addons->sabian_options),
        'params' => $sabian_opts);
    $sabian_vc_addons->add_option($sabian_addon, $shortcode);
}

function sabian_overlay_container($attr, $content) {
    $attr = wp_parse_args($attr, array("sabian_overlay_text_color" => "#fff"));
    $image = $attr["sabian_overlay_image"];
    $icon = $attr["sabian_overlay_icon"];
    $type = $attr["sabian_overlay_type"]; //big or small
    $title = $attr["sabian_overlay_title"];
    $height = $attr["sabian_overlay_height"];
    $isize = $attr["sabian_overlay_icon_size"];
    $osize = $attr["sabian_overlay_size"];
    $text_color = $attr["sabian_overlay_text_color"];
    $max_height = '413px';
    $bsize = '100px';
    if (!$isize) {

        $isize = 'medium';
    }
    if (!$osize) {

        $osize = 'medium';
    }
    switch ($isize) {
        case 'medium':

            $isize = '30px';

            $bsize = '94px';

            break;
        case 'small':

            $isize = '26px';

            $bsize = '90px';

            break;
        case 'large':

            $isize = '36px';

            $bsize = '100px';

            break;
    }


    switch ($osize) {
        case 'medium':

            $osize = '60px';

            $max_height = '362px';

            break;
        case 'small':

            $osize = '40px';

            $max_height = '300px';

            break;
        case 'large':

            $osize = '70px';

            $max_height = '380px';

            break;
    }
    if ($height == "") {

        $height = "auto";
    }
    $height = $height . "px";
    $description = $attr["sabian_overlay_description"];
    $button_text = $attr["sabian_overlay_button_text"];
    $button_url = $attr["sabian_overlay_button_link"];
    $type = $attr["sabian_overlay_type"];
    $color = $attr['sabian_overlay_color'];
    $image = wp_get_attachment_url($image);
    $cID = ++$GLOBALS["overlay_container_ids"];
	
	$button_url=vc_build_link($button_url);
	
	if(is_array($button_url)){
        $button_url=$button_url['url'];
    }else{
		$button_url="#";	
	}
	
    $cont = '<style>

	#overlay_' . $cID . '{

		max-height:' . $max_height . ';	

		min-height:' . $max_height . ';	

		overflow-y:hidden;

                

	}
	
	.overlay_block#overlay_' . $cID . '{

		max-height:auto !important;	

		min-height: '.$height.';	

		overflow-y:hidden;
	}
	
	@media (max-width:468px){
		
		#overlay_' . $cID . '{

		max-height:none;	

		min-height:' . $max_height . ';	

		overflow-y:hidden;

                

	}
	
	.overlay_block#overlay_' . $cID . '{

		max-height:none !important;	

		min-height: '.$height.';	

		overflow-y:hidden;
		
		height:auto !important;
	}
			
	}
	#overlay_' . $cID . ':after, #overlay_block_'.$cID.':after{

		background: ' . $color . ' !important;

	}
	
	

	#overlay_' . $cID . ' .overlay_body{

		padding-top: ' . $osize . '; 

		padding-bottom: ' . $osize . '; 

	}

	#overlay_' . $cID . ' .overlay_icon{

		width:' . $bsize . '; 

		height:' . $bsize . ';

                border: 1px solid ' . $text_color . ';

                    color : ' . $text_color . ';

	}

	#overlay_' . $cID . ' .overlay_icon i{

		font-size:' . $isize . ' !important;

	}

	</style>';


 if ($type != 'inline'){
    $cont .= '<div class="overlay_container overlay_feature" style="background-image: url(' . $image . '); margin-top: 0px;" id="overlay_' . $cID . '">
                    <div class="overlay_body" style="padding-left : 10px; padding-right:10px">
                        <span class="overlay_icon" style="">
                            <i class="' . $icon . '" style=""></i>
                        </span>
                        <h4 class="overlay_title" style="color : ' . $text_color . ' !important;">' . $title . '</h4>
                        <p class="overlay_description text_block" style="color : ' . $text_color . ' !important;">' . $description . '</p>
                        <a class="btn" href="' . $button_url . '">' . $button_text . '</a>
                    </div>
                </div>';
 }
    if ($type == 'inline') {
        $cont.= '<div class="overlay_block overlay_black col_fluid" style="background-image:url(' . $image . '); height:' . $height . '" id="overlay_' . $cID . '"> 
<div class="overlay_body" style="padding-top:80px; padding-bottom:80px; padding-left:30px; padding-right:30px;">
<h3 class="overlay_title text_line_top no_margin_top">' . $title . '</h3>
<p class="overlay_description text-block text_condesed" style="font-size:17px">' . $description . '</p>
<a class="btn" href="' . $button_url . '">' . $button_text . '</a>
</div>
</div>';
    }
    return $cont;
}

function sabian_register_featured_categories_addon() {

    $sabian_vc_addons = $GLOBALS["sabian_vc_addons"];
    $sabian_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Title'),
        'param_name' => 'sabian_fc_title',
        'value' => __(''),
        'description' => __('Title'),
    );
    $sabian_opts[] = array(
        'type' => 'dropdown',
        'holder' => '',
        'class' => '',
        'heading' => __('Select Number of Categories'),
        'param_name' => 'sabian_fc_limit',
        'value' => array(3, 6, 9, 12),
        'description' => __('Select Number of Categories'),
    );
    $shortcode = array();
    $shortcode["title"] = "sabian_featured_categories";
    $shortcode["callback"] = "sabian_featured_categories";
    $sabian_addon = array(
        'name' => __('Sabian Featured Product Categories'),
        'base' => $shortcode["title"],
        'category' => __($sabian_vc_addons->sabian_options),
        'params' => $sabian_opts);
    $sabian_vc_addons->add_option($sabian_addon, $shortcode);
}

function sabian_featured_categories($attrs, $content) {
    $limit = $attrs["sabian_fc_limit"];
    $cont = '';
    $categories = sabian_get_product_categories();
    $fcats = array();
    foreach ($categories as $i => $cat) {
        $thumbID = sabian_get_category_image_id($cat->term_id);
        if ($thumbID == null | !$thumbID)
            continue;
        $fcats[] = $cat;
    }
    $cont .= '<div class="row">';
    //$cont.=print_r($fcats,true);
    foreach ($fcats as $j => $ncat) {
        if ($j >= $limit) {

            break;
        }

        $link = get_term_link((int) $ncat->term_id, "product_cat");
        if ($link instanceof WP_Error) {
            $link = "#";
        }
        $thumbID = sabian_get_category_image_id($ncat->term_id);
        $image = wp_get_attachment_url($thumbID);
        $cont .= '<div class="col-md-4 featured-category-cont">
                            <div class="thumbnail featured-category">
                                <div class="img" style="background-image: url(' . $image . ')"></div>
                                <div class="caption">

                                    <h3>' . sabian_get_ellipsis($ncat->name, 35) . '</h3>
                                    <a class="btn btn-primary" href="' . $link . '">View More</a>

                                </div>

                            </div>
                        </div>';
    }



    $cont .= '</div>';
    return $cont;
}

function sabian_register_featured_categories_list_addon() {

    $sabian_vc_addons = $GLOBALS["sabian_vc_addons"];
    $sabian_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Title'),
        'param_name' => 'sabian_fc_title',
        'value' => __(''),
        'description' => __('Title'),
    );
    $sabian_opts[] = array(
        'type' => 'dropdown',
        'holder' => '',
        'class' => '',
        'heading' => __('Select Number of Categories'),
        'param_name' => 'sabian_fc_limit',
        'value' => array(2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15),
        'description' => __('Select Number of Categories'),
    );
    $shortcode = array();
    $shortcode["title"] = "sabian_featured_categories_list";
    $shortcode["callback"] = "sabian_featured_categories_list";
    $sabian_addon = array(
        'name' => __('Sabian Featured Product Categories List'),
        'base' => $shortcode["title"],
        'category' => __($sabian_vc_addons->sabian_options),
        'params' => $sabian_opts);
    $sabian_vc_addons->add_option($sabian_addon, $shortcode);
}

function sabian_featured_categories_list($attrs, $content) {
    $limit = $attrs["sabian_fc_limit"];
    $title = $attrs["sabian_fc_title"];
    $cont = '<div class="category_title">
                            <span>' . $title . '</span>
                        </div>';
    $categories = sabian_get_product_categories();
    $fcats = array();
    foreach ($categories as $i => $cat) {
        if ($cat->count <= 0) {

            continue;
        }
        $fcats[] = $cat;
    }
    $cont .= '<ul class="categories highlight">';
    //$cont.=print_r($fcats,true);
    foreach ($fcats as $j => $ncat) {
        if ($j >= $limit) {

            break;
        }

        $link = get_term_link((int) $ncat->term_id, "product_cat");
        if ($link instanceof WP_Error) {
            $link = "#";
        }
        $cont .= '<li><a href="' . $link . '">' . $ncat->name . ' (' . $ncat->count . ')</a></li>';
    }
    $cont .= '</ul>';
    return $cont;
}

function sabian_register_testimonial_slider_addon() {

    $sabian_vc_addons = $GLOBALS["sabian_vc_addons"];
    $sabian_slider_opts = array();
    $sabian_category_blocks = array();
    $categories = array();
    $slider = $GLOBALS["sabian_testimonial_post"];
    $args = array("taxonomy" => $slider->cat_name, "orderby" => "name");
    $categories = get_categories($args);
    foreach ($categories as $cat) {

        $sabian_category_blocks[$cat->name] = "sabiancat::" . $cat->term_id;
    }
    $sabian_slider_opts[] = array(
        'type' => 'attach_image',
        'holder' => '',
        'class' => '',
        'heading' => __('Select Background Image'),
        'param_name' => 'sabian_testimonial_bg_image',
        'value' => __(''),
        'description' => __('Select Background Image'),
    );
    $sabian_slider_opts[] = array(
        'type' => 'dropdown',
        'holder' => '',
        'class' => '',
        'heading' => __("Select Category"),
        'param_name' => 'sabian_testimonial_category',
        'value' => $sabian_category_blocks,
        'description' => __('Select Category'),
    );
    $shortcode = array();
    $shortcode["title"] = "sabian_testimonials_slider";
    $shortcode["callback"] = "sabian_testimonials_slider";
    $sabian_slider_addon = array(
        'name' => __('Sabian Testimonials Slider'),
        'base' => $shortcode["title"],
        'category' => __($sabian_vc_addons->sabian_options),
        'params' => $sabian_slider_opts);
    $sabian_vc_addons->add_option($sabian_slider_addon, $shortcode);
}

function sabian_testimonials_slider($attrs, $content) {
    $cat = $attrs["sabian_testimonial_category"];
    $image = $attrs["sabian_testimonial_bg_image"];
    $image = wp_get_attachment_url($image);
    $cat = explode("::", $cat);
    $cat = $cat[1];
    $cont = '';
    $tpost = $GLOBALS["sabian_testimonial_post"];
    $test_posts = sabian_get_posts($cat, $tpost->post_name, $tpost->cat_name);
    $cont = '<section class="section_testimonial overlay_container overlay_feature overlay_bg_fixed" style="background-image:url(' . $image . ')">

	

	<div class="container">
        <div class="row">
            <div class="col-md-12 testimonial">
                <!--<div class="owl-carousel owl-theme owl-items" data-items="3">-->
                <div class="carousel-testimonials slide" id="carouselTestimonial">
                    <div class="owl-carousel owl-theme owl-single" id="carouselOwlTestimonial">';
    foreach ($test_posts as $test) {
        $unames = get_post_meta($test->ID, $tpost->user_name_meta_key, true);
        $uposition = get_post_meta($test->ID, $tpost->user_position_meta_key, true);
        $ucompany = get_post_meta($test->ID, $tpost->user_company_meta_key, true);
        $name = $test->post_title;
        $desc = $test->post_excerpt;
        $image_link = "";
        if (has_post_thumbnail($test->ID)) {
            $imID = get_post_thumbnail_id($test->ID);
            $image_link = wp_get_attachment_url($imID);
        }
        $cont .= '<div class="item">
                            <div class="testimonial_image" style="background-image:url(' . $image_link . '); background-position:-5px center"></div>
                            <h2 class="testimonial_heading">' . $name . '</h2>
                            <p class="testimonial_description">' . $desc . '</p>
                            <p class="testimonial_by"> By ' . $unames . ' <span>-' . $uposition . '  ' . $ucompany . '</span></p>
                        </div>';
    }
    $cont .= '</div>
                </div>
            </div>
        </div>
    </div>

	

	<ol class="carousel-indicators testimonial_indicators">

        <li data-target="#carouselOwlTestimonial" data-slide-to="0" class="active owl_carousel_nav"></li>

        <li data-target="#carouselOwlTestimonial" data-slide-to="1" class="owl_carousel_nav"></li>
    </ol>

	

	</section>

	';
    return $cont;
}

function sabian_register_product_slider_addon() {

    $sabian_vc_addons = $GLOBALS["sabian_vc_addons"];
    $cats = sabian_get_product_categories();
    $cats = array_filter($cats, function($cat) {
        return $cat->count > 0;
    });
    $scats = array();
    foreach ($cats as $cat) {
        $scats[$cat->name] = $cat->term_id;
    }
    $sabian_opts[] = array(
        'type' => 'dropdown',
        'holder' => '',
        'class' => '',
        'heading' => __('Select Category'),
        'param_name' => 'sabian_products_slider_cat',
        'value' => $scats,
        'description' => __('Select Category'),);
    $sabian_opts[] = array(
        'type' => 'dropdown',
        'holder' => '',
        'class' => '',
        'heading' => __('Product Limit'),
        'param_name' => 'sabian_products_slider_limit',
        'value' => array(2, 3, 4, 5, 6, 7, 8, 9, 10),
        'description' => __('Product Limit'),);
    $sabian_opts[] = array(
        'type' => 'dropdown',
        'holder' => '',
        'class' => '',
        'heading' => __('Product Column'),
        'param_name' => 'sabian_products_slider_columns',
        'value' => array(2, 4, 6, 8),
        'description' => __('Product Column'),);
    $shortcode = array();
    $shortcode["title"] = "sabian_products_slider_category";
    $shortcode["callback"] = "sabian_products_slider_category";
    $sabian_addon = array(
        'name' => __('Sabian Products Slider Category'),
        'base' => $shortcode["title"],
        'category' => __($sabian_vc_addons->sabian_options),
        'params' => $sabian_opts);
    $sabian_vc_addons->add_option($sabian_addon, $shortcode);
}

function sabian_products_slider_category($attrs, $content) {
    $cat_id = $attrs["sabian_products_slider_cat"];
    $column = $attrs["sabian_products_slider_columns"];
    $limit = $attrs["sabian_products_slider_limit"];
    $cont = '';
    $products = sabian_get_products_by_category($cat_id);
    $cat = sabian_get_product_category_by_id($cat_id);
    if (count($products) > 0) {
        $products = array_chunk($products, $limit);
        $products = $products[0];
    }
    ob_start();
    $sliderID = ++$GLOBALS["slider_carousel_ids"];
    $sliderID = "sabian_product_cat_" . $sliderID;
    $link = get_term_link((int) $cat->term_id, "product_cat");
    if ($link instanceof WP_Error) {

        $link = "#";
    }
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="category_title">
                    <span><a href="<?php echo $link; ?>"><?php echo $cat->name; ?></a> </span>
                </div>
                <div class="owl-carousel owl-theme owl-items" data-items="<?php echo $column; ?>" data-dots="true" id="<?php echo $sliderID; ?>">
                    <?php
                    foreach ($products as $i => $product) {
                        if ($i >= $limit)
                            break;
                        ?>
                        <?php sabian_get_product_template($product, apply_filters("sabian_main_wc_product_template", "1")); ?>
                    <?php } ?>
                </div>
                <div class="owl-nav">

                    <div class="owl-prev owl_carousel_nav" data-target="#<?php echo $sliderID; ?>" data-slide-to="prev"><i class="fa fa-angle-left"></i></div>

                    <div class="owl-next owl_carousel_nav" data-target="#<?php echo $sliderID; ?>" data-slide-to="next"><i class="fa fa-angle-right"></i></div>

                </div>
            </div>

        </div>
    </div>

    <?php
    $cont = ob_get_contents();
    ob_end_clean();
    return $cont;
}

function sabian_register_content_image_slider_addon() {
    $sabian_vc_addons = $GLOBALS["sabian_vc_addons"];
    $sabian_slider_opts = array();
    $sabian_slider_opts[] = array(
        'type' => 'attach_images',
        'holder' => '',
        'class' => '',
        'heading' => __('Select Slider Images'),
        'param_name' => 'sabian_slider_images',
        'value' => __(''),
        'description' => __('Select Slider Images'),
    );


    $sabian_slider_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Height (px)'),
        'param_name' => 'sabian_slider_height',
        'value' => __(''),
        'description' => __('Height (px)'),
    );

    $sabian_slider_opts[] = array(
        'type' => 'dropdown',
        'holder' => '',
        'class' => '',
        'heading' => __('Display Type'),
        'param_name' => 'display_type',
        'value' => array("Image" => 1, "Background Image" => 2),
        'description' => __('Display Type'),);
    $shortcode = array();
    $shortcode["title"] = "sabian_content_image_slider";
    $shortcode["callback"] = "sabian_content_image_slider";
    $sabian_icon_addon = array(
        'name' => __('Sabian Content Image Slider'),
        'base' => $shortcode["title"],
        'category' => __($sabian_vc_addons->sabian_options),
        'params' => $sabian_slider_opts);
    $sabian_vc_addons->add_option($sabian_icon_addon, $shortcode);
}

function sabian_content_image_slider($attrs, $content) {

    $attrs = wp_parse_args($attrs, array("display_type" => 2));

    extract($attrs);


    $images = $attrs["sabian_slider_images"];
    $height = $attrs["sabian_slider_height"];
    $height = ($height) ? $height : '413';
    $ins = array("inherit", "auto");
    if (!in_array($height, $ins)) {

        $height = $height . 'px';
    }
    $content = '';
    $slideImgs = array();
    $images = explode(",", $images);
    foreach ($images as $img) {
        $slideImgs[] = wp_get_attachment_url($img);
    }
    $id = ++$GLOBALS["img_slider_carousel_ids"];
    ob_start();
    ?>
    <div class="pos_relative">
        <div class="carousel col-carousel slide" data-ride="carousel" id="col_img_carousel_<?php echo $id; ?>">
            <div class="carousel-inner">
                <?php
                foreach ($slideImgs as $i => $img) {
                    $active = ($i == 0) ? "active" : "";
                    ?>

                    <div class="item <?php echo $active; ?>">

                        <?php if ($display_type == 2) { ?>

                            <div style="background-size:cover; background-repeat:no-repeat; background-position:center center; background-image:url(<?php echo $img; ?>); width:100%; height:<?php echo $height; ?>"></div>

                        <?php } else { ?>

                            <img class="img-responsive col-carousel-img" src="<?php echo $img; ?>" style="height:<?php echo $height; ?> !important" />
                        <?php } ?>
                    </div>

                <?php } ?>
            </div>
        </div>
        <?php if (count($images) > 1) { ?>
            <ol class="col-carousel-indicators">

                <li data-target="#col_img_carousel_<?php echo $id; ?>" data-slide-to="0" class="previous"><a style="background-image:url(<?php echo SABIAN_IMAGE_URL . "sliders/prev.png"; ?>);"></a></li>

                <li data-target="#col_img_carousel_<?php echo $id; ?>" data-slide-to="1" class="next"><a style="background-image:url(<?php echo SABIAN_IMAGE_URL . "sliders/next.png"; ?>);"></a></li>

            </ol>
        <?php } ?>


    </div>


    <?php
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}

function sabian_register_button_addon() {

    $sabian_vc_addons = $GLOBALS["sabian_vc_addons"];
    $sabian_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Button Text'),
        'param_name' => 'sabian_btn_title',
        'value' => __(''),
        'description' => __('Button Text'),
    );
    $sabian_opts[] = array(
        'type' => 'vc_link',
        'holder' => '',
        'class' => '',
        'heading' => __('Button Url'),
        'param_name' => 'sabian_btn_url',
        'value' => __(''),
        'description' => __('Button Url'),
        'dependency' => array(
            'element' => 'link',
            'value' => array('custom')
        ),
    );


    $sabian_opts[] = array(
        'type' => 'iconpicker',
        'heading' => __('Icon', 'js_composer'),
        'param_name' => 'sabian_btn_icon',
        'settings' => array(
            'emptyIcon' => false, // default true, display an "EMPTY" icon?
            'type' => 'fontawesome',
            'iconsPerPage' => 200, // default 100, how many icons per/page to display
        ),
        'dependency' => array(
            'element' => 'icon_type',
            'value' => 'fontawesome',
        ),
        'description' => __('Button Icon', 'js_composer'),
    );


    $sabian_opts[] = array(
        'type' => 'colorpicker',
        'holder' => 'div',
        'class' => '',
        'heading' => __('Background color'),
        'param_name' => 'sabian_btn_bg_color',
        'value' => SabianThemeSettings::getThemeColor(),
        'description' => __('Choose bg color for button'),
    );


    $sabian_opts[] = array(
        'type' => 'colorpicker',
        'holder' => 'div',
        'class' => '',
        'heading' => __('Font color'),
        'param_name' => 'sabian_btn_font_color',
        'value' => '#fff',
        'description' => __('Choose font color for button'),
    );
    $sabian_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Extra Class Names'),
        'param_name' => 'sabian_btn_class',
        'value' => __(''),
        'description' => __('Button Class Names'),
    );


    $sabian_opts[] = array(
        'type' => 'dropdown',
        'holder' => '',
        'class' => '',
        'heading' => __('Button Type/Size'),
        'param_name' => 'sabian_btn_size',
        'value' => array("Small", "Normal", "Large"),
        'description' => __('Button Type/Size'),);
    $shortcode = array();
    $shortcode["title"] = "sabian_vc_button";
    $shortcode["callback"] = "sabian_vc_button";
    $sabian_slider_addon = array(
        'name' => __('Sabian Button'),
        'base' => $shortcode["title"],
        'category' => __($sabian_vc_addons->sabian_options),
        'params' => $sabian_opts);
    $sabian_vc_addons->add_option($sabian_slider_addon, $shortcode);
}

function sabian_vc_button($attr, $content) {
    $title = $attr["sabian_btn_title"];
    $url = $attr["sabian_btn_url"];
    $icon = $attr["sabian_btn_icon"];
    $class = $attr["sabian_btn_class"];
    $size = $attr["sabian_btn_size"];
    $fColor = $attr["sabian_btn_font_color"];
    $bColor = $attr["sabian_btn_bg_color"];
    $id = ++$GLOBALS["btn_ids"];
    $id = "sb_btn_" . $id;
    $cont = '';
    if ($size == "Small") {

        $btn_size = 'btn-sm';
    } elseif ($size == "Normal") {

        $btn_size = 'btn-md';
    } else {

        $btn_size = 'btn-lg';
    }
    $classes = array();
    $classes[] = $btn_size;
    $classes[] = $class;
    $classes = implode(" ", $classes);
    $cont .= '<a href="' . $url . '" class="btn btn-primary ' . $classes . '" style="background-color:' . $bColor . '; color : ' . $fColor . '"><i class="' . $icon . '"></i>&nbsp;&nbsp;' . $title . '</a>';
    return $cont;
}

function sabian_register_section_title_addon() {

    $sabian_vc_addons = $GLOBALS["sabian_vc_addons"];
    $sabian_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Title'),
        'param_name' => 'sabian_title',
        'value' => __(''),
        'description' => __('Title'),
    );
    $sabian_opts[] = array(
        'type' => 'textarea',
        'holder' => '',
        'class' => '',
        'heading' => __('Section Description'),
        'param_name' => 'sabian_description',
        'value' => __(''),
        'description' => __('Section Description'),
    );
    $shortcode = array();
    $shortcode["title"] = "sabian_section_title";
    $shortcode["callback"] = "sabian_section_title";
    $sabian_addon = array(
        'name' => __('Sabian Section Title'),
        'base' => $shortcode["title"],
        'category' => __($sabian_vc_addons->sabian_options),
        'params' => $sabian_opts);
    $sabian_vc_addons->add_option($sabian_addon, $shortcode);
}

function sabian_section_title($attr, $content) {

    $title = $attr["sabian_title"];
    $description = $attr["sabian_description"];
    $cont = '<h2 class="text-center no_margin_top"><span class="text_line_top">' . $title . '</span></h2>';
    $cont .= '<p class="text-block-center">' . $description . '</p>';
    return $cont;
}

function sabian_register_teams_addon() {
    $sabian_vc_addons = $GLOBALS["sabian_vc_addons"];
    $sabian_opts = array();
    $sabian_opts[] = array(
        'type' => 'dropdown',
        'holder' => '',
        'class' => '',
        'heading' => __("Select Limit"),
        'param_name' => 'sabian_team_count',
        'value' => array(4, 5, 6, 7, 8, 9, 10, 20, 30),
        'description' => __('Select Course Limit'),
    );
    $sabian_opts[] = array(
        'type' => 'dropdown',
        'holder' => '',
        'class' => '',
        'heading' => __("Select Column Count"),
        'param_name' => 'sabian_team_column_count',
        'value' => array(2, 3, 4, 6),
        'description' => __('Select Column Count'),
    );

    $sabian_opts[] = array(
        'type' => 'dropdown',
        'holder' => '',
        'class' => '',
        'heading' => __("Style"),
        'param_name' => 'sabian_team_style',
        'value' => array("Show Image and Content" => 1, "Show Only Image" => 2),
        'description' => __('Select Display Style'),
    );
    $shortcode = array();
    $shortcode["title"] = "sabian_teams_addon";
    $shortcode["callback"] = "sabian_teams_addon";
    $sabian_addon = array(
        'name' => __('Sabian Team Members'),
        'base' => $shortcode["title"],
        'category' => __($sabian_vc_addons->sabian_options),
        'params' => $sabian_opts);
    $sabian_vc_addons->add_option($sabian_addon, $shortcode);
}

function sabian_teams_addon($attrs, $content) {

    $attrs = wp_parse_args($attrs, array("sabian_team_style" => 1, "category" => -1));

    extract($attrs);

    $limit = $attrs["sabian_team_count"];

    $cols = $attrs["sabian_team_column_count"];

    $teams = array();

    $cPost = $GLOBALS["sabian_team_post"];

    if ($category && $category > -1) {

        $tax_args = array('taxonomy' => $cPost->cat_name,
            'field' => 'term_id',
            'terms' => $category
        );
    }
    $post_args = array(
        "post_type" => $cPost->post_name,
        "posts_per_page" => $limit,
        'orderby' => 'modified',
        'order' => 'DESC',
    );



    $teams = sabian_get_posts($post_args, $tax_args);


    $cont = '';

    $sliderID = ++$GLOBALS["slider_carousel_ids"];

    //$cols=absint(12/$cols);
    ob_start();
    ?>

    <div class="owl-carousel owl-theme owl-items" data-items="<?php echo $cols; ?>" data-dots="true" id="<?php echo $sliderID; ?>">

        <?php
        foreach ($teams as $post) {
            $links = get_post_meta($post->ID, $cPost->social_meta_key, true);
            if ($links) {
                $links = json_decode($links, true);
            } else {

                $links = array();
            }
            $position = get_post_meta($post->ID, $cPost->team_position_meta_key, true);
            $name = $post->post_title;
            $image_link = "";
            if (has_post_thumbnail($post->ID)) {
                $imID = get_post_thumbnail_id($post->ID);
                $image_link = wp_get_attachment_url($imID);
            }
            ?>

            <div class="col-md-12">
                <div class="team_member">
                    <figure>

                        <img class="team_image img-responsive" src="<?php echo $image_link; ?>">


                        <?php if ($sabian_team_style == 1) { ?>
                            <figcaption>
                                <h2 class="team_title"><?php echo $name; ?></h2>
                                <p class="team_subtitle"><?php echo $position; ?></p>
                                <ul class="team_social_icons">

                                    <?php
                                    foreach ($links as $link) {
                                        extract($link);
                                        ?>

                                        <li><a href="<?php echo $url; ?>"><i class="fa fa-<?php echo $icon; ?>"></i></a></li>

                                    <?php } ?>
                                </ul>
                            </figcaption>

                        <?php } ?>

                    </figure>


                </div>

            </div>
        <?php } ?>


    </div>
    <?php
    $cont = ob_get_contents();
    ob_end_clean();
    return $cont;
}

function sabian_register_team_addon() {
    $sabian_vc_addons = $GLOBALS["sabian_vc_addons"];
    $sabian_team_opts = array();
    $sabian_team_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Member Name'),
        'param_name' => 'sabian_member_name',
        'value' => __(''),
        'description' => __('Enter Name of Member'),
    );
    $sabian_team_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Member Role'),
        'param_name' => "sabian_member_role",
        'value' => __(''),
        'description' => __('Enter Role of The Member'),
    );
    $sabian_team_opts[] = array(
        'type' => 'attach_image',
        'holder' => '',
        'class' => '',
        'heading' => __('Upload Image of Member'),
        'param_name' => 'sabian_member_image',
        'value' => __(''),
        'description' => __('Upload Image of Member'),
    );
    /* $sabian_team_opts[]=array(

      'type' => 'textarea',

      'holder' => '',

      'class' => '',

      'heading' => __( 'Enter description of member' ),

      'param_name' => "sabian_member_description",

      'value' => __( '' ),

      'description' => __( 'Enter description of member' ),

      ); */
    $sabian_team_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Facebook Link'),
        'param_name' => "sabian_member_facebook",
        'value' => __(''),
        'description' => __('Facebook Link'),
    );
    $sabian_team_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Twitter Link'),
        'param_name' => "sabian_member_twitter",
        'value' => __(''),
        'description' => __('Twitter Link'),
    );
    $sabian_team_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Google Plus Link'),
        'param_name' => "sabian_member_google",
        'value' => __(''),
        'description' => __('Google Plus Link'),
    );


    $sabian_team_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Linked In Link'),
        'param_name' => "sabian_member_linkedin",
        'value' => __(''),
        'description' => __('Linked In Link'),
    );

    $sabian_team_opts[] = array(
        'type' => 'dropdown',
        'holder' => '',
        'class' => '',
        'heading' => __('Display Type'),
        'param_name' => "display_type",
        'value' => array("Image and Text" => 1, "Image" => 2),
        'description' => __('Select display type'),
    );

    $shortcode = array();
    $shortcode["title"] = "sabian_team_member";
    $shortcode["callback"] = "sabian_team_member";
    $sabian_icon_addon = array(
        'name' => __('Sabian Team Member'),
        'base' => $shortcode["title"],
        'category' => __($sabian_vc_addons->sabian_options),
        'params' => $sabian_team_opts);
    $sabian_vc_addons->add_option($sabian_icon_addon, $shortcode);
}

function sabian_team_member($attrs, $content) {

    $cont = '';

    $attrs = wp_parse_args($attrs, array("display_type" => 1));

    extract($attrs);

    $image = isset($attrs["sabian_member_image"]) ? wp_get_attachment_url($attrs["sabian_member_image"]) : "";
    $role = isset($attrs["sabian_member_role"]) ? $attrs["sabian_member_role"] : "";
    $name = $attrs["sabian_member_name"];
    //$description=$attrs["sabian_member_description"];
    $social = array();
    if (isset($attrs["sabian_member_facebook"]))
        $social[] = '<li><a href="' . $attrs["sabian_member_facebook"] . '"><i class="fa fa-facebook"></i></a></li>';
    if (isset($attrs["sabian_member_twitter"]))
        $social[] = '<li><a href="' . $attrs["sabian_member_twitter"] . '"><i class="fa fa-twitter"></i></a></li>';
    if (isset($attrs["sabian_member_google"]))
        $social[] = '<li><a href="' . $attrs["sabian_member_google"] . '"><i class="fa fa-google-plus"></i></a></li>';
    if (isset($attrs["sabian_member_linkedin"]))
        $social[] = '<li><a href="' . $attrs["sabian_member_linkedin"] . '"><i class="fa fa-linkedin"></i></a></li>';
    $cont .= '<div class="team_member">
<figure>

<img class="team_image img-responsive" src="' . $image . '">';

    if ($display_type == 1) {

        $cont .= '<figcaption>

<h2 class="team_title">' . $name . '</h2>

<p class="team_subtitle">' . $role . '</p>

<ul class="team_social_icons">

' . implode("", $social) . '

</ul>

</figcaption>';
    }

    $cont .= '</figure>

</div>';
    return $cont;
}

function sabian_register_image_addon() {
    $sabian_vc_addons = $GLOBALS["sabian_vc_addons"];
    $sabian_slider_opts = array();
    $sabian_slider_opts[] = array(
        'type' => 'attach_image',
        'holder' => '',
        'class' => '',
        'heading' => __('Select Image'),
        'param_name' => 'sabian_image',
        'value' => __(''),
        'description' => __('Select Image'),
    );


    $sabian_slider_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Height (px)'),
        'param_name' => 'sabian_image_height',
        'value' => __(''),
        'description' => __('Height (px)'),
    );
    $shortcode = array();
    $shortcode["title"] = "sabian_image_addon";
    $shortcode["callback"] = "sabian_image_addon";
    $sabian_icon_addon = array(
        'name' => __('Sabian Image'),
        'base' => $shortcode["title"],
        'category' => __($sabian_vc_addons->sabian_options),
        'params' => $sabian_slider_opts);
    $sabian_vc_addons->add_option($sabian_icon_addon, $shortcode);
}

function sabian_image_addon($attrs, $content) {
    $img = $attrs["sabian_image"];
    $height = $attrs["sabian_image_height"];
    $height = ($height) ? $height : '413';
    $ins = array("inherit", "auto");
    if (!in_array($height, $ins)) {

        $height = $height . 'px';
    }
    $content = '';
    $img = wp_get_attachment_url($img);
    $content = '<img class="img-responsive col-carousel-img" src="' . $img . '" style="height:' . $height . ' !important" />';
    return $content;
}

function sabian_register_icon_block_addon() {
    $sabian_vc_addons = $GLOBALS["sabian_vc_addons"];
    $sabian_icon_opts = array();
    $sabian_icon_opts[] = array(
        'type' => 'iconpicker',
        'heading' => __('Icon', 'js_composer'),
        'param_name' => 'sabian_icon',
        'settings' => array(
            'emptyIcon' => false, // default true, display an "EMPTY" icon?
            'type' => 'fontawesome',
            'iconsPerPage' => 200, // default 100, how many icons per/page to display
        ),
        'dependency' => array(
            'element' => 'icon_type',
            'value' => 'fontawesome',
        ),
        'description' => __('Select icon from library.', 'js_composer'),
    );
    $sabian_icon_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Icon Title'),
        'param_name' => 'sabian_icon_title',
        'value' => __(''),
        'description' => __('Enter Service Title'),
    );
    $sabian_icon_opts[] = array(
        'type' => 'textarea_html',
        'holder' => '',
        'class' => '',
        'heading' => __('Enter Service Description'),
        'param_name' => "content",
        'value' => __(''),
        'description' => __('Enter Description'),
    );
   $sabian_icon_opts[] = array(
        'type' => 'dropdown',
        'holder' => '',
        'class' => '',
        'heading' => __('Icon Block Type'),
        'param_name' => 'sabian_icon_type',
        'value' => array("List" => "list", "Side" => "side","Boxed"=>"boxed"),
        'description' => __('Select Block Type'),
    );


    $shortcode = array();
    $shortcode["title"] = "sabian_icon_block";
    $shortcode["callback"] = "sabian_icon_block";
    $sabian_icon_addon = array(
        'name' => __('Sabian Service Block'),
        'base' => $shortcode["title"],
        'category' => __($sabian_vc_addons->sabian_options),
        'params' => $sabian_icon_opts);
    $sabian_vc_addons->add_option($sabian_icon_addon, $shortcode);
}

function sabian_icon_block($attrs, $content = null) {

    $icon = $attrs["sabian_icon"];

    $title = $attrs["sabian_icon_title"];

    $description = $content;

    $type = $attrs["sabian_icon_type"];

    switch ($type) {

        case "list":

            return sabian_icon_block_list($icon, $title, $description);

            break;

        case "side":

            return sabian_icon_block_side($icon, $title, $description);

            break;
			
			case "boxed":
			
			return sabian_icon_block_service($icon,$title,$description);
			
			break;

        default:

            return sabian_icon_block_list($icon, $title, $description);

            break;
    }
}

function sabian_icon_block_list($icon, $title, $description) {
    $content = '<div class="featured_item">
<div class="featured_item_icon">

<div class="circle_icon">

<i class="' . $icon . '"></i>

</div>

</div>
<div class="featured_item_title">

<h4>' . $title . '</h4>

</div>
<div class="featured_item_content">

' . $description . '

</div>
</div>';
    return $content;
}

function sabian_icon_block_side($icon, $title, $description) {
    $cont = '<div class="service-block service-block-1">

                            <div class="service-block-item">

                                <i class="' . $icon . '"></i>

                            </div>

                            <div class="service-block-body">

                                <h4 class="">' . $title . '</h4>

                                <p>' . $description . '</p>

                            </div>

                        </div>';


    return $cont;
}
function sabian_icon_block_service($icon,$title,$description){
	
	$cont='';
	
	ob_start();
	
	?>
    <div class="service service-boxed">
    <!-- single info block -->
				<div class="info text-center info-boxed">
					<div class="icon icon-circle">
						<i class="<?php echo $icon; ?>" aria-hidden="true"></i>
					</div>
					<div class="description">
						<h5 class="service-title"><?php echo $title; ?></h5>
						<p class="description"><?php echo $description; ?></p>
					</div>
				</div><!-- single info block ends -->
		
    </div>
    
    <?php
	$cont=ob_get_contents();
	
	ob_end_clean();
	
	return $cont;
}
function sabian_register_map_addon() {
    $sabian_vc_addons = $GLOBALS["sabian_vc_addons"];
    $sabian_map_opts = array();
    $sabian_map_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Latitude Cordinates'),
        'param_name' => 'sabian_latitude',
        'value' => __(''),
        'description' => __('Enter Latitude Cordinates'),
    );
    $sabian_map_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Longitude Cordinates'),
        'param_name' => "sabian_longitude",
        'value' => __(''),
        'description' => __('Enter Longitude Cordinates'),
    );


    $sabian_map_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Enter City'),
        'param_name' => "sabian_city",
        'value' => __(''),
        'description' => __('Enter City'),
    );
    $sabian_map_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Enter Country'),
        'param_name' => "sabian_country",
        'value' => __(''),
        'description' => __('Enter Country'),
    );


    $sabian_map_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Enter Place/Street Name'),
        'param_name' => "sabian_place",
        'value' => __(''),
        'description' => __('Enter Place/Street Name'),
    );

    $shortcode = array();
    $shortcode["title"] = "sabian_map";
    $shortcode["callback"] = "sabian_map";
    $sabian_icon_addon = array(
        'name' => __('Sabian Map'),
        'base' => $shortcode["title"],
        'category' => __($sabian_vc_addons->sabian_options),
        'params' => $sabian_map_opts);
    $sabian_vc_addons->add_option($sabian_icon_addon, $shortcode);
}

function sabian_map($attrs, $content) {
    $latitude = $attrs['sabian_latitude'];
    $longitude = $attrs['sabian_longitude'];
    $image_logo = sabian_get_logo_url();
    $city = $attrs["sabian_city"];
    $country = $attrs["sabian_country"];
    $place = $attrs["sabian_place"];
    $title = get_bloginfo('name');
    $cont = '<div class="col-md-12">

                        

                        

                    <div id="sabian_map" class="contact_map"></div>

                    

                    <div class="sabian_the_map_container" style="display:none" data-icon="' . SABIAN_IMAGE_URL . 'icons/pin_blue.png" data-latitude="' . $latitude . '" data-longitude="' . $longitude . '" data-map-window="#sabian_map_window">

                                            

                                            <div class="wp-block property list sabian_map_window" id="sabian_map_window">

                                    

                                    <div class="wp-block-body map_window_body">

                                        <div class="wp-block-img map_window_image">

                                            <a href="#" hidefocus="true">

                                            

                                                <img src="' . $image_logo . '" class="" alt="">

                                            </a>

                                        </div>

                                        <div class="wp-block-content clearfix">

                                            <h4 class="content-title" style="font-size:14px">' . $title . '</h4>

                                            

                                            <small>' . $place . '</small>

                                            <p class="description">' . $city . ' ' . $country . '</p>

                                            

                                            </div>

                                    </div>

                                    

                                </div>

                                            

                                            </div>

                        

                       

                        

                    </div>';
    return $cont;
}

function sabian_register_contact_form_addon() {
    $sabian_vc_addons = $GLOBALS["sabian_vc_addons"];
    $sabian_cform_opts = array();
    $sabian_cform_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Title'),
        'param_name' => 'sabian_title',
        'value' => __(''),
        'description' => __('Enter Section Title'),
    );
    $sabian_cform_opts[] = array(
        'type' => 'textarea_html',
        'holder' => '',
        'class' => '',
        'heading' => __('Enter brief message'),
        'param_name' => "content",
        'value' => __(''),
        'description' => __('Enter brief message'),
    );
	$sabian_cform_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Contact Form 7 ID'),
        'param_name' => 'c7_id',
        'value' => __(''),
        'description' => __('Contact Form 7 ID'),
    );
    $shortcode = array();
    $shortcode["title"] = "sabian_contact_form";
    $shortcode["callback"] = "sabian_contact_form";
    $sabian_cform_addon = array(
        'name' => __('Sabian Contact Form'),
        'base' => $shortcode["title"],
        'category' => __($sabian_vc_addons->sabian_options),
        'params' => $sabian_cform_opts);
    $sabian_vc_addons->add_option($sabian_cform_addon, $shortcode);
}

function sabian_contact_form($attrs, $content) {
    $title = $attrs["sabian_title"];
    $message = $content;
	$c7=$attrs["c7_id"];
    $cont = '<div class="section-title-wr">

                            <h3 class="section-title left"><span>' . $title . '</span></h3>

                        </div>

                        <p>' . $message . '

                        </p>';

                        if($c7) {
							
							$cont.='<div class="form-light">';
							$cshortcode='[contact-form-7 id="'.$c7.'"]';
							
							$cont.=do_shortcode($cshortcode);
							$cont.='</div>';
							 }
						
						else {
                        $cont.='<form class="form-light" role="form">

                            <div class="form-group">

                                <label>Name</label>

                                <input type="text" class="form-control" placeholder="Your name">

                            </div>

                            <div class="row">

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label>Email</label>

                                        <input type="email" class="form-control" placeholder="Email address">

                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label>Phone</label>

                                        <input type="text" class="form-control" placeholder="Phone number">

                                    </div>

                                </div>

                            </div>

                            <div class="form-group">

                                <label>Subject</label>

                                <input type="text" class="form-control" placeholder="Subject">

                            </div>

                            <div class="form-group">

                                <label>Message</label>

                                <textarea class="form-control" id="message" placeholder="Write you message here..." style="height:100px;"></textarea>

                            </div>

                            <div class="row">

                                <div class="col-md-6">

                                    <button type="reset" class="btn btn-light btn-md">Reset</button>

                                </div>

                                <div class="col-md-6">

                                    <button type="submit" class="btn btn-base btn-md btn-icon btn-icon-right btn-fly pull-right">

                                        <span>Send message</span>

                                    </button>

                                </div>

                            </div>

                        </form>';
						
						}
    return $cont;
}

function sabian_register_contact_info() {
    $sabian_vc_addons = $GLOBALS["sabian_vc_addons"];
    $sabian_cform_opts = array();
    $sabian_cform_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Title'),
        'param_name' => 'sabian_title',
        'value' => __(''),
        'description' => __('Enter Section Title'),
    );
    $sabian_cform_opts[] = array(
        'type' => 'textarea',
        'holder' => '',
        'class' => '',
        'heading' => __('Address'),
        'param_name' => 'sabian_address',
        'value' => __(''),
        'description' => __('Enter Address'),
    );
    $sabian_cform_opts[] = array(
        'type' => 'textarea',
        'holder' => '',
        'class' => '',
        'heading' => __('Email'),
        'param_name' => 'sabian_email',
        'value' => __(''),
        'description' => __('Enter Email'),
    );


    $sabian_cform_opts[] = array(
        'type' => 'textarea',
        'holder' => '',
        'class' => '',
        'heading' => __('Phone'),
        'param_name' => 'sabian_phone',
        'value' => __(''),
        'description' => __('Enter Phone'),
    );
    $shortcode = array();
    $shortcode["title"] = "sabian_contact_info";
    $shortcode["callback"] = "sabian_contact_info";
    $sabian_cform_addon = array(
        'name' => __('Sabian Contact Info'),
        'base' => $shortcode["title"],
        'category' => __($sabian_vc_addons->sabian_options),
        'params' => $sabian_cform_opts);
    $sabian_vc_addons->add_option($sabian_cform_addon, $shortcode);
}

function sabian_contact_info($attrs, $content) {
    $title = $attrs["sabian_title"];
    $address = (isset($attrs["sabian_address"])) ? $attrs["sabian_address"] : null;
    $email = (isset($attrs["sabian_email"])) ? $attrs["sabian_email"] : null;
    $phone = (isset($attrs["sabian_phone"])) ? $attrs["sabian_phone"] : null;
    $cont = '<div class="section-title-wr">

                                    <h3 class="section-title left"><span>' . $title . '</span></h3>

                                </div>

								

                                <div class="contact-info">';
    if ($address)
        $cont .= '<h5><i class="fa fa-map-marker"></i> Address</h5>

                                    <p>' . $address . '</p>';
    if ($email)
        $cont .= '<h5><i class="fa fa-envelope"></i> Email</h5>

                                    <p>' . $email . '</p>';
    if ($phone)
        $cont .= '<h5><i class="fa fa-phone"></i> Phone</h5>

                                    <p>' . $phone . '</p>';


    $cont .= '</div>';
    return $cont;
}

function sabian_register_contact_program() {
    /* $title=$attrs["sabian_title"];
      $weekdays=(isset($attrs["sabian_weekday"]))?$attrs["sabian_weekday"]:null;
      $saturday=(isset($attrs["sabian_saturday"]))?$attrs["sabian_saturday"]:null;
      $sunday=(isset($attrs["sabian_sunday"]))?$attrs["sabian_sunday"]:null; */
    $sabian_vc_addons = $GLOBALS["sabian_vc_addons"];
    $sabian_cform_opts = array();
    $sabian_cform_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Title'),
        'param_name' => 'sabian_title',
        'value' => __(''),
        'description' => __('Enter Section Title'),
    );
    $sabian_cform_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Weekday Program'),
        'param_name' => 'sabian_weekday',
        'value' => __(''),
        'description' => __('Enter Weekday Program e.g 8:00 AM - 5:00 PM'),
    );
    $sabian_cform_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Saturday Program'),
        'param_name' => 'sabian_saturday',
        'value' => __(''),
        'description' => __('Enter Saturday Program e.g 8:00 AM - 1:00 PM'),
    );


    $sabian_cform_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Sunday Program'),
        'param_name' => 'sabian_sunday',
        'value' => __(''),
        'description' => __('Enter Sunday Program e.g 8:00 AM - 1:00 PM or CLOSED'),
    );
    $shortcode = array();
    $shortcode["title"] = "sabian_contact_program";
    $shortcode["callback"] = "sabian_contact_program";
    $sabian_cform_addon = array(
        'name' => __('Sabian Contact Program'),
        'base' => $shortcode["title"],
        'category' => __($sabian_vc_addons->sabian_options),
        'params' => $sabian_cform_opts);
    $sabian_vc_addons->add_option($sabian_cform_addon, $shortcode);
}

function sabian_contact_program($attrs, $cont) {
    $title = $attrs["sabian_title"];
    $weekdays = (isset($attrs["sabian_weekday"])) ? $attrs["sabian_weekday"] : null;
    $saturday = (isset($attrs["sabian_saturday"])) ? $attrs["sabian_saturday"] : null;
    $sunday = (isset($attrs["sabian_sunday"])) ? $attrs["sabian_sunday"] : null;
    $cont = '<div class="section-title-wr">

                                    <h3 class="section-title left"><span>' . $title . '</span></h3>

                                </div>';
    if ($weekdays)
        $cont .= '<div class="contact-info">

                                    <h5><i class="fa fa-check"></i> Monday - Friday</h5>

                                    <p>' . $weekdays . '</p>';
    if ($saturday) {

        $sat_icon = "fa fa-check";

        if ($saturday == "" || preg_match("/\bclosed\b/i", $saturday)) {
            $sat_icon = "fa fa-times";
        }

        $cont .= '<h5><i class="' . $sat_icon . '"></i> Saturday</h5>

                                    <p>' . $saturday . '</p>';
    }
    if ($sunday) {

        $sun_icon = "fa fa-check";

        if ($sunday == "" || preg_match("/\bclosed\b/i", $sunday)) {
            $sun_icon = "fa fa-times";
        }

        $cont .= '<h5><i class="' . $sun_icon . '"></i> Sunday</h5>

                                    <p>' . $sunday . '</p>';
    }


    $cont .= '</div>';
    return $cont;
}

function sabian_register_contact_social() {
    $sabian_vc_addons = $GLOBALS["sabian_vc_addons"];
    $sabian_cform_opts = array();
    $sabian_cform_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Title'),
        'param_name' => 'sabian_title',
        'value' => __(''),
        'description' => __('Enter Section Title'),
    );

    $sabian_cform_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Brief Description'),
        'param_name' => 'sabian_description',
        'value' => __(''),
        'description' => __('Enter Brief Description'),
    );
    $socials = array("facebook", "twitter", "linkedin", "google", "instagram", "youtube");
    foreach ($socials as $social) {
        $sabian_cform_opts[] = array(
            'type' => 'textfield',
            'holder' => '',
            'class' => '',
            'heading' => __(ucfirst($social)),
            'param_name' => 'sabian_social_' . $social,
            'value' => __(''),
            'description' => __('Enter ' . ucfirst($social) . ' URL'),
        );
    }
    $shortcode = array();
    $shortcode["title"] = "sabian_contact_social_icons";
    $shortcode["callback"] = "sabian_contact_social_icons";
    $sabian_cform_addon = array(
        'name' => __('Sabian Contact Social Info'),
        'base' => $shortcode["title"],
        'category' => __($sabian_vc_addons->sabian_options),
        'params' => $sabian_cform_opts);
    $sabian_vc_addons->add_option($sabian_cform_addon, $shortcode);
}

function sabian_contact_social_icons($attrs, $content) {
    $cont = '';
    $title = $attrs["sabian_title"];
    $description = $attrs["sabian_description"];
    $social = array();
    if (isset($attrs["sabian_social_facebook"]))
        $social[] = '<a href="' . $attrs["sabian_social_facebook"] . '"><i class="fa fa-facebook facebook"></i></a>';
    if (isset($attrs["sabian_social_twitter"]))
        $social[] = '<a href="' . $attrs["sabian_social_twitter"] . '"><i class="fa fa-twitter twitter"></i></a>';
    if (isset($attrs["sabian_social_google"]))
        $social[] = '<a href="' . $attrs["sabian_social_google"] . '"><i class="fa fa-google-plus google"></i></a>';
    if (isset($attrs["sabian_social_instagram"]))
        $social[] = '<a href="' . $attrs["sabian_social_instagram"] . '"><i class="fa fa-instagram instagram"></i></a>';
    if (isset($attrs["sabian_social_linkedin"]))
        $social[] = '<a href="' . $attrs["sabian_social_linkedin"] . '"><i class="fa fa-linkedin linkedin"></i></a>';
    if (isset($attrs["sabian_social_youtube"]))
        $social[] = '<a href="' . $attrs["sabian_social_youtube"] . '"><i class="fa fa-youtube-play youtube"></i></a>';
    $cont .= '<div class="section-title-wr">

                            <h3 class="section-title left"><span>' . $title . '</span></h3>

							

                        </div>';
    $cont .= '<p>' . $description . '

                        </p>';
    $cont .= '<div class="social-media">

						' . implode(" ", $social) . '

                        </div>';
    return $cont;
}

function sabian_register_team_box_addon() {
    $sabian_vc_addons = $GLOBALS["sabian_vc_addons"];
    $sabian_team_opts = array();
    $sabian_team_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Member Name'),
        'param_name' => 'sabian_member_name',
        'value' => __(''),
        'description' => __('Enter Name of Member'),
    );
    $sabian_team_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Member Role'),
        'param_name' => "sabian_member_role",
        'value' => __(''),
        'description' => __('Enter Role of The Member'),
    );
    $sabian_team_opts[] = array(
        'type' => 'attach_image',
        'holder' => '',
        'class' => '',
        'heading' => __('Upload Image of Member'),
        'param_name' => 'sabian_member_image',
        'value' => __(''),
        'description' => __('Upload Image of Member'),
    );
    $sabian_team_opts[] = array(
        'type' => 'textarea',
        'holder' => '',
        'class' => '',
        'heading' => __('Enter description of member'),
        'param_name' => "sabian_member_description",
        'value' => __(''),
        'description' => __('Enter description of member'),
    );
    $sabian_team_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Facebook Link'),
        'param_name' => "sabian_member_facebook",
        'value' => __(''),
        'description' => __('Facebook Link'),
    );
    $sabian_team_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Twitter Link'),
        'param_name' => "sabian_member_twitter",
        'value' => __(''),
        'description' => __('Twitter Link'),
    );
    $sabian_team_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Google Plus Link'),
        'param_name' => "sabian_member_google",
        'value' => __(''),
        'description' => __('Google Plus Link'),
    );


    $sabian_team_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Linked In Link'),
        'param_name' => "sabian_member_linkedin",
        'value' => __(''),
        'description' => __('Linked In Link'),
    );

    $shortcode = array();
    $shortcode["title"] = "sabian_team_member_box";
    $shortcode["callback"] = "sabian_team_member_box";
    $sabian_icon_addon = array(
        'name' => __('Sabian Team Member Box'),
        'base' => $shortcode["title"],
        'category' => __($sabian_vc_addons->sabian_options),
        'params' => $sabian_team_opts);
    $sabian_vc_addons->add_option($sabian_icon_addon, $shortcode);
}

function sabian_team_member_box($attrs, $content) {
    $cont = '';
    $image = isset($attrs["sabian_member_image"]) ? wp_get_attachment_url($attrs["sabian_member_image"]) : "";
    $role = isset($attrs["sabian_member_role"]) ? $attrs["sabian_member_role"] : "";
    $name = $attrs["sabian_member_name"];
    $description = $attrs["sabian_member_description"];
    $social = array();
    if (isset($attrs["sabian_member_facebook"]))
        $social[] = '<li><a href="' . $attrs["sabian_member_facebook"] . '"><i class="fa fa-facebook"></i></a></li>';
    if (isset($attrs["sabian_member_twitter"]))
        $social[] = '<li><a href="' . $attrs["sabian_member_twitter"] . '"><i class="fa fa-twitter"></i></a></li>';
    if (isset($attrs["sabian_member_google"]))
        $social[] = '<li><a href="' . $attrs["sabian_member_google"] . '"><i class="fa fa-google-plus"></i></a></li>';
    if (isset($attrs["sabian_member_linkedin"]))
        $social[] = '<li><a href="' . $attrs["sabian_member_linkedin"] . '"><i class="fa fa-linkedin"></i></a></li>';
    $cont .= '<div class="blog_block team_member_box">
<div class="blog_header">

<img class="img-responsive" src="' . $image . '">

</div>


<div class="blog_body">
<h2 class="blog_title"><a>' . $name . '</a></h2>
<p class="blog_tags">' . $role . '</p>
<p class="blog_content">' . $description . '</p>
</div>


<div class="blog_footer clearfix">
<span class="blog_author"><ul class="team_social_icons">

' . implode("\n", $social) . '

</ul></span>
</div>
</div>';
    return $cont;
}

function sabian_register_full_carousel_slider_addon() {
    $sabian_vc_addons = $GLOBALS["sabian_vc_addons"];
    $sabian_slider_opts = array();
    $sabian_category_blocks = array();
    $categories = array();
    $slider = $GLOBALS["sabian_slider_post"];
    $args = array("taxonomy" => $slider->cat_name, "orderby" => "name");
    $categories = get_categories($args);
    foreach ($categories as $cat) {

        $sabian_category_blocks[$cat->name] = "sabiancat::" . $cat->term_id;
    }
    $sabian_slider_opts[] = array(
        'type' => 'dropdown',
        'holder' => '',
        'class' => '',
        'heading' => __("Select Slider Category"),
        'param_name' => 'sabian_carousel_slider_category',
        'value' => $sabian_category_blocks,
        'description' => __('Select Category'),
    );
    $shortcode = array();
    $shortcode["title"] = "sabian_full_carousel_slider_addon";
    $shortcode["callback"] = "sabian_full_carousel_slider_addon";
    $sabian_slider_addon = array(
        'name' => __('Sabian Full Image Carousel Slider'),
        'base' => $shortcode["title"],
        'category' => __($sabian_vc_addons->sabian_options),
        'params' => $sabian_slider_opts);
    $sabian_vc_addons->add_option($sabian_slider_addon, $shortcode);
}

function sabian_full_carousel_slider_addon($attr, $content) {
    $cat_id = $attr["sabian_carousel_slider_category"];
    //$total_posts = $attr["sabian_slider_posts"];
    $slider = $GLOBALS["sabian_slider_post"];
    $cat = explode("::", $cat_id);
    $posts = sabian_get_posts(array("post_type" => $slider->post_name), array('taxonomy' => $slider->cat_name,
        'field' => 'term_id',
        'terms' => $cat[1]
    ));
    $cont = '';
    $slide_images = array();
    foreach ($posts as $i => $post) {

        $image_link = "";
        if (has_post_thumbnail($post->ID)) {
            $imID = get_post_thumbnail_id($post->ID);
            $image_link = wp_get_attachment_url($imID);
            $slide_images[] = $image_link;
        }
    }
    ob_start();
    ?>
    <section class="section_banner carousel_slider rs-slider-wrapper visible-lg">

        <!--Start Layer Slider-->

        <div id="banner_rs_slider" class="banner_rs_slider">
            <ul class="rs-slider-items">

                <?php
                foreach ($posts as $i => $post) {
                    $image_link = "";
                    if (has_post_thumbnail($post->ID)) {
                        $imID = get_post_thumbnail_id($post->ID);
                        $image_link = wp_get_attachment_url($imID);
                    }
                    $is_first = $i == 0;
                    $page = get_post_meta($post->ID, $slider->link_meta_key, true);
                    $btnText = get_post_meta($post->ID, $slider->button_text_meta_key, true);
                    $page = WP_Post::get_instance($page);
                    $link = $page->guid;
                    ?>

                    <!--First Slide-->

                    <li data-transition="boxslide" data-slotamount="7">
                        <img src="<?php echo $image_link; ?>" />
                        <div class="tp-caption fade fadeout banner_caption_1 title"

                             data-x="5" 

                             data-y="center"

                             data-voffset="-90" 

                             data-speed="800"

                             data-start="700"

                             data-easing="Power4.easeOut"

                             data-endspeed="500"

                             data-endeasing="Power4.easeIn"
                             >
                            <h1><?php echo $post->post_title; ?></h1>
                        </div>
                        <div class="tp-caption customin customout banner_caption_container no-padding-left"

                             data-x="5" 

                             data-y="center"

                             data-voffset="0" 

                             data-customin="x:0;y:150;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.5;scaleY:0.5;skewX:0;skewY:0;opacity:0;transformPerspective:0;transformOrigin:50% 50%;"

                             data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"

                             data-start="1200" 

                             data-speed="800"

                             data-easing="Power4.easeOut"

                             data-endspeed="500"

                             data-endeasing="Power4.easeIn">


                            <div class="banner_description text_white banner_dark"><?php echo $post->post_excerpt; ?></div>
                        </div>

                    </li>

                    <!--End First Slide-->

                <?php } ?>
            </ul>
            <!--End Slider-->
        </div>
    </section>
    <!--Mobile Slider-->

    <section class="section_banner visible-xs" id="section_banner" data-slide-images="<?php echo implode(",", $slide_images); ?>">
        <!--<div class="banner_mask"></div>-->
        <!--Start Carousel Slide-->

        <div id="banner_carousel" class="banner_carousel carousel" data-ride="carousel">
            <!--Carousel Controls-->

            <div class="banner-control control-left hidden-xs" id="slider_prev"><span><i class="fa fa-chevron-left"></i></span></div>

            <div class="banner-control control-right hidden-xs" id="slider_next"><span><i class="fa fa-chevron-right"></i></span></div>


            <ol class="banner-indicators carousel-indicators">

                <?php
                foreach ($posts as $j => $post) {
                    $is_active = $j == 0;
                    ?>

                    <li data-target="#banner_carousel" data-slide-to="<?php echo $j; ?>" class="<?php echo ($is_active) ? "active" : ""; ?>"></li>

                <?php } ?>

            </ol>   

            <!--End Controls-->


            <div class="banner_content content_centered">
                <div class="container">
                    <!--Start Carousel Inner-->

                    <div class="carousel-inner">
                        <?php
                        foreach ($posts as $k => $post) {
                            $is_active = $k == 0;
                            $page = get_post_meta($post->ID, $slider->link_meta_key, true);
                            $btnText = get_post_meta($post->ID, $slider->button_text_meta_key, true);
                            $page = WP_Post::get_instance($page);
                            $link = $page->guid;
                            ?>

                            <!--First Carousel-->

                            <div class="item <?php echo ($is_active) ? "active" : ""; ?>">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="banner_caption_1 animatedDown anim_step_1"><h1><?php echo $post->post_title; ?></h1></div>
                                        <div class="banner_caption_container animatedDown anim_step_2">
                                            <div class="banner_description text_white"><?php echo $post->post_excerpt; ?></div>
                                        </div>


                                        <div class="banner_caption_4 animatedDown anim_step_3">

                                            <a class="btn btn-primary btn-icon btn-eye" href="<?php echo $link; ?>"><?php echo $btnText; ?></a>

                                        </div>
                                    </div>
                                    <!--<div class="col-md-6">

                                    <img class="img-responsive pull-right" src="images/responsive-imac.png" />

                                    </div>-->
                                </div>
                            </div>

                            <!--End First Carousel-->

                        <?php } ?>

                    </div>

                    <!--End Carousel Inner-->
                </div>
            </div>
        </div>

        <!--End Slide Carousel-->
    </section>
    <?php
    $cont = ob_get_contents();
    ob_end_clean();
    return $cont;
}

function sabian_register_small_box_addon() {
    $sabian_vc_addons = $GLOBALS["sabian_vc_addons"];
    $sabian_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Title'),
        'param_name' => 'sabian_box_title',
        'value' => __(''),
        'description' => __('Title'),
    );
    $sabian_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Description'),
        'param_name' => 'sabian_box_desc',
        'value' => __(''),
        'description' => __('Description'),
    );
    $shortcode = array();
    $shortcode["title"] = "sabian_small_box";
    $shortcode["callback"] = "sabian_small_box";
    $sabian_addon = array(
        'name' => __('Sabian Small CTA'),
        'base' => $shortcode["title"],
        'category' => __($sabian_vc_addons->sabian_options),
        'params' => $sabian_opts);
    $sabian_vc_addons->add_option($sabian_addon, $shortcode);
}

function sabian_small_box($attrs) {
    $title = $attrs["sabian_box_title"];
    $desc = $attrs["sabian_box_desc"];
    return '

    <div class="small-bar">

        <div class="container">

            <h1>

                <p>

                    <strong>' . $title . ' </strong>' . $desc . '

                </p>
            </h1>

        </div>

    </div>';
}

function sabian_register_info_box_addon() {
    $sabian_vc_addons = $GLOBALS["sabian_vc_addons"];
    $sabian_opts[] = array(
        'type' => 'attach_image',
        'holder' => '',
        'class' => '',
        'heading' => __('Select Image'),
        'param_name' => 'image',
        'value' => __(''),
        'description' => __('Select Image'),
    );
    $sabian_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Title'),
        'param_name' => 'title',
        'value' => __(''),
        'description' => __('Title'),
    );
    $sabian_opts[] = array(
        'type' => 'textarea',
        'holder' => '',
        'class' => '',
        'heading' => __('Description'),
        'param_name' => 'description',
        'value' => __(''),
        'description' => __('Description'),
    );
    $sabian_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Button Text'),
        'param_name' => 'button_text',
        'value' => __(''),
        'description' => __('Button Text'),
    );
    $sabian_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Button URL'),
        'param_name' => 'button_url',
        'value' => __(''),
        'description' => __('Button URL'),
    );
    $sabian_opts[] = array(
        'type' => 'iconpicker',
        'heading' => __('Icon', 'js_composer'),
        'param_name' => 'button_icon',
        'settings' => array(
            'emptyIcon' => false, // default true, display an "EMPTY" icon?
            'type' => 'fontawesome',
            'iconsPerPage' => 200, // default 100, how many icons per/page to display
        ),
        'dependency' => array(
            'element' => 'icon_type',
            'value' => 'fontawesome',
        ),
        'description' => __('Button Icon', 'js_composer'),
    );

    $shortcode = array();
    $shortcode["title"] = "sabian_info_box";
    $shortcode["callback"] = "sabian_info_box";
    $sabian_addon = array(
        'name' => __('Sabian Info Box'),
        'base' => $shortcode["title"],
        'category' => __($sabian_vc_addons->sabian_options),
        'params' => $sabian_opts);
    $sabian_vc_addons->add_option($sabian_addon, $shortcode);
}

function sabian_info_box($attrs) {
    $image = $attrs["image"];
    $title = $attrs["title"];
    $desc = $attrs["description"];
    $btnText = $attrs["button_text"];
    $btnUrl = $attrs["button_url"];
    $btnIcon = $attrs["button_icon"];
    $image = wp_get_attachment_url($image);
    $cont = '<div class="info_box">

        <div class="info_box_image">

            <img src="' . $image . '" class="img-responsive">

        </div>

        <h4>' . $title . '</h4>

        <p>' . $desc . '</p>

        <a href="' . $btnUrl . '" class="btn btn-sm btn-rnd btn-base" target="_self" href="">

            <span><i class="' . $btnIcon . '"></i> ' . $btnText . '</span>

        </a>

    </div>';
    return $cont;
}

function sabian_register_full_screen_slider_addon() {
    $sabian_vc_addons = $GLOBALS["sabian_vc_addons"];
    $sabian_slider_opts = array();
    $sabian_slider_opts[] = array(
        'type' => 'attach_images',
        'holder' => '',
        'class' => '',
        'heading' => __('Select Slider Images'),
        'param_name' => 'images',
        'value' => __(''),
        'description' => __('Select Slider Images'),
    );
    $sabian_slider_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Enter Title'),
        'param_name' => 'title',
        'value' => __(''),
        'description' => __('Enter Title'),
    );
    $sabian_slider_opts[] = array(
        'type' => 'dropdown',
        'holder' => '',
        'class' => '',
        'heading' => __("Title Type"),
        'param_name' => 'title_type',
        'value' => array("Normal" => "normal", "Large" => "extra"),
        'description' => __('Title Type'),
    );
    $sabian_slider_opts[] = array(
        'type' => 'textarea',
        'holder' => '',
        'class' => '',
        'heading' => __('Enter Sub Title'),
        'param_name' => 'description',
        'value' => __(''),
        'description' => __('Enter Sub Title'),
    );
    $sabian_slider_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Enter Button Text'),
        'param_name' => 'button_text',
        'value' => __(''),
        'description' => __('Enter Button Text'),
    );
    $sabian_slider_opts[] = array(
        'type' => 'vc_link',
        'holder' => '',
        'class' => '',
        'heading' => __('Enter Button URL'),
        'param_name' => 'button_url',
        'value' => __(''),
        'description' => __('Enter Button URL'),
    );
    $sabian_slider_opts[] = array(
        'type' => 'dropdown',
        'holder' => '',
        'class' => '',
        'heading' => __("Button Type"),
        'param_name' => 'button_type',
        'value' => array("Transparent" => "btn-alt", "Bold" => "btn-slider"),
        'description' => __('Button Type'),
    );
    $sabian_slider_opts[] = array(
        'type' => 'iconpicker',
        'heading' => __('Icon', 'js_composer'),
        'param_name' => 'button_icon',
        'settings' => array(
            'emptyIcon' => false, // default true, display an "EMPTY" icon?
            'type' => 'fontawesome',
            'iconsPerPage' => 200, // default 100, how many icons per/page to display
        ),
        'dependency' => array(
            'element' => 'icon_type',
            'value' => 'fontawesome',
        ),
        'description' => __('Button Icon', 'js_composer'),
    );
    $sabian_slider_opts[] = array(
        'type' => 'colorpicker',
        'holder' => 'div',
        'class' => '',
        'heading' => __('Button Background color'),
        'param_name' => 'button_color',
        'value' => SabianThemeSettings::getThemeColor(),
        'description' => __('Choose bg color for button'),
    );


    $sabian_slider_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Enter Second Button Text'),
        'param_name' => 'button_text_2',
        'value' => __(''),
        'description' => __('Leave it blank if you do not want to include second button in the slider'),
    );
    $sabian_slider_opts[] = array(
        'type' => 'vc_link',
        'holder' => '',
        'class' => '',
        'heading' => __('Enter Second Button Url'),
        'param_name' => 'button_url_2',
        'value' => __(''),
        'description' => __('Leave it blank if you do not want to include second button in the slider'),
    );
    $sabian_slider_opts[] = array(
        'type' => 'iconpicker',
        'heading' => __('Icon', 'js_composer'),
        'param_name' => 'button_icon_2',
        'settings' => array(
            'emptyIcon' => false, // default true, display an "EMPTY" icon?
            'type' => 'fontawesome',
            'iconsPerPage' => 200, // default 100, how many icons per/page to display
        ),
        'dependency' => array(
            'element' => 'icon_type',
            'value' => 'fontawesome',
        ),
        'description' => __('Second Button Icon', 'js_composer'),
    );
    $sabian_slider_opts[] = array(
        'type' => 'colorpicker',
        'holder' => 'div',
        'class' => '',
        'heading' => __('Second Button Background color'),
        'param_name' => 'button_color_2',
        'value' => SabianThemeSettings::getThemeColor(),
        'description' => __('Choose bg color for second button'),
    );
    $sabian_slider_opts[] = array(
        'type' => 'dropdown',
        'holder' => '',
        'class' => '',
        'heading' => __("Text Alignment"),
        'param_name' => 'text_align',
        'value' => array("center", "left"),
        'description' => __('Text Alignment'),
    );
    $sabian_slider_opts[] = array(
        'type' => 'colorpicker',
        'holder' => 'div',
        'class' => '',
        'heading' => __('Background color'),
        'param_name' => 'bg_color',
        'value' => 'rgba(0,0,0,0.3)',
        'description' => __('Choose bg color for slider'),
    );

    $shortcode = array();
    $shortcode["title"] = "sabian_full_screen_slider";
    $shortcode["callback"] = "sabian_full_screen_slider";
    $sabian_icon_addon = array(
        'name' => __('Sabian Full Screen Slider'),
        'base' => $shortcode["title"],
        'category' => __($sabian_vc_addons->sabian_options),
        'params' => $sabian_slider_opts);
    $sabian_vc_addons->add_option($sabian_icon_addon, $shortcode);
}

function sabian_full_screen_slider($attrs, $content) {
    $attrs = wp_parse_args($attrs, array(
        "text_align" => "center",
        "bg_color" => "rgba(0,0,0,0.3)",
        "title_type" => "normal",
        "button_type" => "btn-alt",
        "button_color" => SabianThemeSettings::getThemeColor(),
        "button_color_2" => SabianThemeSettings::getThemeColor(),
		"title"=>"asasa"
    ));
    extract($attrs);
    $desc = $description;
    $include_second_button = $button_text_2 != "";
    $content = '';
    $slideImgs = array();
    $images = explode(",", $images);
    foreach ($images as $img) {
        $slideImgs[] = wp_get_attachment_url($img);
    }
    $slideImgs = implode(",", $slideImgs);
    
    $button_url=vc_build_link($button_url);
    $button_url_2=vc_build_link($button_url_2);
    
    if(is_array($button_url)){
        $button_url=$button_url['url'];
    }
    if(is_array($button_url_2)){
        $button_url_2=$button_url_2['url'];
    }
    
    ob_start();
    ?>
    <!--Banner-->

    <section class="section_full_banner" id="section_full_banner" data-images="<?php echo $slideImgs; ?>">
        <div class="banner_mask" style="background-color: <?php echo $bg_color; ?>"></div>
        <ul class="slider_controls">

            <li class="next" id="vegas_next"><a href="#" style="background-image: url(<?php echo SABIAN_URL . "images/sliders/next.png"; ?>)"></a></li>

            <li class="prev"><a href="#" id="vegas_prev" style="background-image: url(<?php echo SABIAN_URL . "images/sliders/prev.png"; ?>)"></a></li>

        </ul>
        <div class="banner_content">
            <div class="container">
                <div class="row">
                    <div class="col-md-<?php echo ($text_align == "center") ? "12" : "7"; ?>">
                        <h1 class="banner_title <?php echo $title_type; ?> <?php
                        if ($text_align == "center") {

                            echo 'text-center';
                        }
                        ?>"><?php echo $title; ?></h1>
                        <p class="banner_sub_title <?php
                        if ($text_align == "center") {

                            echo 'text-block-center';
                        }
                        ?>">

                            <?php echo $desc; ?>

                        </p>
                        <p class="banner_buttons <?php
                        if ($text_align == "center") {

                            echo 'text-center';
                        }
                        ?>">

                            <a class="btn btn-lg <?php echo $button_type; ?>" href="<?php echo $button_url; ?>" style="background-color: <?php echo $button_color; ?>; border-color:transparent">

                                <i class="<?php echo $button_icon; ?>" style="margin-right: 5px"></i>

                                <?php echo $button_text; ?>

                            </a> 
                            <?php if ($include_second_button) { ?>

                                <a class="btn btn-lg <?php echo $button_type; ?>" href="<?php echo $button_url_2; ?>" style="background-color: <?php echo $button_color_2; ?>; border-color:transparent"><i class="<?php echo $button_icon_2; ?>" style="margin-right: 5px"></i><?php echo $button_text_2; ?></a>

                            <?php } ?>

                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--Banner-->


    <?php
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}

function sabian_register_bg_block_addon() {
    $sabian_vc_addons = $GLOBALS["sabian_vc_addons"];
    $sabian_opts[] = array(
        'type' => 'iconpicker',
        'heading' => __('Icon', 'js_composer'),
        'param_name' => 'icon',
        'settings' => array(
            'emptyIcon' => false, // default true, display an "EMPTY" icon?
            'type' => 'fontawesome',
            'iconsPerPage' => 200, // default 100, how many icons per/page to display
        ),
        'dependency' => array(
            'element' => 'icon_type',
            'value' => 'fontawesome',
        ),
        'description' => __('Select icon from library.', 'js_composer'),
    );
    $sabian_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Title'),
        'param_name' => 'title',
        'value' => __(''),
        'description' => __('Title'),
    );
    $sabian_opts[] = array(
        'type' => 'textarea',
        'holder' => '',
        'class' => '',
        'heading' => __('Description'),
        'param_name' => 'description',
        'value' => __(''),
        'description' => __('Description'),
    );
    $sabian_opts[] = array(
        'type' => 'textarea',
        'holder' => '',
        'class' => '',
        'heading' => __('Item Lists'),
        'param_name' => 'lists',
        'value' => __(''),
        'description' => __('Item List (Click enter to separate)'),
    );


    $sabian_opts[] = array(
        'type' => 'colorpicker',
        'holder' => 'div',
        'class' => '',
        'heading' => __('Background color'),
        'param_name' => 'bg_color',
        'value' => SabianThemeSettings::getThemeColor(),
        'description' => __('Choose color for title text'),
    );


    $sabian_opts[] = array(
        'type' => 'colorpicker',
        'holder' => 'div',
        'class' => '',
        'heading' => __('Text color'),
        'param_name' => 'text_color',
        'value' => SabianThemeSettings::getThemeColor(),
        'description' => __('Choose color for text'),
    );
    $sabian_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Height'),
        'param_name' => 'height',
        'value' => __(''),
        'description' => __('BG Height in px'),
    );
    $pages = sabian_get_pages();
    foreach ($pages as $pag) {

        $sabian_page_blocks[$pag->post_title] = $pag->guid;
    }
    $sabian_opts[] = array(
        'type' => 'dropdown',
        'holder' => '',
        'class' => '',
        'heading' => __('Select Link'),
        'param_name' => 'link',
        'value' => $sabian_page_blocks,
        'description' => __('Select Link'),
    );

    $shortcode = array();
    $shortcode["title"] = "sabian_bg_block_addon";
    $shortcode["callback"] = "sabian_bg_block_addon";
    $sabian_addon = array(
        'name' => __('Sabian BG Block Addon'),
        'base' => $shortcode["title"],
        'category' => __($sabian_vc_addons->sabian_options),
        'params' => $sabian_opts);
    $sabian_vc_addons->add_option($sabian_addon, $shortcode);
}

function sabian_bg_block_addon($attrs) {
    $defaults = array();
    $attrs = wp_parse_args($attrs, $defaults);
    extract($attrs);
    $cont = '';
    $lists = explode("\n", $lists);
    ob_start();
    ?>


    <div class="sabian_bg_block" style="background-color: <?php echo $bg_color; ?>">
        <div class="block_content">
            <h2 class="title"><?php echo $title; ?></h2>
            <p class="description"><?php echo $description; ?></p>
            <?php if (count($lists) > 0) { ?>

                <div class="block_list">

                    <?php
                    foreach ($lists as $lst) {

                        echo '<a>' . $lst . '</a>';
                    }
                    ?>

                </div>

            <?php } ?>
        </div>
    </div>

    <?php
    $cont = ob_get_contents();
    ob_end_clean();
    return $cont;
}

function sabian_register_carousel_slider_addon() {
    $sabian_vc_addons = $GLOBALS["sabian_vc_addons"];
    $sabian_slider_opts = array();
    $sabian_category_blocks = array();
    $categories = array();
    $slider = $GLOBALS["sabian_slider_post"];
    $args = array("taxonomy" => $slider->cat_name, "orderby" => "name");
    $sabian_category_blocks["All"] = -1;
    $categories = get_categories($args);
    foreach ($categories as $cat) {

        $sabian_category_blocks[$cat->name] = $cat->term_id;
    }
    $sabian_slider_opts[] = array(
        'type' => 'dropdown',
        'holder' => '',
        'class' => '',
        'heading' => __("Select Slider Category"),
        'param_name' => 'category',
        'value' => $sabian_category_blocks,
        'description' => __('Select Category'),
    );
    $sabian_slider_opts[] = array(
        'type' => 'dropdown',
        'holder' => '',
        'class' => '',
        'heading' => __('Limit'),
        'param_name' => 'limit',
        'value' => array("Show All" => -1, 4, 5, 6, 7, 8, 9, 10),
        'description' => __('Slider Limit'),);
    $sabian_slider_opts[] = array(
        'type' => 'dropdown',
        'holder' => '',
        'class' => '',
        'heading' => __('Columns'),
        'param_name' => 'columns',
        'value' => array(2, 3, 4, 5, 6),
        'description' => __('Columns'),);


    $sabian_slider_opts[] = array(
        'type' => 'dropdown',
        'holder' => '',
        'class' => '',
        'heading' => __('Display Type'),
        'param_name' => 'display_type',
        'value' => array("Image, Text and Description" => "image_text_description", "Image and Text" => "image_and_text", "Image Only" => "image_only"),
        'description' => __('Display Type'),);

    $shortcode = array();
    $shortcode["title"] = "sabian_carousel_slider";
    $shortcode["callback"] = "sabian_carousel_slider_addon";
    $sabian_slider_addon = array(
        'name' => __('Sabian Carousel Slider'),
        'base' => $shortcode["title"],
        'category' => __($sabian_vc_addons->sabian_options),
        'params' => $sabian_slider_opts);
    $sabian_vc_addons->add_option($sabian_slider_addon, $shortcode);
}

function sabian_carousel_slider_addon($attrs) {
    $slider = $GLOBALS["sabian_slider_post"];
    $defaults = array(
        "limit" => 10,
        "category" => -1,
        "columns" => 4,
        "display_type" => "image_and_text"
    );
    $attrs = wp_parse_args($attrs, $defaults);
    extract($attrs);
    $tax_args = array();
    if ($category && $category > -1) {

        $tax_args = array('taxonomy' => $slider->cat_name,
            'field' => 'term_id',
            'terms' => $category
        );
    }
    $post_args = array(
        "post_type" => $slider->post_name,
        "posts_per_page" => $limit
    );


    $posts = sabian_get_posts($post_args, $tax_args);
    $cont = '';
    ob_start();
    $sliderID = ++$GLOBALS["slider_carousel_ids"];
    $sliderID = "sabian_carousel_slider_" . $sliderID;
    ?>


    <div class="owl-carousel owl-theme owl-items" data-items="<?php echo $columns; ?>" data-dots="true" id="<?php echo $sliderID; ?>">
        <?php
        foreach ($posts as $i => $post) {

            $imageID = get_post_thumbnail_id($post);
            $image_url = "";
            if (is_numeric($imageID)) {

                $image_url = wp_get_attachment_url($imageID);

                if (!$image_url) {

                    $image_url = "";
                }
            }
            $page = get_post_meta($post->ID, $slider->link_meta_key, true);
            $btnText = get_post_meta($post->ID, $slider->button_text_meta_key, true);
            $page = WP_Post::get_instance($page);



            $has_page = $page && $page > -1;
            if ($has_page) {

                $link = get_permalink($page);
            }
            ?>
            <div class="blog_block">
                <div class="blog_header">

                    <div class="sabian_preview_image" style="background-image: url(<?php echo $image_url; ?>); height: 200px"></div>

                </div>


                <?php if ($display_type !== "image_only") { ?>
                    <div class="blog_body">

                        <h2 class="blog_title"><a><?php echo $post->post_title; ?></a></h2>

                        <?php if ($display_type == "image_text_description") { ?>
                            <p class="blog_tags"><?php echo get_the_excerpt($post); ?></p>
                        <?php } ?>
                        <p class="blog_content">

                            <?php echo wp_strip_all_tags($post->content); ?>            

                        </p>

                    </div>
                <?php } ?>


                <?php if ($has_page) { ?>

                    <div class="blog_footer clearfix">

                        <span class="blog_author"><a class="btn btn-base btn-sm btn-icon btn-eye" href="<?php echo $link; ?>"><?php echo $btnText; ?></a></span>

                    </div>

                <?php } ?>
            </div>
        <?php } ?>
    </div>


    <?php
    $cont = ob_get_contents();
    ob_end_clean();
    return $cont;
}

function sabian_register_blog_posts_slider_addon() {

    $sabian_vc_addons = $GLOBALS["sabian_vc_addons"];

    $cats = sabian_get_categories(array(
        "taxonomy" => 'category',
        "order" => "DESC",
        "show_count" => false,
        "hide_empty" => false
    ));

    $scats = array();

    $scats["All"] = -1;

    foreach ($cats as $cat) {

        $scats[$cat->name] = $cat->term_id;
    }

    $lim_total = 20;

    $lim_values = array();

    for ($i = 2; $i < $lim_total; $i++) {
        $lim_values[] = $i;
    }

    $sabian_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Title'),
        'param_name' => 'title',
        'value' => __(''),
        'description' => __('Title'),
    );

    $sabian_opts[] = array(
        'type' => 'dropdown',
        'holder' => '',
        'class' => '',
        'heading' => __('Select Category'),
        'param_name' => 'category',
        'value' => $scats,
        'description' => __('Select Category'),);

    $sabian_opts[] = array(
        'type' => 'dropdown',
        'holder' => '',
        'class' => '',
        'heading' => __('Posts Limit'),
        'param_name' => 'limit',
        'value' => $lim_values,
        'description' => __('Posts Limit'),);

    //sabian_products_slider_mobile_limit
    $sabian_opts[] = array(
        'type' => 'dropdown',
        'holder' => '',
        'class' => '',
        'heading' => __('Mobile Limit'),
        'param_name' => 'mobile_limit',
        'value' => array(2, 3, 4, 5, 6, 7),
        'description' => __('The limit of the posts in mobile view'),);

    $sabian_opts[] = array(
        'type' => 'dropdown',
        'holder' => '',
        'class' => '',
        'heading' => __('Posts Column'),
        'param_name' => 'columns',
        'value' => array(2, 3, 4, 6),
        'description' => __('Posts Column'),);

    $sabian_opts[] = array(
        'type' => 'dropdown',
        'holder' => '',
        'class' => '',
        'heading' => __('Post Rows'),
        'param_name' => 'rows',
        'value' => array(1, 2, 3, 4),
        'description' => __('Select number of posts to be displayed on each column'),);

    $sabian_opts[] = array(
        'type' => 'dropdown',
        'holder' => '',
        'class' => '',
        'heading' => __('Single Post Style'),
        'param_name' => 'style',
        'value' => apply_filters("sabian_post_styles_addon_selection", array("Style 1" => "1")),
        'description' => __('Single Post Style'),);

    $shortcode = array();

    $shortcode["title"] = "sabian_blog_posts_slider_addon";

    $shortcode["callback"] = "sabian_blog_posts_slider_addon";

    $sabian_addon = array(
        'name' => __('Sabian Blog Posts Slider'),
        'base' => $shortcode["title"],
        'category' => __($sabian_vc_addons->sabian_options),
        'params' => $sabian_opts);

    $sabian_vc_addons->add_option($sabian_addon, $shortcode);
}

function sabian_blog_posts_slider_addon($attrs) {

    $attrs = wp_parse_args($attrs, array(
        "style" => 1,
        "title" => "Latest Blogs",
        "display_navigation" => false
    ));

    extract($attrs);

    $cont = '';

    $cat_id = $category;

    $cat_all = $category == -1;

    $limit = intval($limit);

    $args = array(
        'posts_per_page' => $limit,
        'orderby' => 'ID',
        'order' => 'DESC'
    );

    $tax_args = array();

    if (!$cat_all) {
        $tax_args[] = array(
            'taxonomy' => 'category',
            "field" => "term_id",
            "terms" => $cat_id
        );

        $args['tax_query'] = $tax_args;
    }

    $query = new WP_Query($args);

    $tposts = $query->found_posts;

    //echo $tposts." found";

    $posts = $query->posts;

    $gposts = array();

    $rows = (int) $rows;

    $columns = (int) $columns;

    $chunk_to = $rows * $columns;

    //echo $rows." ".$columns." nigga ".$chunk_to;

    if ($tposts > 0) {

        $gposts = array_chunk($posts, $chunk_to);
    }

    $col = 12 / $columns;

    ob_start();

    $sliderID = ++$GLOBALS["post_slider_carousel_ids"];

    $sliderID = "sabian_post_cat_" . $sliderID;
    ?>
    <div class="row">

        <div class="col-md-12" style="position: relative">

            <?php if ($display_navigation) { ?>
                <div class="sabian-owl-nav side hidden-md hidden-sm hidden-xs">
                    <a class="owl_carousel_nav prev" data-target="#<?php echo $sliderID; ?>" data-slide-to="prev"><i class="fa fa-chevron-left"></i></a>
                    <a class="owl_carousel_nav next" data-target="#<?php echo $sliderID; ?>" data-slide-to="next"><i class="fa fa-chevron-right"></i></a>
                </div>
            <?php } ?>

            <!--Mobile-->
            <div class="visible-xs visible-sm visible-md">
                <div class="owl-carousel owl-theme owl-items" data-items="1" data-dots="true">

                    <?php
                    $i = 0;

                    while ($query->have_posts()):

                        $query->the_post();

                        if ($i >= $mobile_limit)
                            break;
                        ?>
                        <?php sabian_load_post_item_template($style); ?>
                        <?php
                        $i++;
                    endwhile;
                    ?>

                </div>
            </div>

            <!--Desktop-->
            <div class="hidden-xs hidden-sm hidden-md">
                <div class="owl-carousel owl-theme owl-items" data-items="<?php echo $columns; ?>" data-dots="true" id="<?php echo $sliderID; ?>">

                    <?php
                    wp_reset_query();

                    $query = new WP_Query($args);

                    $i = 0;

                    while ($query->have_posts()):

                        $query->the_post();

                        //echo get_post()->post_name;
                        ?>
                        <?php sabian_load_post_item_template($style); ?>
                        <?php
                        $i++;
                    endwhile;
                    ?>

                </div>

            </div>
        </div>

    </div>






    <?php
    $cont = ob_get_contents();

    ob_end_clean();

    return $cont;
    ?>

    <?php
}



function sabian_register_icon_image_block_addon() {
    $sabian_vc_addons = $GLOBALS["sabian_vc_addons"];
    $sabian_icon_opts = array();
    $sabian_icon_opts[] = array(
        'type' => 'attach_image',
        'holder' => '',
        'class' => '',
        'heading' => __('Select Image'),
        'param_name' => 'image',
        'value' => __(''),
        'description' => __('Select Image'),
    );
    $sabian_icon_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Icon Title'),
        'param_name' => 'sabian_icon_title',
        'value' => __(''),
        'description' => __('Enter Service Title'),
    );
    $sabian_icon_opts[] = array(
        'type' => 'textarea_html',
        'holder' => '',
        'class' => '',
        'heading' => __('Enter Service Description'),
        'param_name' => "content",
        'value' => __(''),
        'description' => __('Enter Description'),
    );
   $sabian_icon_opts[] = array(
        'type' => 'dropdown',
        'holder' => '',
        'class' => '',
        'heading' => __('Icon Color Block Type'),
        'param_name' => 'sabian_icon_type',
        'value' => array("Blend" => "base", "Normal" => "normal"),
        'description' => __('Select Block Type'),
    );


    $shortcode = array();
    $shortcode["title"] = "sabian_icon_image_block";
    $shortcode["callback"] = "sabian_icon_image_block";
    $sabian_icon_addon = array(
        'name' => __('Sabian Image Service Block'),
        'base' => $shortcode["title"],
        'category' => __($sabian_vc_addons->sabian_options),
        'params' => $sabian_icon_opts);
    $sabian_vc_addons->add_option($sabian_icon_addon, $shortcode);
}

function sabian_icon_image_block($attrs, $content = null) {

$attrs=wp_parse_args($attrs,array(
"sabian_icon_type"=>"base"
));
    $icon = $attrs["image"];
	
	$icon=wp_get_attachment_url($icon);

    $title = $attrs["sabian_icon_title"];

    $description = $content;

    $type = $attrs["sabian_icon_type"];
	
	$cont='';
	
	ob_start();
	
	?>
    <div class="service service-boxed <?php echo $type; ?>">
    <!-- single info block -->
				<div class="info text-center info-boxed">
					<div class="icon icon-image-circle" style="background-image:url(<?php echo $icon; ?>)">
						
					</div>
					<div class="description">
						<h5 class="service-title"><?php echo $title; ?></h5>
						<p class="description"><?php echo $description; ?></p>
					</div>
				</div><!-- single info block ends -->
		
    </div>
    
    <?php
	$cont=ob_get_contents();
	
	ob_end_clean();
	
	return $cont;
}

function sabian_register_clients_addon() {
    $sabian_vc_addons = $GLOBALS["sabian_vc_addons"];

    $sabian_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Title'),
        'param_name' => 'sabian_clients_title',
        'value' => __(''),
        'description' => __('Title'),
    );

    $sabian_opts[] = array(
        'type' => 'dropdown',
        'holder' => '',
        'class' => '',
        'heading' => __('Number of Columns'),
        'param_name' => 'sabian_clients_columns',
        'value' => array(5, 6, 7, 8),
        'description' => __('Number of Columns'),
    );

    $shortcode = array();

    $shortcode["title"] = "sabian_clients_slider";

    $shortcode["callback"] = "sabian_clients_slider";

    $sabian_slider_addon = array(
        'name' => __('Sabian Clients Slider'),
        'base' => $shortcode["title"],
        'category' => __($sabian_vc_addons->sabian_options),
        'params' => $sabian_opts);

    $sabian_vc_addons->add_option($sabian_slider_addon, $shortcode);
}

function sabian_clients_slider($attr, $content) {
	
	$id=++$GLOBALS["client_slider_carousel_ids"];
	
    $title = $attr["sabian_clients_title"];

    $cols = $attr["sabian_clients_columns"];

    if (!$cols) {
        $cols = 7;
    }

    $clPost = $GLOBALS["sabian_client_post"];

    //$posts = sabian_get_posts(null, $clPost->post_name);

    $posts = sabian_get_posts(
            array("post_type" => $clPost->post_name)
    );

    $cont = '

<div class="container">

<div class="row">

<div class="col-md-12">';

if($title) {
	$cont .= '<h3 class="feature_top_heading text-center heading-alt text_condesed" style="margin-bottom:15px !important">' . $title . '</h3>';
}
	
	
	$cont.='<div class="owl-carousel owl-theme owl-items" data-items="' . $cols . '" id="clients_slider_'.$id.'">';



    foreach ($posts as $post) {
        $img_id = get_post_thumbnail_id($post->ID);
        $img = wp_get_attachment_url($img_id);
        $link = get_post_meta($post->ID, $clPost->link_meta_key, true);
        if (!$link) {
            $link = "#";
        }
        $target = 'target="_blank"';
        if ($link == "#") {
            $target = 'target="_self"';
        }
        $cont .= '<div class="client"><a href="' . $link . '" alt="' . $post->post_title . '" ' . $target . '><img src="' . $img . '"/></a></div>';
    }


    $cont .= '</div>';


    $cont .= '</div></div></div>';


    return $cont;
}







function sabian_register_transparent_contact_addon() {
	
	$attr=wp_parse_args($attr,array(
	"title"=>"Contact Us",
	"description"=>"",
	"form_title"=>"Send Us A Message",
	"image"=>"",
	"contact_form"=>"",
	"bg_color"=>$theme_color,
	"display_contact_info"=>false,
	"contact_info_title"=>"",
	"contact_info_description"=>"",
	"contact_info_phone"=>"",
	"contact_info_email"=>"",
	"contact_info_location"=>""
	));
	
    $sabian_vc_addons = $GLOBALS["sabian_vc_addons"];
    $sabian_icon_opts = array();
	
	$sabian_icon_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Title'),
        'param_name' => 'title',
        'value' => __(''),
        'description' => __('Enter Title'),
    );
	
	$sabian_icon_opts[] = array(
        'type' => 'textarea',
        'holder' => '',
        'class' => '',
        'heading' => __('Description'),
        'param_name' => 'description',
        'value' => __(''),
        'description' => __('Enter Description'),
    );
	
	$sabian_icon_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Form Title'),
        'param_name' => 'form_title',
        'value' => __(''),
        'description' => __('Enter Form Title'),
    );
	
    $sabian_icon_opts[] = array(
        'type' => 'attach_image',
        'holder' => '',
        'class' => '',
        'heading' => __('Select Background Image'),
        'param_name' => 'image',
        'value' => __(''),
        'description' => __('Select BG Image'),
    );
    $sabian_icon_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Contact Form ID'),
        'param_name' => 'contact_form',
        'value' => __(''),
        'description' => __(''),
    );
	
	$sabian_icon_opts[] = array(
        'type' => 'colorpicker',
        'holder' => 'div',
        'class' => '',
        'heading' => __('Background color'),
        'param_name' => 'bg_color',
        'value' => SabianThemeSettings::getThemeColor(),
        'description' => __('Choose color for the contacts'),
    );

	
	
   $sabian_icon_opts[] = array(
        'type' => 'dropdown',
        'holder' => '',
        'class' => '',
        'heading' => __('Display Contact Information'),
        'param_name' => 'display_contact_info',
        'value' => array("Yes" => true, "No" => false),
        'description' => __(''),
    );/*
	
	$attr=wp_parse_args($attr,array(
	"title"=>"Contact Us",
	"description"=>"",
	"form_title"=>"Send Us A Message",
	"image"=>"",
	"contact_form"=>"",
	"bg_color"=>$theme_color,
	"display_contact_info"=>false,
	"contact_info_title"=>"",
	"contact_info_description"=>"",
	"contact_info_phone"=>"",
	"contact_info_email"=>"",
	"contact_info_location"=>""
	));*/
	
	$sabian_icon_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Contact Info Title'),
        'param_name' => 'contact_info_title',
        'value' => __(''),
        'description' => __('Enter Title'),
    );
	
	$sabian_icon_opts[] = array(
        'type' => 'textarea',
        'holder' => '',
        'class' => '',
        'heading' => __('Contact Info Description'),
        'param_name' => 'contact_info_description',
        'value' => __(''),
        'description' => __('Enter Description'),
    );
	
	$sabian_icon_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Contact Info Phone'),
        'param_name' => 'contact_info_phone',
        'value' => __(''),
        'description' => __('Enter Phone'),
    );
	
	$sabian_icon_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Contact Info Email'),
        'param_name' => 'contact_info_email',
        'value' => __(''),
        'description' => __('Enter Email'),
    );
	
	$sabian_icon_opts[] = array(
        'type' => 'textfield',
        'holder' => '',
        'class' => '',
        'heading' => __('Contact Info Location'),
        'param_name' => 'contact_info_location',
        'value' => __(''),
        'description' => __('Enter Location'),
    );
	
	/*"contact_info_email"=>"",
	"contact_info_location"=>""*/


    $shortcode = array();
    $shortcode["title"] = "sabian_transparent_contact_addon";
    $shortcode["callback"] = "sabian_transparent_contact_addon";
    $sabian_icon_addon = array(
        'name' => __('Sabian Transparent Contact Information'),
        'base' => $shortcode["title"],
        'category' => __($sabian_vc_addons->sabian_options),
        'params' => $sabian_icon_opts);
    $sabian_vc_addons->add_option($sabian_icon_addon, $shortcode);
}

function sabian_transparent_contact_addon($attr){
	
	$theme_color=sabian_hex_to_rgb(SabianThemeSettings::getThemeColor());
	
	$attr=wp_parse_args($attr,array(
	"title"=>"Contact Us",
	"description"=>"",
	"form_title"=>"Send Us A Message",
	"image"=>"",
	"contact_form"=>"",
	"bg_color"=>'',
	"display_contact_info"=>false,
	"contact_info_title"=>"",
	"contact_info_description"=>"",
	"contact_info_phone"=>"",
	"contact_info_email"=>"",
	"contact_info_location"=>""
	));
	
	extract($attr);
	
	$cont='';
	
	ob_start();
	
	if($image){
		$image=wp_get_attachment_url($image);	
	}
	
	$contact_info_details=array();
	
	if($contact_info_phone){
		$contact_info_details[]=array("icon"=>"phone","text"=>$contact_info_phone);
	}
	
	if($contact_info_email){
		$contact_info_details[]=array("icon"=>"envelope","text"=>$contact_info_email);
	}
	
	if($contact_info_location){
		$contact_info_details[]=array("icon"=>"map-marker","text"=>$contact_info_location);
	}
	
	$overlay_id=++$GLOBALS["overlay_container_ids"];
	
	$overlay_id="contact_transparent_".$overlay_id;
	
	?>
    
    <style>
	#<?php echo $overlay_id; ?>{
		background-image:url(<?php echo $image; ?>) !important;	
	}
    #<?php echo $overlay_id; ?>::after{
		background:<?php echo $bg_color; ?> !important;
	}
    </style>
    <section class="section_contacts overlay_container" id="<?php echo $overlay_id; ?>">

<div class="container">

<div class="row">

<div class="col-md-12">
<h2 class="text-center text_white"><span class="text_line_top"><?php echo $title; ?></span></h2>

<p class="text-block-center"><?php echo $description; ?>.</p>
</div>

</div>


<div class="row">
<div class="col-sm-<?php echo ($display_contact_info)?8:12; ?>">

<?php if($contact_form) {
	$cshortcode='[contact-form-7 id="'.$contact_form.'"]';
	 ?>

<div class="form contact_form transparent">
<h4><?php echo $form_title; ?></h4>
<?php echo do_shortcode($cshortcode); ?>
</div>

<?php } 

else { ?>
<form class="form contact_form transparent">
<h4><?php echo $form_title; ?></h4>
<div class="form-group">
<input class="form-control" placeholder="Enter Name" type="text">
</div>
<div class="form-group">
<input class="form-control" placeholder="Enter Email" type="email">
</div>
<div class="form-group">
<textarea class="form-control" placeholder="Enter Description"></textarea>
</div>
<div class="form-group">
<button class="btn btn-primary btn-nm" value="Submit Details">Submit Details</button>
</div>
</form>

<?php } ?>
</div>

<?php if($display_contact_info) { ?>
<div class="col-md-4">
<div class="contact_container_info">
<ul class="">
<li><h3><?php echo $contact_info_title; ?></h3></li>
<li>
<p><?php echo $contact_info_description; ?></p></li>
<?php foreach($contact_info_details as $cd) {
	
	 ?>
<li>
                      <p>
                        <a href="#"><i class="fa fa-<?php echo $cd["icon"]; ?>"></i> <?php echo $cd["text"]; ?></a>
                      </p>
                    </li>
                    <?php } ?>
                   
                    
                  </ul>
                  </div>
</div>
<?php } ?>

</div>

</div>

</section>
    <?php
	
	$cont.=ob_get_contents();
	
	ob_end_clean();
	
	return $cont;
}
?>
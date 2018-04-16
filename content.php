<?php

require_once SABIAN_APP_PATH . "sabian_comment.php";



$GLOBALS["sabian_show_sidebar"] = $show_sidebar = apply_filters("sabian_show_sidebar", false);

add_action('wp_head','sabian_display_loader');

add_action( 'wp_footer', 'sabian_display_loader_script' );

add_filter("sabian_page_header", "sabian_get_breadcrumbs");

add_filter("sabian_main_content_dimension", "sabian_no_sidebar");

add_action("sabian_after_all_posts", "sabian_posts_pagination");

add_action("sabian_after_single_post", "sabian_single_comment");

add_action("sabian_before_body", "sabian_display_breadcrumps");

add_filter("sabian_page_title",function($title){
	
	if(is_category()){
		$category = get_category( get_query_var( 'cat' ) );
		return $category->name;
	}
	
	
	
	return $title;
},1000);


add_filter("sabian_display_breadcrumps", function($return) {



    $supports = sabian_get_header_page_supported_types();



    $page = get_post();



    if (!in_array($page->post_type, $supports)) {

        return $return;

    }



    if (!sabian_can_display_page_header($page)) {

        return $return;

    }



    $header_details = sabian_get_page_header_details($page);



    if (!$header_details) {

        return $return;

    }



    extract($header_details);



    sabian_display_image_header($title, $image);



    return false;

});



function sabian_get_logo_url() {



    return apply_filters("sabian_logo_url", SABIAN_IMAGE_URL . "hillmark/logo.png");

}



function sabian_display_breadcrumps() {



    if (is_front_page()) {

        return;

    }



    $display_bcs = apply_filters("sabian_display_breadcrumps", true);



    if (!$display_bcs) {

        return;

    }



    $page_title = get_the_title();



    $page_title = apply_filters("sabian_page_title", $page_title);

    ?>



    <div class="pg-opt">

        <div class="container">

            <div class="row">

                <div class="col-md-6 hidden-xs">

                    <h2><?php echo $page_title; ?></h2>

                </div>

                <div class="col-md-6">

                    <ol class="breadcrumb">

                        <li><a href="<?php echo get_bloginfo("url"); ?>">Home</a></li>

                        <li><a href="#"><?php echo $page_title; ?></a></li>

                    </ol>

                </div>

            </div>

        </div>

    </div>

    <?php

}



function sabian_display_image_header($page_title, $image) {



    $page_title = apply_filters("sabian_page_title", $page_title);

    ?>

    <div class="sabian-page-header" style="background-image: url(<?php echo $image; ?>)">



        <div class="mask"></div>

        <div class="header-wrapper">

            <div class="container">

                <div class="row">

                    <div class="col-md-12">



                        <ol class="breadcrumb hidden-xs hidden-sm">

                            <li><a href="<?php echo get_bloginfo("url"); ?>">Home</a></li>

                            <li><a href="#"><?php echo $page_title; ?></a></li>

                        </ol>



                        <h2 class="heading">

                            <?php echo $page_title; ?>

                        </h2>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <?php

}



function sabian_posts_pagination() {

    $pagination = "";



    ob_start();



    global $wp_query;



    $total_pages = $wp_query->max_num_pages;



    if ($total_pages > 1) {



        $current_page = max(1, get_query_var('paged'));



        $pagins = paginate_links(array(

            'base' => get_pagenum_link(1) . '%_%',

            'format' => '/page/%#%',

            'current' => $current_page,

            'total' => $total_pages,

            'prev_next' => false,

            'type' => 'array',

            'prev_next' => TRUE,

            'prev_text' => __('«'),

            'next_text' => __('»'),

        ));



        if (is_array($pagins)) {

            $paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');



            echo '<ul class="pagination pagination pull-left">';



            foreach ($pagins as $i => $page) {

                $class = array();



                if (strpos($page, 'current') !== false) {

                    $class[] = "active";

                }

                $open_ahref = ( strpos($page, 'current') !== false) ? '<a href="#">' : "";

                $close_ahref = ( strpos($page, 'current') !== false) ? '</a>' : "";

                echo '<li class="' . implode(" ", $class) . '">' . $open_ahref . strip_tags($page, "<a>") . $close_ahref . '</li>';

            }

            echo '</ul>';

        }

    }



    $pagination = ob_get_contents();



    ob_end_clean();



    echo apply_filters("sabian_posts_pagination", $pagination);

}



function sabian_list_comments() {

    $cms = "";



    $cms = '<div class="comment-list clearfix" id="comments">

		                        <h2 class="no_margin_top" style="font-size:16px">Comment Section</h2>

                                <ul>';



    ob_start();



    wp_list_comments(array('walker' => new SabianCommentWalker(),

        'page' => get_the_ID(),

        'style' => 'ul',

        'short_ping' => true,

        'avatar_size' => 56,

        'echo' => false

    ));



    $cms .= ob_get_contents();



    ob_end_clean();



    $cms .= '</ul>

                                </div>';





    echo apply_filters("sabian_comment_template", $cms);

}



function sabian_comment_callback($comment, $args, $depth) {

    ?>

    <li class="comment">

        <div class="comment-body bb">

            <div class="comment-avatar">

                <div class="avatar"><img src="images/temp/avatar1.png" alt=""></div>

            </div>

            <div class="comment-text">

                <div class="comment-author clearfix">

                    <a href="#" class="link-author" hidefocus="true" style="outline: none;">Brad Pit</a>

                    <span class="comment-meta"><span class="comment-date">June 26, 2013</span> | <a href="#addcomments" class="link-reply anchor" hidefocus="true" style="outline: none;">Reply</a></span>

                </div>

                <div class="comment-entry">

                    William Bradley "Brad" Pitt is an American actor and film producer. Pitt has received four Academy Award nominations and five Golden Globe.

                </div>

            </div>

        </div>

    </li>

    <?php

}



function sabian_single_comment() {



    sabian_list_comments();



    sabian_get_comment_form();

}



function sabian_no_sidebar() {

    if (!$GLOBALS["sabian_show_sidebar"])

        return "col-md-12";



    return "col-md-9";

}



function sabian_get_breadcrumbs() {

    $bd = "";



    if (!is_front_page()) {

        $bd = '<div class="pg-opt">

    <div class="container">

        <div class="row">

            <div class="col-md-6 hidden-xs">

                <h2>' . get_title() . '</h2>

            </div>

            <div class="col-md-6">

                <ol class="breadcrumb">

                    <li><a href="index.php">Home</a></li>

                    <li class="active">' . get_title() . '</li>

                </ol>

            </div>

        </div>

    </div>

</div>';

    }



    return $bd;

}



function sabian_load_home_content() {
	
    if (have_posts()) {

        while (have_posts()) {

            the_post();

            the_content();

        }

    }

}



function sabian_load_sub_content() {

    while (have_posts()) {

        the_post();

        the_content();

    }

}



function sabian_load_content() {


    switch (is_front_page()) {

        case true:

            sabian_load_home_content();

            break;



        case false:

            if (sabian_is_post()) {



                sabian_display_posts();

            } else {

                sabian_load_sub_content();

            }



            break;

    }

}



function sabian_display_posts() {

    $displayPost = apply_filters("sabian_display_posts", true);



    if (!$displayPost)

        return;



    echo '<section class="section_content">';



    $cont_sd = apply_filters("sabian_post_content_dimension", 'col-md-9');



    $sb_sd = apply_filters("sabian_post_content_dimension", 'col-md-3');

    ?>

    <div class="container">

        <div class="row">

            <div class="<?php echo $cont_sd; ?>">

                <?php

                while (have_posts()) {

                    the_post();



                    if (is_single()) {

                        sabian_load_single_post();

                    } else {

                        sabian_load_posts();

                    }

                }



                if (!is_single()) {



                    do_action("sabian_after_all_posts");

                }

                ?>

            </div>





            <div class="<?php echo $sb_sd; ?> sidebar">

                <?php get_sidebar('sabian_sidebar'); ?>

            </div>

            <?php ?>

        </div>

    </div>

    <?php

    echo '</section>';

}



function sabian_load_posts() {



    do_action("sabian_before_post");



    load_template(SABIAN_TEMPLATES_PATH . "single-post-item.php", false);



    do_action("sabian_after_post");

}



function sabian_load_single_post() {



    do_action("sabian_before_single_post");



    $post = get_post();



    load_template(SABIAN_TEMPLATES_PATH . "single-post.php");



    do_action("sabian_after_single_post", $post);

}



function sabian_get_comment_form() {

    if (comments_open()) {

        $args = array(

            'comment_field' => ' <label class="">' . _x('Comment', 'noun') . '</label><textarea id="comment" name="comment" class="form-control input-lg" cols="45" rows="8" aria-required="true"></textarea>',

            'fields' => apply_filters('comment_form_default_fields', array(

                'author' =>

                '<label for="author">' . __('Name', 'domainreference') . '</label> ' .

                ( $req ? '<span class="required">*</span>' : '' ) .

                '<input id="author" name="author" type="text" class="form-control input-lg" value="' . esc_attr($commenter['comment_author']) .

                '" size="30"' . $aria_req . ' />',

                'email' =>

                '<p class="comment-form-email"><label for="email">' . __('Email', 'domainreference') . '</label> ' .

                ( $req ? '<span class="required">*</span>' : '' ) .

                '<input id="email" name="email" class="form-control input-lg" type="text" value="' . esc_attr($commenter['comment_author_email']) .

                '" size="30"' . $aria_req . ' /></p>',

                'url' =>

                '<p class="comment-form-url"><label for="url">' .

                __('Website', 'domainreference') . '</label>' .

                '<input id="url" name="url" class="form-control input-lg" type="text" value="' . esc_attr($commenter['comment_author_url']) .

                '" size="30" /></p>'

                    )

        ));

        comment_form($args);

    } else {

        _e(apply_filters("sabian_comments_not_allowed_message", '<h2>Comments are closed</h2>'));

    }

}



function sabian_is_post() {

    if (is_page()) {

        return false;

    }



    return true;

}



function sabian_load_theme_styling() {



    $theme_color = SabianThemeSettings::getThemeColor();



    $secondary_color = SabianThemeSettings::getThemeSecondaryColor();



    $header_color = get_theme_mod(SabianThemeSettings::HEADER_COLOR_OPTION_KEY, SabianThemeSettings::$defaults["header_color"]);



    $header_top_color = get_theme_mod(SabianThemeSettings::HEADER_TOP_COLOR_OPTION_KEY, SabianThemeSettings::$defaults["header_top_color"]);



    $header_text_color = get_theme_mod(SabianThemeSettings::HEADER_TEXT_COLOR_OPTION_KEY, SabianThemeSettings::$defaults["header_text_color"]);



    $header_text_top_color = get_theme_mod(SabianThemeSettings::HEADER_TOP_TEXT_COLOR_OPTION_KEY, SabianThemeSettings::$defaults["header_top_text_color"]);





    $header_hover_color = get_theme_mod(SabianThemeSettings::HEADER_HOVER_COLOR_OPTION_KEY, SabianThemeSettings::$defaults["header_hover_color"]);



    $header_hover_text_color = get_theme_mod(SabianThemeSettings::HEADER_HOVER_TEXT_COLOR_OPTION_KEY, SabianThemeSettings::$defaults["header_hover_text_color"]);
	
	$page_loader_bg=SabianThemeSettings::getPageLoaderBackground();
	
	if(!$page_loader_bg){
		$page_loader_bg=$theme_color;	
	}

    ?>

    <style>

        .text_line_top {

            border-top: 2px solid <?php echo $theme_color; ?> !important;

        }

        .btn-base, .btn-primary {

            background-color: <?php echo $theme_color; ?>;

            border-color: transparent;

        }



        .navbar-default {

            background: <?php echo $header_color; ?>;

        }

        .navbar-top, .navbar-top.blend {

            background: <?php echo $header_top_color; ?>;

        }
		 



        .navbar-top-social-icons > li a:hover{

            color:<?php echo $theme_color; ?> !important;

            background:#fff;

        }
		
		.navbar-middle .cart-btn > a.btn {
			background: <?php echo $theme_color; ?>;
			border-color: <?php echo $theme_color; ?>;
		}
		.navbar-middle .cart-btn > a.btn > i {
			color: <?php echo $theme_color; ?>;
		}







        .navbar-default .navbar-nav li a{

            color: <?php echo $header_text_color; ?>;

        }

        .navbar-default.theme .navbar-nav li a, 

        .navbar-default.theme .navbar-header a {

            color: <?php echo $header_text_color; ?> !important;

        }

        .navbar-default.theme .navbar-nav > li a{

            background: <?php echo $header_color; ?>;

        }

        .navbar-default .navbar-nav > li a:hover, 

        .navbar-default .navbar-nav > li a:focus, 

        .navbar-default .navbar-nav li.active a, 

        .navbar-default .navbar-nav li.active a:hover, 

        .navbar-default .navbar-nav li.active a:focus

        {

            background: <?php echo $header_hover_color; ?>;

            color: <?php echo $header_hover_text_color; ?>;

        }







        .navbar-default.theme .navbar-nav > li a:hover, 

        .navbar-default.theme .navbar-nav > li a:focus, 

        .navbar-default.theme .navbar-nav li.active > a,

        .navbar-default.theme .navbar-nav li.active a:hover, 

        .navbar-default.theme .navbar-nav li.active a:focus

        {

            background: <?php echo $header_hover_color; ?> !important;

            color: <?php echo $header_hover_text_color; ?> !important;

        }





        .nav_transparent.theme{

            background-color:<?php echo $header_color; ?> !important;

        }



        /*Dropdowns*/

        .navbar-default .navbar-nav > .open > a, 

        .navbar-default .navbar-nav > .open > a:hover, 

        .navbar-default .navbar-nav > .open > a:focus {

            color: <?php echo $header_hover_text_color; ?>;

            background-color:<?php echo $header_color; ?>;

        }

        .navbar-default .navbar-nav li.open a:focus, 

        .navbar-default .navbar-nav li.open a:hover{

            background:<?php echo $header_color; ?>;

            color:<?php echo $header_text_color; ?>;	

        }

        .navbar-default .dropdown-menu

        {

            background:<?php echo $header_color; ?>;

            color:<?php echo $header_text_color; ?>;	

        }



        .nav_transparent.theme .dropdown-menu{

            background:<?php echo $header_color; ?> !important;

            color:<?php echo $header_text_color; ?> !important;	

        }







        .navbar-top {

            color: <?php echo $header_text_top_color; ?>;

        }

        .navbar-top a {

            color: <?php echo $header_text_top_color; ?>;

        }





        footer .social-icons i:hover {

            background:<?php echo $theme_color; ?>;

        }



        ul.categories>li>a:hover{

            background: <?php echo $header_color; ?> !important;

        }



        a {

            color: <?php echo $theme_color; ?>;

        }



        .blog_block .blog_header .blog_time {



            background: <?php echo sabian_hex_to_rgb($theme_color, 0.9); ?>;

        }



        .owl-theme .owl-dots .owl-dot.active span {

            background: <?php echo $theme_color; ?> !important;

        }

        .owl-theme .owl-dots .owl-dot span {

            background: <?php echo sabian_hex_to_rgb($theme_color, 0.5); ?> !important;

        }



        .team_member figcaption {

            background: <?php echo sabian_hex_to_rgb($theme_color, 0.9); ?> !important;

        }
		
		[class*="section_"].overlay_container:after{
			background: <?php echo sabian_hex_to_rgb($theme_color, 0.9); ?>;
		}



        ul.tabs li.active a {

            background: <?php echo $theme_color; ?>;

        }



        

        .pagination > li > a, .pagination > li > span {

            border-color: <?php echo $secondary_color; ?>;

            color: <?php echo $theme_color; ?>;

        }

        .pagination > .active > a, .pagination > .active > span, .pagination > .active > a:hover, .pagination > .active > span:hover, .pagination > .active > a:focus, .pagination > .active > span:focus {

            background-color: <?php echo $theme_color; ?>;

            border-color: <?php echo $secondary_color; ?>;

        }

        .pagination > li > a:hover, .pagination > li > span:hover {

            background-color: <?php echo $theme_color; ?>;

            border-color: <?php echo $secondary_color; ?>;

        }
		
		.featured_item_icon, .featured_item_icon {
    color: <?php echo $theme_color; ?>;
		}
		.circle_icon i {
			background-color: <?php echo $theme_color; ?>;
		}
		.circle_icon i:hover {
    color: <?php echo $theme_color; ?> !important;
    border: 2px solid <?php echo $theme_color; ?>;
		}
		
		.section-title-wr .h1 > span, .section-title-wr h2 > span, .section-title-wr h3 > span, .section-title-wr h4 > span {
			color: <?php echo $theme_color; ?> !important;
		}
		
		.service .icon i {
    color: <?php echo $theme_color; ?> !important;
		}
		
		.service:hover .icon-circle{
			background: <?php echo $theme_color; ?> !important;
		}
		
		
		.base{
         background-color: <?php echo $theme_color; ?> !important;   
        }
		
		.heading-alt:before {
			background: <?php echo $theme_color; ?> !important; 
		}
		.col-carousel-indicators li {
			background: <?php echo $theme_color; ?> !important; 
		}
		.overlay_block .btn {
			color: <?php echo $theme_color; ?>;
		}
		
		::selection {
			 background:<?php echo $theme_color; ?>; /* WebKit/Blink Browsers */
			 color:#fff;
		}
		::-moz-selection {
			background: <?php echo $theme_color; ?>; /* Gecko Browsers */
			color : #fff;
		}
		
		.line_top {
			border-top: 2px solid <?php echo $theme_color; ?>;
		}
		.team_member ul.team_social_icons li a:hover {
			color: <?php echo $theme_color; ?> !important;
		}
		.sabian-page-loader {
			background: <?php echo $page_loader_bg; ?> !important;
		}

    </style>



    <?php do_action("sabian_theme_styling_content"); ?>



    <?php

}



/**

 * Displays the top header contacts

 */

function sabian_top_header_contacts($extra_class="") {



    $phone = SabianThemeSettings::getSetting(SabianThemeSettings::HEADER_TOP_CONTACT_KEY, NULL);



    $email = SabianThemeSettings::getSetting(SabianThemeSettings::HEADER_TOP_EMAIL_KEY, NULL);



    if ($email == null && $phone == null) {

        return;

    }

    ?>

    <ul class="navbar-top-contacts <?php echo $extra_class; ?>">

        <?php if ($email != null) { ?>

            <li>

                <i class="fa fa-envelope"></i> <?php echo $email; ?>

            </li>

        <?php } ?>



        <?php if ($phone != null) { ?>

            <li>

                <i class="fa fa-phone"></i> <?php echo $phone; ?>

            </li>

        <?php } ?>

    </ul>



    <?php

}

/**
* Filters the contact info
* @return array $email,$phone 
*/
function sabian_get_header_contacts(){
	 
	 $phone = SabianThemeSettings::getSetting(SabianThemeSettings::HEADER_TOP_CONTACT_KEY, NULL);
	 
	 $email = SabianThemeSettings::getSetting(SabianThemeSettings::HEADER_TOP_EMAIL_KEY, NULL);	
	 
	 $location=SabianThemeSettings::getSetting(SabianThemeSettings::HEADER_TOP_LOCATION_KEY, NULL);	
	 
	 $recs=array();
	 
	 
	 //(\+*)\d+/i
	 
	 //[A-Za-z0-9_]@[A-Za-z0-9](\.[A-Za-z]{2,5})/i
	 
	 //\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}\b/
	 
	 $phone_records_match=preg_match("/(\+*)[0-9]{3}(.*)[0-9]{3,4}(.*)[0-9]{3,4}/i",$phone,$pmatches);
	 
	 $email_records_match=preg_match("/[A-Za-z0-9_]+@[A-Za-z0-9.-]+(\.[A-Za-z]{2,5})/i",$email,$ematches);
	 
	 if($phone_records_match){
		 $recs["phone"]=$pmatches[0];	 
	 }
	 
	 if($email_records_match){
		 $recs["email"]=$ematches[0]; 
	 }
	 
	 $recs["location"]=$location;
	 
	 return wp_parse_args($recs,array("phone"=>"","email"=>"","location"=>""));
	 
	 
}

/**

 * Displays the top header social media icons

 */

function sabian_top_header_social($extra_class="") {
	
	$social_links=SabianThemeSettings::getSocialMediaLinks();

    ?>

    <ul class="navbar-top-social-icons pull-right <?php echo $extra_class; ?>">

<?php foreach($social_links as $key=>$link) {
	
	$s_link=$link["link"];
				
				if($s_link=="")
				continue;
				
				 ?>
        <li><a href="<?php echo $s_link; ?>" target="_blank"><i class="fa fa-<?php echo $key; ?>"></i></a></li>
<?php } ?>
        



    </ul>

    <?php

}



/**

 * Whether to display the top header

 * @return boolean

 */

function sabian_display_top_header() {



    $display = SabianThemeSettings::getSetting(SabianThemeSettings::HEADER_TOP_DISPLAY_OPTION_KEY, false);



    if ($display == FALSE) {

        return $display;

    }



    $display = ($display == 1);



    return $display;

}



/**

 * Whether to hide the tob bar as one scrolls

 * @return bool

 */

function sabian_hide_top_bar_on_scroll() {

    return true;

}



/**

 * Whether to hide the top header on scroll

 * @return boolean

 */

function sabian_hide_top_header_on_scroll() {

    

}
function sabian_display_loader(){
	
	$can_show_loader=apply_filters("sabian_display_page_loader",true);
	
	if(!$can_show_loader)
	return;
	
	$page_loader=SabianThemeSettings::getPageLoader();
	
	?>
    <div id="sabian-page-loader" class="sabian-page-loader">
    <div id="sabian-loader-cont" class="sabian-loader-cont">
    
    <?php do_action("sabian_before_page_loader"); ?>
    
    <?php echo $page_loader; ?>
        
        <?php do_action("sabian_after_page_loader"); ?>
    </div>
    </div>
    <?php
}
function sabian_display_loader_script(){
	
	$can_show_loader=apply_filters("sabian_display_page_loader",true);
	
	if(!$can_show_loader)
	return;
?>
<script type="text/javascript">
  jQuery(document).ready(function($) {
	  
	  function sb_hide_loader(){
		  if ($("#sabian-loader-cont").length > 0 && $("#sabian-loader-cont").css("display") != "none") {
			  $("#sabian-page-loader").delay(450).fadeOut("slow");
			  $("#sabian-loader-cont").fadeOut();
		  }
	  }
	  
      $(window).load(function() {   
          sb_hide_loader();     
      });
	  
	  setTimeout(sb_hide_loader, 30000);	
  });
</script>
<?php
}

add_filter("sabian_display_page_loader",function(){
	return SabianThemeSettings::canDisplayPageLoader();
});

add_action("sabian_before_page_loader",function(){
			
			$logo=SabianThemeSettings::getPageLoaderImage();
			
			if(!$logo)
			return;
			
			?>
            <div class="page-loader-image"><img src="<?php echo $logo; ?>" /></div>
            <?php
		});


?>
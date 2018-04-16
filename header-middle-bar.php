<?php
$logo = SabianThemeSettings::getLogo();

$header_c=sabian_get_header_contacts();

extract($header_c);
?>

<!DOCTYPE html>

<html lang="en-US">

    <head>

        <?php echo apply_filters("sabian_meta", '

<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<meta name="robots" content="index, follow">');

        ?>



        <title>

            <?php wp_title('|', true, 'right'); ?> <?php bloginfo('name'); ?> | <?php bloginfo('description'); ?>

        </title>



        <?php wp_head(); ?>



        <?php sabian_load_theme_styling(); ?>

    </head>


<header>

<!--Top Bar-->
<?php if (sabian_display_top_header()) { ?>
        <div class="navbar-top blend">

            <div class="container">

                    <?php sabian_top_header_contacts(""); ?>
                    
                    <?php sabian_top_header_social("hidden-xs hidden-sm"); ?>
                    
                    <?php do_action("sabian_top_header_after"); ?>

            </div>

        </div>
        <?php } ?>
        
        <!--Middle bar-->
        <div class="navbar-middle" id="navbar_middle">
        
         <a href="<?php echo get_bloginfo("url"); ?>" class="logo-container flexible">
        
        <div style="display:none" id="logo_text"><?php get_bloginfo("name"); ?></div>
        
        <img alt="<?php get_bloginfo("name"); ?>" src="<?php echo $logo; ?>" class="img-responsive img-logo">
        
        </a>
        
        <div class="container">
        
        <div class="row">
        
        <div class="col-sm-3 col-md-2"></div>
        
        <div class="col-sm-9 col-md-7 search-box text-center hidden-xs header-location-cnt">
        
        <?php if($phone){ ?>
					<div class="topbar-content">
						<i class="fa fa-phone" aria-hidden="true"></i>
						<a href="tel:<?php echo $phone; ?>"><?php echo $phone; ?></a>
					</div>
                    <?php } ?>
                    
                    <?php if($email){ ?>
					<div class="topbar-content">
						<i class="fa fa-envelope" aria-hidden="true"></i>
						<a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>
					</div>
                    <?php } ?>
                    
                    <?php if($location) { ?>
					<div class="topbar-content hidden-sm hidden-md">
						<i class="fa fa-map-marker" aria-hidden="true"></i>
						<a><?php echo $location; ?></a>
					</div>
                    <?php } ?>
				</div>
        
        
        <div class="col-sm-3 col-md-3 cart-btn hidden-xs hidden-sm">
        
        <?php do_action("sabian_header_middle_action"); ?>
        
        
        
        
        </div>
        
        </div>
        
        </div>
        
        </div>
        
        <!--Nav bar-->

        <nav class="navbar shop navbar-default hidden-xs sabian_nav" role="navigation" id="sabian_nav">


            <div class="container">



                <div class="navbar-header">

                    <a class="navbar-brand" href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a>

                </div>



                <?php

                wp_nav_menu(array(

                    'theme_location' => apply_filters("sabian_header_menu", 'header-menu'), // menu slug from step 1

                    'container' => '', // 'div' container will not be added

                    'menu_class' => 'nav navbar-nav navbar-' . SabianThemeSettings::getHeaderPosition() . '',

                    "fallback_cb" => "sabian_default_menu",

                    'walker' => apply_filters("sabian_header_menu_walker", new SabianNavWalker())

                        // <ul class="nav"> 

                ));

                ?>



                <?php

                wp_nav_menu(array(

                    'theme_location' => 'sabian-header-menu-sub', // menu slug from step 1

                    'container' => '', // 'div' container will not be added

                    'menu_class' => 'nav navbar-nav navbar-right',

                    "fallback_cb" => "sabian_default_sub_menu",

                    'walker' => new SabianNavWalker()

                        // <ul class="nav"> 

                ));

                ?>







            </div>
                        </nav>


                        <nav class="navbar navbar-default visible-xs" role="navigation" id="sabian_nav_collapse">

                            <div class="navbar-header">

                                <div class="navbar-toggle" data-toggle="collapse" data-target="#sabian_nav_collapse_cont">
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </div>

                                 <a class="navbar-brand" href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a>
                            </div>

                            <div class="collapse navbar-collapse" id="sabian_nav_collapse_cont">
                                 <?php

                    wp_nav_menu(array(

                        'theme_location' => 'sabian-header-menu-mobile', // menu slug from step 1

                        'container' => '', // 'div' container will not be added

                        'menu_class' => 'nav navbar-nav',

                        "fallback_cb" => "sabian_default_menu",

                        'walker' => new SabianNavWalker()

                            // <ul class="nav"> 

                    ));

                    ?>

                                        </div>
                                        </nav>
                                        </header>
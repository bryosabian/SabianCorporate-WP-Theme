<?php
$top_header_classes = [];

if (sabian_hide_top_bar_on_scroll()) {
    $top_header_classes[] = "hide_on_scroll";
}
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
            <div class="navbar-top hidden-xs <?php echo implode(" ", $top_header_classes); ?>">

                <div class="container">

                    <?php sabian_top_header_contacts(); ?>


                    <?php sabian_top_header_social(); ?>
                    
                    <?php do_action("sabian_top_header_after"); ?>

                </div>

            </div>
        <?php } ?>



        <!--Nav bar-->
        <nav class="navbar navbar-default hidden-xs sabian_nav sabian_nav_small" role="navigation" id="sabian_nav">


            <div class="container">

                <div class="navbar-header" style="display:none">
                    <a href="<?php bloginfo('url'); ?>" class="navbar-brand"><?php bloginfo('name'); ?></a>
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

                <a class="navbar-brand"><?php echo get_bloginfo('name'); ?></a>
            </div>

            <div class="collapse navbar-collapse" id="sabian_nav_collapse_cont">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'sabian-header-menu-mobile', // menu slug from step 1
                    'container' => '', // 'div' container will not be added
                    'menu_class' => 'nav navbar-nav navbar-left',
                    "fallback_cb" => "sabian_default_menu",
                    'walker' => new SabianNavWalker()
                        // <ul class="nav"> 
                ));
                ?>
            </div>


        </nav>



    </header>
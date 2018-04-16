<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (has_post_thumbnail()) {

    $image_link = wp_get_attachment_url(get_post_thumbnail_id());

    $img = '<div class="img" style="background-image: url(' . $image_link . ')"></div>';


    $img_container = '<div class="post-image">
	                            	<a href="' . $image_link . '" class="theater" title="Shoreline">
	                            		' . $img . '
	                            	</a>
	                            </div>';
} else {
    $image_link = '';

    $img = "";

    $img_container = "";
}

$cats= get_the_category_list(',&nbsp');

$cont = "";
?>

<div class="post-item">
    <div class="post-meta-top">
        <div class="post-image">
            <a href="images/temp/post-img-2.jpg" class="theater" title="Shoreline">
                <img src="<?php echo $image_link; ?>" alt="">
            </a>
        </div>
    </div>
    <div class="post-content">
        <h2 class="post-title"><a href="#" hidefocus="true" style="outline: none;"><?php echo $post->post_title; ?></a></h2>
        <span class="post-author">WRITTEN BY <a href="#" hidefocus="true" style="outline: none;"><?php echo get_the_author(); ?></a></span>
        
        <?php if($cats){ ?>
        <div class="post-tags">Posted in <?php echo $cats; ?></div>
        <?php } ?>
        
        <div class="clearfix"></div>
        <div class="post-desc"> <?php echo $post->post_content; ?>
        </div>
    </div>


</div>
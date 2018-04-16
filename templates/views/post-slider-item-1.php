<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$post= get_post();

$link = get_permalink();

$image = "";

$thumbID= get_post_thumbnail_id();

if($thumbID){
    $image= wp_get_attachment_url($thumbID);
}

$authorID=$post->post_author;

$author_name= get_the_author_meta('display_name');

$post_date= get_the_date("F jS Y");

$categories= get_the_category_list(' ',' ');

$description= sabian_get_ellipsis(wp_strip_all_tags($post->post_content),100);
?>
<div class="blog_block">

    <div class="blog_header">
        <div class="img" style="background-image: url(<?php echo $image; ?>)"></div>
        
        <div class="blog_time">
            <span class="time"><?php echo $post_date; ?></span>
        </div>
    </div>


    <div class="blog_body">

        <h2 class="blog_title"><a href="<?php echo $link; ?>"><?php echo $post->post_title; ?></a></h2>

        <p class="blog_tags">Under : <?php echo $categories; ?></p>

        <p class="blog_content">
            <?php echo $description; ?>
        </p>

    </div>


    <div class="blog_footer clearfix">

        <span class="blog_author">By <a class="" href=""><?php echo $author_name; ?></a></span>

    </div>

</div>
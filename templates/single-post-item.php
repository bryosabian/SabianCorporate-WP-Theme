<?php
$post = get_post();

if (has_post_thumbnail()) {

    $image_link = wp_get_attachment_url(get_post_thumbnail_id());

    $img = '<div class="img" style="background-image: url(' . $image_link . ')"></div>';


    $img_container = '<div class="post-image">
	                            	<a href="' . $image_link . '" class="theater" title="Shoreline">
	                            		' . $img . '
	                            	</a>
	                            </div>';
} else {
    
    $img = "";

    $img_container = "";
}


$comments= get_comment_count($post->ID);

$num_cms=$comments["approved"];

$cats= get_the_category_list(',&nbsp');

$content= sabian_get_ellipsis(wp_strip_all_tags($post->post_content),500);
?>

<div class="post-item style2">
    <div class="post-meta hidden-xs">
        <div class="date">
            <span class="icon"><i class="fa fa-calendar"></i></span>
            <span class="month"><?php echo date('M', strtotime($post->post_date_gmt)); ?></span>
            <span class="day"><?php echo date('d', strtotime($post->post_date_gmt)); ?></span>
        </div>
        <div class="like-box">
            <a href="#" class="btn btn-block btn-xs btn-base btn-icon btn-heart">
                <span>0</span>
            </a>
        </div>
    </div>
    <div class="post-content-wr">
        <div class="post-meta-top">
            <div class="post-image">
                <a href="#"><?php echo $img; ?></a>
            </div>
            <h2 class="post-title">
                <a href="<?php echo $post->guid; ?>"><?php echo $post->post_title; ?></a>
            </h2>
        </div>
        <div class="post-content clearfix">
            <div class="post-tags">
                <?php if($cats) { ?>
                Posted in <?php echo $cats; ?>
                <?php } ?>
            </div>
            <div class="post-comments"><strong><?php echo $num_cms; ?></strong>comments</div>
            <div class="post-desc">
                <p><?php echo $content; ?></p>
            </div>
        </div>
        <div class="post-meta-bot clearfix">
            <span class="post-author">WRITTEN BY <a href="#"><?php echo get_the_author(); ?></a></span>
            <a href="<?php echo $post->guid; ?>" class="btn btn-sm btn-base">Read more </a>
        </div>
    </div>
</div>


<?php do_action('before_sidebar'); ?>
<?php
if (!dynamic_sidebar('sabian_sidebar')) {
    
    $categories = sabian_get_categories(
            array("number"=>8));
    
    $archives= sabian_get_posts(array(
        "posts_per_page"=>8
    ));
    
    $tags= get_tags(
            array('hide_empty'=>false)
            );
    
            //get_terms();
    
    ?>
    <div class="widget_side">
        <div class="category_title"><span>Search</span>
        </div>

        <?php echo sabian_search_form(); ?>

    </div>


    <div class="widget_side">
        <div class="category_title"><span>Categories</span>
        </div>
        <ul class="categories highlight">
            <?php foreach ($categories as $cat) {
                
                $link= get_term_link($cat);
                ?>        
                <li><a href="<?php echo $link; ?>"><?php echo $cat->name; ?></a></li>
            <?php } ?>
        </ul>
    </div>


<div class="widget_side">
        <div class="category_title"><span>Archives</span>
        </div>
        <ul class="categories highlight">
            <?php foreach ($archives as $post) {
                
                $link= get_permalink($post);
                ?>        
                <li><a href="<?php echo $link; ?>"><?php echo $post->post_title; ?></a></li>
            <?php } ?>
        </ul>
    </div>


<?php if(count($tags)>0){ ?>
<div class="widget_side">
    <div class="category_title"><span>Tags</span>
        </div>
        <ul class="categories highlight">
            <?php foreach ($tags as $tag) {
                
                $link= get_term_link($tag);
                ?>        
                <li><a href="<?php echo $link; ?>"><?php echo $tag->name; ?></a></li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>
    <?php
}
?>


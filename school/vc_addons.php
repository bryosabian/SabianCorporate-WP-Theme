<?php
add_action( 'vc_before_init', 'sabian_register_courses_slider_addon');

$GLOBALS["couses_slider_ids"]=909;

function sabian_register_courses_slider_addon(){
	
	$sabian_vc_addons=$GLOBALS["sabian_vc_addons"];
	
	$sabian_opts=array();
	
	 $sabian_opts[]=array(
	  'type' => 'dropdown',
	  'holder' => '',
	  'class' => '',
	  'heading' => __( "Select Course Limit" ),
	  'param_name' => 'sabian_course_count',
	  'value' => array(4,5,6,7,8,9,10,20,30),
	  'description' => __( 'Select Course Limit' ),
     );
	
	$sabian_opts[]=array(
	  'type' => 'dropdown',
	  'holder' => '',
	  'class' => '',
	  'heading' => __( "Select Column Count" ),
	  'param_name' => 'sabian_course_column_count',
	  'value' => array(3,4,5),
	  'description' => __( 'Select Column Count' ),
     );
	 
	 $shortcode=array();
	 
	 $shortcode["title"]="sabian_courses_slider_addon";
	 
	 $shortcode["callback"]="sabian_courses_slider_addon";
	 
	 $sabian_addon=array(
            'name' => __( 'Sabian Courses Slider' ),
            'base' => $shortcode["title"],
            'category' => __( $sabian_vc_addons->sabian_options ),
            'params' => $sabian_opts);
			
	  $sabian_vc_addons->add_option($sabian_addon,$shortcode);
}
function sabian_courses_slider_addon($attrs,$content){
	
	$limit=$attrs["sabian_course_count"];
	
	$cols=$attrs["sabian_course_column_count"];
	
	$courses=array();
	
	$cPost=$GLOBALS["sabian_course_post"];
	
	$courses=sabian_get_posts(array("post_type"=>$cPost->post_name,"posts_per_page"=>$limit));
	
	$cont='';
	
	ob_start();
	
	?>
    <div class="owl-carousel owl-theme owl-items" data-items="<?php echo $cols; ?>" data-dots="true">
<?php foreach($courses as $course) {
	
	$sDate=get_post_meta( $course->ID, $cPost->start_date_meta_key, true );
	
	$duration=get_post_meta( $course->ID, $cPost->duration_meta_key, true );
	
	$level=get_post_meta( $course->ID, $cPost->level_meta_key, true );
	
	$name=$course->post_title;
	
	$desc=$course->post_content;
	
	$desc=sabian_get_ellipsis($desc,100);
	
	$image_link="";
	 
	 if(has_post_thumbnail($course->ID)){
		 
		 $imID=get_post_thumbnail_id($course->ID);
		 
		 $image_link=wp_get_attachment_url($imID);
		 
	 }
	 
	
	 ?>
<div class="blog_block">

<div class="blog_header">
<img class="img-responsive" src="<?php echo $image_link; ?>" />

<div class="blog_time">
<span class="time">Starts <?php echo $sDate; ?></span>
</div>
</div>


<div class="blog_body">

<h2 class="blog_title"><a><?php echo $name; ?></a></h2>

<p class="blog_tags">Duration : <?php echo $duration; ?></p>

<p class="blog_content">
<?php echo $desc; ?>
</p>

</div>


<div class="blog_footer clearfix">

    <span class="blog_author">Offered By <a><?php echo get_bloginfo('name'); ?></a></span>

</div>

</div>

<?php } ?>


</div>
    
    <?php
	
	$cont=ob_get_contents();
	
	ob_end_clean();
	
	return $cont;	
}
?>
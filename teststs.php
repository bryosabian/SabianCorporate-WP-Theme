<?php
use cf47\plugin\realtyspace\module\property\Repository;
use cf47\theme\realtyspace\module\property\viewmodel\DetailsViewModel;

$GLOBALS["sabian_slider_carousel_ids"]=909;

$GLOBALS["sabian_tab_ids"]=9090;

if(!defined("SABIAN_URL")){
	define("SABIAN_URL",get_stylesheet_directory_uri()."/");
}

new SabianAddons();

class SabianAddons{
	
	const PROPERTY_STATUS_TERM_KEY='cf47rs_property_contract';
	
	var $PROPERTY_STATUS_RENT_ID=50;
	
	var $PROPERTY_STATUS_SALE_ID=52;
	
	const PROPERTY_FEATURED_META_KEY='cf47rs_featured';
	
	public function __construct(){
		
		$this->init_child_theme_scripts();
		
		$this->init_properties_addons();
		
		$this->init_scripts();	
	}
	private function init_child_theme_scripts(){
		add_action( 'wp_enqueue_scripts', function(){
			wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );	
		});
	}
	private function init_properties_addons(){
		add_shortcode( 'sabian_properties_slider', array($this,'sabian_rs_properties_addon') );			
	}
	private function init_scripts(){
		
		add_action('init',function(){
			wp_register_style('sabian_owl_style',SABIAN_URL.'plugins/owl-carousel/assets/owl.carousel.css');
			wp_register_style('sabian_owl_theme',SABIAN_URL.'plugins/owl-carousel/assets/owl.theme.green.css');
			wp_register_script('sabian_owl_script', SABIAN_URL.'plugins/owl-carousel/assets/owl.carousel.js', array('jquery'), false, true);
			
			wp_register_script('sabian_script', SABIAN_URL.'js/sabian.js', array('jquery'), false, true);
		});
		
		add_action('wp_enqueue_scripts',function(){
			wp_enqueue_style('sabian_owl_style');
			wp_enqueue_script('sabian_owl_script');
			
			wp_enqueue_script('sabian_script');
		});
	}
	public function sabian_rs_properties_addon($attrs,$content){
		
		extract(shortcode_atts(array(
		"type" => 'featured',
		'limit'=>10,
		'specific_ids'=>array(),
		'rows'=>1,
		'columns'=>3,
		'title'=>'Featured Properties',
		'sub_title'=>''
		), $attrs));
		
		$tax_sale_args=array(
		array(
            'taxonomy' => 'cf47rs_property_contract',
            'terms' => $this->PROPERTY_STATUS_SALE_ID,
            'include_children' => false // Remove if you need posts from term 7 child terms
        ),
    );
	
	$tax_rent_args=array(
		array(
            'taxonomy' => 'cf47rs_property_contract',
            'terms' => $this->PROPERTY_STATUS_RENT_ID,
            'include_children' => false // Remove if you need posts from term 7 child terms
        ),
    );
	
	$tab_id_1=++$GLOBALS["sabian_tab_ids"];
	$tab_id_2=++$GLOBALS["sabian_tab_ids"];
	
	ob_start();
		
		?>
        
        <div class="widget widget--landing widget--gray widget--properties-section js-widget" id="cf47_module_property_group_0">
      <div class="widget__header">
                            <h2 class="widget__title"><?php echo $title; ?></h2>
                            <h5 class="widget__headline"><?php echo $sub_title; ?></h5>
            </div>
        
        <div class="widget__content">
        
        <div class="tab tab--properties">
      <ul role="tablist" class="nav tab__nav">
      
       <li class="active">
  <a href="#tab-<?php echo $tab_id_1; ?>" aria-controls="tab-<?php echo $tab_id_1; ?>" role="tab" data-toggle="tab" class="properties__btn js-pgroup-tab">
    For Rent
  </a>
</li>
<li>
  <a href="#tab-<?php echo $tab_id_2; ?>" aria-controls="tab-<?php echo $tab_id_2; ?>" role="tab" data-toggle="tab" class="properties__btn js-pgroup-tab">
    For Sale
  </a>
</li>
      
        </ul>
        
        <div class="tab-content">
        
            <div id="tab-<?php echo $tab_id_1; ?>" class="tab-pane in active">
        <?php $this->display_group_properties($attrs,$tax_rent_args);  ?>
        </div>
        
        <div id="tab-<?php echo $tab_id_2; ?>" class="tab-pane">
        <?php $this->display_group_properties($attrs,$tax_sale_args);  ?>
        </div>
        
        </div>
        
        </div>
        </div>
        </div>
        
        
        <?php
		$cnt=ob_get_contents();
		
		ob_end_clean();
		
		return $cnt;
	}
	private function display_group_properties($attrs,$query_args){
		
		extract($attrs);
		
		$rows = (int) $rows;
		
		$columns = (int) $columns;
		
		$chunk_to = $rows * $columns;
		
		$meta_args=array();
			
		if($type=='featured'){
		$bool=true;
		$meta_args[]=array(
		'key' => self::PROPERTY_FEATURED_META_KEY,
		'value' => (int)$bool,
		'compare' => '=',
		'type' => 'numeric'
		);
	}
	
	$args = array(
	'posts_per_page' => $limit,
	'meta_query'=>$meta_args
	);
		
		$args=wp_parse_args($args,$query_args);
		
		$repo = cf47rs_get('property.repo');
		
		$properties = $repo->find_by($args);
		
		if ($properties > 0) {
			$gprops = array_chunk($properties, $chunk_to);
		}
		
		$col = 12 / $columns;
		
		$cnt="";
		
		$sliderID = ++$GLOBALS["sabian_slider_carousel_ids"];
		
		$sliderID = "sabian_slider_cat_" . $sliderID;
		
		?>
		<div class="owl-carousel owl-theme owl-items" data-items="<?php echo ($rows==1)?$columns:1; ?>" data-dots="true" id="<?php echo $sliderID; ?>">
                
                <?php
		if ($rows == 1) {
			
			foreach ($properties as $i => $prop) {
				
				$this->display_single_property($prop);
			}
			}else{
				foreach($group as $gprop){ ?>
                 <div class="listing listing--grid properties--grid">
				 <?php
                 foreach($gprop as $j=>$prop){
					 
					 $this->display_single_property($prop);
				}
				?>
                </div>
				<?php
			}
		
		}
		?>
        </div>
        <?php	
	}
	private function display_single_property($prop){
		
		$prop_params[]="Rooms - ".$prop->rooms();
			$prop_params[]="Bathrooms - ".$prop->bathrooms();
			$prop_params[]="Bedrooms - ".$prop->bedrooms();
			
			
			
			$thumbnail=$prop->thumbnail();
			
			$tID=get_post_thumbnail_id($prop->id());
			
			if($tID){
				$th=wp_get_attachment_image_src($tID, array(300,300));
				if($th){
					$thumbnail=$th["url"];
				}
			}
			
			$location="";
			
			$locs=array();
			
			$location_details=$prop->location();
			
			if($location_details){
				
				foreach($location_details as $det){
					$locs[]=$det->name;	
				}
				
				$location=implode(',',$locs);
			}
			//print_r(get_class_methods($prop));
			
		?>
        <div class="listing__item">
    <div class="properties__item" data-sr-id="2" style="; visibility: visible;  -webkit-transform: translateY(0) scale(1); opacity: 1;transform: translateY(0) scale(1); opacity: 1;-webkit-transition: -webkit-transform 0.8s cubic-bezier(0.6, 0.2, 0.1, 1) 0s, opacity 0.8s cubic-bezier(0.6, 0.2, 0.1, 1) 0s; transition: transform 0.8s cubic-bezier(0.6, 0.2, 0.1, 1) 0s, opacity 0.8s cubic-bezier(0.6, 0.2, 0.1, 1) 0s; ">
              <div class="properties__thumb">
              <a href="<?php echo $prop->link(); ?>" class="item-photo">
                <img src="<?php echo $thumbnail; ?>" alt="<?php echo $prop->title(); ?>" style="max-height:250px !important">

                      <figure class="item-photo__hover item-photo__hover--params">
                      <?php foreach($prop_params as $param) { ?>
                        <span class="properties__params"><?php echo $param; ?></span>
                        <?php } ?>
                        
                            <span class="properties__intro ">
          <?php echo $this->get_ellipsis(wp_strip_all_tags($prop->content(),100)); ?>
        </span>
                    <span class="properties__time">Added date: <?php echo $prop->date(); ?></span>
            <span class="properties__more">View details</span>
    </figure>
  
                
      </a>
                    <span class="properties__ribon"><?php echo $prop->contract_type(); ?></span>
  
      </div>

      <!-- end of block .properties__thumb-->
      <div class="properties__info">
          
      <a href="<?php echo $prop->link(); ?>" class="properties__address ">
          <span class="properties__address-street"><?php echo $prop->title(); ?></span>
    <span class="properties__address-city"><?php echo $location; ?></span>
  
    </a>
  
        <!-- end of block .properties__param-->
        <hr class="divider--dotted properties__divider">
        <div class="properties__offer">
          <div class="properties__offer-column">
            <div class="properties__offer-value">
                    <strong>
    <?php echo $prop->price(); ?>
    </strong>

                    </div>
                </div>
            </div>
        </div>
        <!-- end of block .properties__info-->
    </div>

    <!-- end of block .properties__item-->
</div>
        <?php	
	}
	
	private function get_ellipsis($content,$length){
		if(strlen($content)>=$length){
			return substr($content,0,$length)."...";	
		}
		return $content;
	}
}

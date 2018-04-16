<?php
add_shortcode("sabian_tab_content", "sabian_sc_tab_content");

add_shortcode("sabian_tab", "sabian_sc_tab");


add_shortcode("sabian_list", "sabian_sc_list");

add_shortcode("sabian_list_item", "sabian_sc_list_item");


add_shortcode("sabian_iframe", "sabian_sc_iframe");

/*Tabs*/
/**
[sabian_tab_content]
[sabian_tab icon="user" title="Our Vision"]content[/sabian_tab]
[/sabian_tab_content]
*/
$GLOBALS["sabian_tab_count"]=909;

function sabian_sc_tab_content($attrs,$content){
	
	$cont='';
	
	$tab_id=++$GLOBALS["sabian_tab_count"];
	
	$GLOBALS["sabian_tab_contents_".$tab_id]=array();
	
	$GLOBALS["sabian_tab_links_".$tab_id]=array();
	
	ob_start();
	
	?>
    <div class="text_condesed" style="font-size: 15px;">
    <div class="tabs-framed mt-20">
    
    <?php do_shortcode($content); ?>
    
    <?php 
	
	$tab_links=$GLOBALS["sabian_tab_links_".$tab_id]; 
	
	
	?>
    
    <ul class="tabs clearfix">
    
    <?php 
	$count=0;
	
	foreach($tab_links as $link) {
		
		$is_first=$count==0;
		
		$active_class=($is_first)?"active":"";
		
		$cid='tab-'.$tab_id.'-'.$count.'';
		
		$GLOBALS["sabian_tab_contents_".$tab_id][]=array("id"=>$cid,"content"=>$link["content"]);
		
		?>
        <li class="tab_pane <?php echo $active_class; ?>"><a href="#<?php echo $cid; ?>" data-toggle="tab" aria-expanded="true"><i class="fa fa-<?php echo $link["icon"]; ?>"></i>&nbsp;<?php echo $link["title"]; ?></a></li>
        <?php
		
		$count++;	
	}
	
	
	
	unset($count);
	?>
    
    </ul>
    
    
    <div class="tab-content">
    
    <?php foreach($GLOBALS["sabian_tab_contents_".$tab_id] as $i=>$tabc){
		
		$is_first=$i==0;
		
		$active_class=($is_first)?"active in":"";
		
		?>
        <div id="<?php echo $tabc["id"]; ?>" class="tab-pane fade <?php echo $active_class; ?>">
<div class="tab-body">
<p><?php echo $tabc["content"]; ?></p>
</div>
</div>
        
        <?php
		
	}?>
    
    </div>
    
    
    
    </div>
    
    </div>
    
    <?php
	
	$cont=ob_get_contents();
	
	ob_end_clean();
	
	return $cont;
}

function sabian_sc_tab($attrs,$content){
	
	$cont='';
	
	$tab_id=$GLOBALS["sabian_tab_count"];
	
	if(!isset($GLOBALS["sabian_tab_links_".$tab_id])){
		
		return $cont;	
	}
	
	extract(shortcode_atts(array(
        "icon" => 'user',
		"title"=>"Tab".$tab_id
    ), $attrs));
	
	$GLOBALS["sabian_tab_links_".$tab_id][]=array("icon"=>$icon,"title"=>$title,"content"=>$content);
	
	return $cont;
}




/*Lists*/
/**
[sabian_list type="check/bullet/normal"]
[sabian_list_item figure="1" type="primary"]content[/sabian_list_item] Use figure and type for list type 'bullet'
[/sabian_list]
*/
$GLOBALS["sabian_list_count"]=909;

function sabian_sc_list($attrs,$content){
	
	extract(shortcode_atts(array(
        "type" => 'normal',
    ), $attrs));
	
	$cont='';
	
	$list_id=++$GLOBALS["sabian_list_count"];
	
	$GLOBALS["sabian_list_type_".$list_id]=$type;
	
	if($type=="normal"){
		$class="";
	}
	if($type=="check"){
		$class="list-check";	
	}
	if($type=="bullet"){
		$class="bullet";	
	}
	
	$cont='<ul class="'.$class.'">';
	
	$cont.=do_shortcode($content); 
    
    $cont.='</ul>';
	
	return $cont;
}

function sabian_sc_list_item($attrs,$content){
	
	extract(shortcode_atts(array(
        "figure" => '1',
		"type"=>"primary"
    ), $attrs));
	
	$list_id=$GLOBALS["sabian_list_count"];
	
	$cont='';
	
	if(!isset($GLOBALS["sabian_list_type_".$list_id])){
		return $cont;	
	}
	
	$stype=$GLOBALS["sabian_list_type_".$list_id];
	
	if($stype=="normal"){
		$cont.='<li>'.$content.'</li>';
	}
	if($stype=="check"){
		$cont.='<li><i class="fa fa-check"></i>'.$content.'</li>';	
	}
	if($stype=="bullet"){
		$cont.='<li>
		<figure class="'.$type.'"><span>'.$figure.'</span></figure>
                                <p>'.$content.'</p>
                            </li>';		
	}
	
	return $cont;
	
}

/*Iframes*/
/**
[sabian_iframe src="" height=""][/sabian_iframe]
*/
function sabian_sc_iframe($attrs,$content){
	
	extract(shortcode_atts(array(
        "src" => '#',
		'height'=>'257'
    ), $attrs));
	
	return '<div class="embed-responsive embed-responsive-16by9" style="height:'.$height.'">
	<iframe class="embed-responsive-item" src="'.$src.'"></iframe>
	</div>
	';
	
}
?>
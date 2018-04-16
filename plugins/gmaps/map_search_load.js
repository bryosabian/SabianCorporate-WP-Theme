// JavaScript Document
$(function()
{
	var sabian_map;
	
	var sabian_map_center;
	
	var sabian_location_form;
	
	var sabian_map_cont;
	
	var map_zoom=12;
	
	var marker_template;
	
	var markers=[];
	
	try{
		
		load_map();
		
		$(document).on("on.sabian.property.hover",function(e){
			
			display_property_marker(e.propID,e.hoverIn);
			
		});
		
	}catch(err){
		
		console.log("Maps Error " + err);	
	}
	
	function load_map()
	{
		sabian_map_cont=$("#sabian_map");
		
		marker_template=$(sabian_map_cont.attr("data-marker-template"));
		
		if(sabian_map_cont.attr("data-latitude")!=undefined && sabian_map_cont.attr("data-longitude") !=undefined)
		{
			sabian_map_center = new google.maps.LatLng(sabian_map_cont.attr("data-latitude"),  sabian_map_cont.attr("data-longitude"));
		}
		else
		{
			sabian_map_center = new google.maps.LatLng(-1.288290, 36.822460);
		}
		
		var googleMapOptions = 
			{ 
				center: sabian_map_center,
				
				zoom: map_zoom,
				
				zoomControlOptions: { style: google.maps.ZoomControlStyle.SMALL },
				
				scaleControl: true, 
				
				mapTypeId: google.maps.MapTypeId.ROADMAP // google map type
			};
			
			sabian_map = new google.maps.Map(document.getElementById("sabian_map"), googleMapOptions);
			
			sabian_map.addListener("dragend",function(){
				
				get_bound_positions();
				
			});
			
			load_properties();
	}
	function load_properties(){
		
		var props=[];
		
		var url=sabian_map_cont.attr("data-locale-url");
		
		var params=[];
		
		var mapLoader=$("#sabian_map_loader");
		
		mapLoader.show();
		
		$.getJSON(url,params).done(function(json){
			
			props=json;	
			
			$.each(props,function(i,prop){
				
				add_marker_item(prop);
				
			});
			
			mapLoader.fadeOut();
			
		}).fail(function(jqXR,textStatus,error){
			
			mapLoader.fadeOut();
		});
		
	}
	function add_marker_item(property)
	{
		var map=sabian_map;
		
		var position=new google.maps.LatLng(property.latitude, property.longitude);
		
		var sabian_marker,sabian_info_window;
		
		var dragable=false;
		
		var title="";
		
		var icon=sabian_map_cont.attr("data-icon");
		
		var animation=google.maps.Animation.DROP;
		
		var theContainer=build_info_container(property);
		
		sabian_location_form = theContainer;
				
		//Create an infoWindow
		sabian_info_window = new google.maps.InfoWindow();
		
		//set the content of infoWindow
		sabian_info_window.setContent(sabian_location_form[0]);
		
		sabian_marker=new google.maps.Marker({
			position: position,
			map: map,
			draggable:dragable,
			animation: animation,
			title:title,
			icon: icon
			
		});
			
		sabian_marker.sabian_data_id=property.id;
		
		sabian_marker.sabian_window=sabian_info_window;
		
		markers.push(sabian_marker);
		
		google.maps.event.addListener(sabian_marker, 'click', function() {
				sabian_info_window.open(sabian_map,sabian_marker); // click on marker opens info window
				
	    });
	}
	function build_info_container(property){
		
		var container=marker_template;
		
		container=$(container.html());
		
		container.find(".map_marker_image").attr("src",property.image);
		
		container.find(".map_marker_name").html(property.name);
		
		container.find(".map_marker_location").html(property.location);
		
		container.find(".map_marker_description").html(property.city + " " + property.country);
		
		container.find("a.map_marker_url").attr("href",property.url);
		
		return container;	
	}
	function get_bound_positions(){
		
		/*getBounds() : google.maps.Bounds*/
		var bounds=sabian_map.getBounds();
		
		var latLongs=[];
		
		for(var i=0; i<markers.length;i++){
			
			var marker=markers[i];
			
			/*getPosition() : google.maps.LatLng*/
			
			var position=marker.getPosition();
			
			if(bounds.contains(position)){
				
				latLongs.push(position);
			}
				
		}
		
		trigger_query_change(latLongs);
	}
	function display_property_marker(id,isHoverIn){
		
		var marker=get_property_marker(id);
		
		var inWindow=marker.sabian_window;
		
		if(isHoverIn){
			
			inWindow.open(sabian_map,marker);
			
			return;	
		}
		
		inWindow.close();
		
	}
	function get_property_marker(id){
		
		var marker=null;
		
		for(var i=0;i<markers.length;i++){
			
			var sMarker=markers[i];
			
			var did=sMarker.sabian_data_id;
			
			if(did==undefined)
			continue;
			
			if(did==id){
				
				marker=sMarker;
				
				break;
			}
		}
		
		return marker;
	}
	function trigger_query_change(latLongs){
		
		$.event.trigger({ type : "on.sabian.map.query", bounds : latLongs});
	}
	function get_current_location()
	{
		if (navigator.geolocation) {
			
			navigator.geolocation.getCurrentPosition(function(position) {
				
				var pos = {
					
					lat: position.coords.latitude,
					
					lng: position.coords.longitude
				};
				
				alert(pos.lat);
				
				/*infoWindow.setPosition(pos);
				
				infoWindow.setContent('Location found.');
				
				map.setCenter(pos);*/
			}, function() {
				alert("Not Found");
				
				});
				
				} 
				
				else {
					alert("Failed");
					}
	}
	
	
});
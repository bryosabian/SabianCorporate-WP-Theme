// JavaScript Document
var $=jQuery;

$(function()
{
	var map_zoom=12;
	
	var inp_location=$("input#place");
	
	var inp_city=$("input#city");
	
	var inp_country=$("input#country");
	
	var inp_longitude=$("input#longitude");
	
	var inp_latitude=$("input#latitude");
	
	var in_location=$("input#sabian_location_place");
	
	var in_city=$("input#sabian_location_city");
	
	var in_country=$("input#sabian_location_country");
	
	var in_longitude=$("input#sabian_location_longitude");
	
	var in_latitude=$("input#sabian_location_latitude");
	
	var sabian_map,sabian_marker,sabian_info_window;
	
	var sabian_map_center;
	
	var sabian_location_form;
	
	try{
		
		load_map();
		
		load_form_listeners();
		
	}catch(err){
		console.log("Maps Error " + err);	
	}
	
	
	function load_map()
	{
		var sabian_map_cont=$("#sabian_map");
		
		if(sabian_map_cont.length<=0)
		return;
		
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
			
			load_marker();
			
			load_search_map();
			
			$('a[href="#tab-location"]').on('shown.bs.tab', function(){
				google.maps.event.trigger(sabian_map, 'resize');
			});
		
		google.maps.event.addListener(sabian_marker, 'click', function() {
				sabian_info_window.open(sabian_map,sabian_marker); // click on marker opens info window 
	    });
	}
	function load_search_map()
	{
		var map=sabian_map;
		
		var input=(document.getElementById('sabian_map_search'));
		
		var autocomplete = new google.maps.places.Autocomplete(input);
		
		var marker=sabian_marker;
		
		map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
		
		autocomplete.bindTo('bounds', map);
		
		autocomplete.addListener('place_changed', function() {
			
			var place_search = autocomplete.getPlace();
			
			if (!place_search.geometry) {
				window.alert("Place Not Found");
				return;
				}
			
			if (place_search.geometry.viewport) 
			{
				map.fitBounds(place_search.geometry.viewport);
			}
			else
			{
				map.setCenter(place_search.geometry.location);
				map.setZoom(17);
			}
			marker.setPosition(place_search.geometry.location);
			
			load_geocoder(place_search.geometry.location);
			
			marker.setVisible(true);
		});
		
	}
	function load_marker()
	{
		var map=sabian_map;
		
		var position=sabian_map_center;
		
		var dragable=true;
		
		var title="";
		
		var icon="http://briansabana.co.ke/gmaps/icons/pin_blue.png";
		
		var animation=google.maps.Animation.DROP;
		
		sabian_location_form = $('<div class="sabian_marker_div"><p><div class="marker-edit">'+
				'<form method="POST" name="SaveMarker" id="SaveMarker">'+
				'<label for="pName"><span>Place Name :</span><input type="text" name="pName" id="sabian_place_name" class="save-name" placeholder="Enter Place Name" maxlength="40" /></label>'+
				'<label for="pDesc"><span>City :</span><input type="text" name="pCity" id="sabian_city_name" class="save-name" placeholder="Enter Title" maxlength="40" /></label>'+
				'<label for="pName"><span>County :</span><input type="text" name="pName" id="sabian_county_name" class="save-name" placeholder="Enter County" maxlength="40" /></label>'+
				'<label for="pType"><span>Country :</span> <input type="text" name="pCountry" class="save-name" id="sabian_country_name" placeholder="Enter Title" maxlength="40" /></label>'+
				'</form>'+
				/*'<a class="btn btn-primary" id="sabian_save_location">Save Location</a></div>'+*/
				'</div></p>');
				
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
			
			//add click listner to save marker button
		sabian_info_window.open(map,sabian_marker);
		
		load_geocoder(sabian_map_center);
		
		load_marker_events();
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
	function load_marker_events()
	{
		google.maps.event.addListener(sabian_marker,'dragend',function(event) {
			
			var lat=this.position.lat();
			
			var long=this.position.lng();
			
			var location=new google.maps.LatLng(lat,long);
			
			load_geocoder(location);
			
			
		});
	}
	function load_geocoder(location)
	{
		var geocoder=new google.maps.Geocoder();
		
		var position=location;
		
		geocoder.geocode({'latLng': position},function(results, status) 
		{
			if (status == google.maps.GeocoderStatus.OK) {
				
                if (results[1]) {
					var formated_res= results[0].formatted_address;
					
                    var addr=formated_res.split(",");
					
					var count=addr.length;
					
					var country=addr[count-1];
					
                    var city=addr[count-2];
					
                    var street=addr[count-3];
					
					set_info_details(street,city,country,position);
				}
			}
		});
	}
	function set_info_details(street,city,country,position)
	{
		var inp_loc_street=sabian_location_form.find('input#sabian_place_name');
		
		var inp_loc_city=sabian_location_form.find('input#sabian_city_name');
		
		var inp_loc_cnty=sabian_location_form.find('input#sabian_county_name');
		
		var inp_loc_country=sabian_location_form.find('input#sabian_country_name');
		
		/*var inp_loc_btn=sabian_location_form.find('a#sabian_save_location');*/
		
		inp_loc_street.val(street);
		
		inp_loc_city.val(city);
		
		inp_loc_cnty.val(city + " County");
		
		inp_loc_country.val(country);
		
		in_location.val($.trim(street));
		
		in_city.val($.trim(city));
		
		in_country.val($.trim(country));
		
		in_longitude.val(position.lng());
		
		in_latitude.val(position.lat());
	}
	function register_listener(input_parent,input_child)
	{
		input_parent.keyup(function(e) {
			
		var value=$(this).val();
		
		input_child.val(value);
		
		});
	}
	function load_form_listeners(){
		
		var inp_loc_street=sabian_location_form.find('input#sabian_place_name');
		
		var inp_loc_city=sabian_location_form.find('input#sabian_city_name');
		
		var inp_loc_cnty=sabian_location_form.find('input#sabian_county_name');
		
		var inp_loc_country=sabian_location_form.find('input#sabian_country_name');
		
		/*
		in_location.val($.trim(street));
		
		in_city.val($.trim(city));
		
		in_country.val($.trim(country));
		
		in_longitude.val(position.lng());
		
		in_latitude.val(position.lat());*/
		
		register_listener(inp_loc_street,in_location);
		
		register_listener(inp_loc_city,in_city);
		
		//register_listener(inp_loc_cnty,in_country);
		
		register_listener(inp_loc_country,in_country);
		
			
	}
	
	
	
});
// JavaScript Document
$(function()
{
	var sabian_map,sabian_marker,sabian_info_window;
	
	var sabian_map_center;
	
	var sabian_location_form;
	
	var sabian_map_cont;
	
	var map_zoom=12;
	
	var theContainer;
	
	try{
		
		load_map();
		
	}catch(err){
		console.log("Maps Error " + err);	
	}
	
	function load_map()
	{
		sabian_map_cont=$("#sabian_map");
		
		if(sabian_map_cont.length<=0)
		return;
		
		theContainer=sabian_map_cont.attr("data-map-window");
		
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
			
			$('a[href="#tab-location"]').on('shown.bs.tab', function(){
				google.maps.event.trigger(sabian_map, 'resize');
			});
		
		google.maps.event.addListener(sabian_marker, 'click', function() {
				sabian_info_window.open(sabian_map,sabian_marker); // click on marker opens info window 
	    });
	}
	
	function load_marker()
	{
		var map=sabian_map;
		
		var position=sabian_map_center;
		
		var dragable=false;
		
		var title="";
		
		var icon=sabian_map_cont.attr("data-icon");
		
		var animation=google.maps.Animation.DROP;
		
		sabian_location_form = $(theContainer);
				
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
					
					//set_info_details(street,city,country,position);
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
		
		var selPlace=sabian_map_cont.attr("data-place");
		
		var selCity=sabian_map_cont.attr("data-city");
		
		var selCountry=sabian_map_cont.attr("data-country");
		
		/*var inp_loc_btn=sabian_location_form.find('a#sabian_save_location');*/
		if(selPlace!=undefined)
		street=selPlace
		
		if(selCity!=undefined)
		city=selCity;
		
		if(selCountry!=undefined)
		country=selCountry;
		
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
});// JavaScript Document
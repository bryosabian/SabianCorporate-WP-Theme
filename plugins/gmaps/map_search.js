$(function(){
	
	load_window_fit();
	
	load_ajax_results(null);
	
	handle_map_query();
	
	$(window).resize(function(){
		
		load_window_fit();
	});
	
	function load_window_fit(){
		
		var topHeight=$("#sabian_map_section").position().top;
		
		var windowHeight=$(window).innerHeight();
		
		var theHeight=windowHeight-topHeight;
		
		$('.sabian_map').css({ "height" : theHeight });
		
		$('.sabian_property_collection').css({ "max-height" : theHeight });
		
		$('#sabian_loader').css({"height" : theHeight});
	}
	/*
	query = Array
	*/
	function load_ajax_results(query){
		
		var propContainer=$("#property_container");
		
		var loader=$("#sabian_loader");
		
		var url=propContainer.attr("data-source-url");
		
		var qdata=[];
		
		if(query!=null){
			
			qdata=query;
		}
		
		loader.show();
		
		$.ajax({
			
			url: url,
			
			type: "POST",
			
			data: qdata,
			
			cache: false,
			
			success: function(html) {
				
				propContainer.fadeIn(200,function(){
					
				propContainer.html(html);
			});
				
				loader.fadeOut();
				
				handle_property_hovers();
			},
			error:function(xhr, ajaxOptions, thrownError){
				
				console.log("Data Fetch Error " + thrownError);
				
				if(confirm("Failed to fetch data. Would you like to try again?"))
				load_ajax_results(query);
				
				loader.fadeOut();
			}
		});
	}
	function handle_map_query(){
		//$(document).trigger("on.sabian.map.query",{ " latLongs " : latLongs });
		
		$(document).on("on.sabian.map.query",function(e){
			
			var bounds=e.bounds;
			
			var latLongs=[];
			
			$.each(bounds,function(i,v){
				
				latLongs[i]={"latitude" : v.lat(), "longitude" : v.lng()};
				
			});
			
			
			var latParams=JSON.stringify(latLongs);
			
			var params={ "latlongs" : latParams };
			
			load_ajax_results(params);	
			
		});
	}
	function handle_property_hovers(){
		
		$(".sabian_property_item").each(function(index, element) {
            
			var _this=$(this);
			
			var id=_this.attr("data-id");
			
			_this.hover(function(e){
				
				//Hover In
				$.event.trigger({ type : "on.sabian.property.hover", propID : id, hoverIn:true });
				
			},function(e){
				
				//Hover Out
				$.event.trigger({ type : "on.sabian.property.hover", propID : id , hoverIn:false });
				
			});
			
        });
	}

});